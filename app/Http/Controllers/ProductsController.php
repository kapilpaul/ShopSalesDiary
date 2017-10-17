<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Photo;
use App\Products;
use Illuminate\Http\Request;
use PDOException;
use QueryException;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        $page_count = 0;

        if(count($products) > 10){
            $products = Products::paginate(10,['*'],'products');
            $page_count = $products->count();
        }

        return view('admin.products.index', compact('products', 'page_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');

        return view('admin.products.create', compact('category', 'brands'));
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

            if($file = $request->file('photo_id')){

                $extension = $file->getClientOriginalExtension();

                if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
                    $name = time() . '_' . $file->getClientOriginalName();
                    $file->move('img', $name);
                    $photo = Photo::create(['photo' => $name]);
                    $input['photo_id'] = $photo->id;
                } else {
                    return redirect()->back()->with(['error' => "You can Only Upload Jpg, jpeg, png image"]);
                }
            }

            Products::create($input);

            return redirect()->back()->with(['success' => $input['name']." Product added."]);

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
        $product = Products::findOrFail($id);

        $category = Category::pluck('name', 'id');
        $brands = Brand::pluck('name', 'id');

        return view('admin.products.edit', compact('product', 'category', 'brands'));
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

            $product = Products::findOrFail($id);

            $input['name'] = title_case($input['name']);

            if($file = $request->file('photo_id')){

                $extension = $file->getClientOriginalExtension();

                if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
                    $photo = Photo::findOrFail($product->photo_id);

                    unlink(public_path() . $product->photo->photo);

                    $name = time() . '_' . $file->getClientOriginalName();
                    $file->move('img', $name);
                    $photo->update(['photo' => $name]);

                } else {
                    return redirect()->back()->with(['error' => "You can Only Upload Jpg, jpeg, png image"]);
                }
            }

            $input['photo_id'] = $product->photo_id;

            $product->update($input);

            return redirect()->back()->with(['success' => $input['name']." Product Updated."]);


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
        $product = Products::findOrFail($id);

        if($product->photo){
            $image = Photo::findOrFail($product->photo_id);
            $image->delete();
            unlink(public_path() . $product->photo->photo);
        }

        $product->delete();

        return redirect()->back()->with(['success' => $product->name.' is Deleted']);
    }
}
