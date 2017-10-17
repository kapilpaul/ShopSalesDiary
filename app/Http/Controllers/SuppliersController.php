<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Supplier;
use Illuminate\Http\Request;
use PDOException;
use QueryException;
use TokenMismatchException;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        $brands = Brand::pluck('name', 'id');
        $page_count = 0;

        if(count($suppliers) > 8){
            $suppliers = Supplier::paginate(8,['*'],'supplier');
            $page_count = $suppliers->count();
        }

        //return $page_count;

        return view('admin.suppliers.index', compact('suppliers', 'page_count', 'brands'));
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
        $this->validate($request, [
            'name' => 'required',
            'phone_no' => 'required'
        ]);

        try{
            $input = $request->all();

            $phone_no_check = Supplier::wherePhoneNo($request->phone_no)->first();

            if(empty($phone_no_check)){

                $input['name'] = title_case($input['name']);
                $supplier = Supplier::create($input);

                foreach ($input['brand_id'] as $brand_id){
                    $brand = Brand::findOrFail($brand_id);
                    $supplier->brands()->attach($brand->id);
                }

                return redirect()->back()->with(['success' => $input['name']." Added As Supplier."]);
            }else{
                return redirect()->back()->with(['error' => "Supplier Exists."]);
            }
        }catch(TokenMismatchException $e){
            return redirect('/suppliers');
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
        $supplier = Supplier::findOrFail($id);
        $brands = Brand::pluck('name', 'id');
        $brand_ids = array();

        foreach ($supplier->brands as $brand_id){
            $brand_ids[] = $brand_id->id;
        }

        return view('admin.suppliers.edit', compact('supplier', 'brands', 'brand_ids'));
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
        $this->validate($request, [
            'name' => 'required',
            'phone_no' => 'required'
        ]);

        try{
            $input = $request->all();

            $input['name'] = title_case($input['name']);
            $supplier = Supplier::findOrFail($id);
            $supplier->update($input);
            $supplier->brands()->detach();

            foreach ($input['brand_id'] as $brand_id){
                $brand = Brand::findOrFail($brand_id);
                $supplier->brands()->attach($brand->id);
            }

            return redirect()->back()->with(['success' => $input['name']." Updated."]);

        }catch(PDOException $e){
            return redirect()->back()->with(['error' => "Supplier or Phone No Already Exists."]);
        }catch(QueryException $e){
            return redirect()->back()->with(['error' => "Supplier or Phone No Already Exists."]);
        }catch(TokenMismatchException $e){
            return redirect('/suppliers');
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
        Supplier::findOrFail($id)->delete();
        return redirect()->back()->with(['delete_success' => "Supplier Deleted."]);
    }
}
