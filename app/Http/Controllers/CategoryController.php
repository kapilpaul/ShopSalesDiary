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
        $page_count = 0;

        if(count($categories) > 10){
            $categories = Category::paginate(10,['*'],'cat');
            $page_count = $categories->count();
        }

        //return $page_count;

        return view('admin.category.index', compact('categories', 'page_count'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
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

            $slug_check = Category::whereSlug($input['slug'])->first();

            if(empty($slug_check)){
                $input['name'] = title_case($input['name']);

                $category = Category::findOrFail($id);
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
}
