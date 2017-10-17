<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use PDOException;
use QueryException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $trashed = Category::onlyTrashed()->get();
        $page_count = 0;

        if(count($categories) > 10){
            $categories = Category::paginate(10,['*'],'cat');
            $page_count = $categories->count();
        }

        //return $page_count;

        return view('admin.category.index', compact('categories', 'trashed', 'page_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'name' => 'required',
            ]);

            $input = $request->all();

            $input['slug'] = str_slug($input['name'], '-');
            $input['name'] = title_case($input['name']);

            Category::create($input);

            return redirect()->back()->with(['success' => $input['name']." Category added."]);
        }catch(PDOException $e){
            return redirect()->back()->with(['error' => "Category Exists."]);
        }catch(QueryException $e){
            return redirect()->back()->with(['error' => "Category Exists."]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $this->validate($request, [
                'name' => 'required',
            ]);

            $input = $request->all();

            $input['slug'] = str_slug($input['name'], '-');

            $slug_check = Category::whereSlug($input['slug'])->withTrashed()->first();

            if(empty($slug_check)){
                $input['name'] = title_case($input['name']);

                $category = Category::withTrashed()->findOrFail($id);
                $category->update($input);

                return redirect('/admin/category')->with(['success' => $input['name']." Category Updated."]);
            }else{
                return redirect()->back()->with(['error' => "Category Exists."]);
            }

        }catch(PDOException $e){
            return redirect()->back()->with(['error' => "Category Exists."]);
        }catch(QueryException $e){
            return redirect()->back()->with(['error' => "Category Exists."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return redirect('/admin/category')->with(['cat_success' => "Category Deleted."]);
    }




    /**
     * deleted all rooms for restore
     */
    public function deletedCategory()
    {
        $categories = Category::onlyTrashed()->get();
        $page_count = 0;

        if(count($categories) > 10) {
            $categories      = Category::onlyTrashed()->paginate(10,['*'],'category');
            $page_count = $categories->count();
        }

        return view('admin.category.softdeleted', compact('categories', 'page_count'));
    }

    /**
     * deleted all rooms for restore
     */
    public function restore($id)
    {
        $categories = Category::withTrashed()->find($id)->restore();

        return redirect('/admin/category')->with(['success' => ' Room Restored']);
    }

    /**
     * restore all rooms
     */
    public function restoreallCategory()
    {
        $categories = Category::withTrashed()->restore();

        return redirect('/admin/category')->with(['success' => ' Rooms Restored']);
    }
}
