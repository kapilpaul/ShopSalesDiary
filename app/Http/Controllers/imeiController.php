<?php

namespace App\Http\Controllers;

use App\productIMEI;
use Illuminate\Http\Request;

class imeiController extends Controller
{
    public function edit($imei){
        $productIMEI = productIMEI::findOrFail($imei);


        return view('admin.stock.editImei', compact('productIMEI'));
    }
    public function update(Request $request, $id){

    }
}
