<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        $page_count = 0;

        if(count($brands) > 8){
            $brands = Brand::paginate(8,['*'],'brands');
            $page_count = $brands->count();
        }

        //return $page_count;

        return view('admin.brand.index', compact('brands', 'page_count'));
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

            Brand::create($input);

            return redirect()->back()->with(['success' => $input['name']." Brand added."]);
        }catch(\PDOException $e){
            return redirect()->back()->with(['error' => "Brand Exists."]);
        }catch(\QueryException $e){
            return redirect()->back()->with(['error' => "Brand Exists."]);
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
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
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

            $slug_check = Brand::whereSlug($input['slug'])->first();

            if(empty($slug_check)){
                $input['name'] = title_case($input['name']);

                $brand = Brand::findOrFail($id);
                $brand->update($input);

                return redirect('/brands')->with(['success' => $input['name']." Brand Updated."]);
            }else{
                return redirect()->back()->with(['error' => "Brand Exists."]);
            }

        }catch(\PDOException $e){
            return redirect()->back()->with(['error' => "Brand Exists."]);
        }catch(\QueryException $e){
            return redirect()->back()->with(['error' => "Brand Exists."]);
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
        Brand::findOrFail($id)->delete();

        return redirect()->back()->with(['cat_success' => "Brand Deleted."]);
    }
}
