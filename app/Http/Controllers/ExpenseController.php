<?php

namespace App\Http\Controllers;

use App\Expence;
use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use PDOException;
use QueryException;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::orderBy('date', 'desc')->get();
        $page_count = 0;

        if(count($expenses) > 15){
            $expenses = Expense::paginate(15,['*'],'expenses');
            $page_count = $expenses->count();
        }
        return view('admin.expenses.index', compact('expenses', 'page_count'));
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
                'amount' => 'required|numeric',
                'date' => 'required',
            ]);

            $input = $request->all();

            Expense::create($input);

            return redirect()->back()->with(['success' => $input['name']." Expense added."]);
        }catch(PDOException $e){
            return redirect()->back()->with(['error' => "Brand Exists."]);
        }catch(QueryException $e){
            return redirect()->back()->with(['error' => "Brand Exists."]);
        }catch (TokenMismatchException $e){
            return redirect()->back()->with(['error' => "Please Enter Again. Token Expired"]);
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
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('admin.expenses.edit', compact('expense'));
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
                'amount' => 'required|numeric',
                'date' => 'required',
            ]);
            $expense = Expense::findOrFail($id);
            $input = $request->all();

            $expense->update($input);

            return redirect()->back()->with(['success' => $input['name']." Expense Updated."]);
        }catch(PDOException $e){
            return redirect()->back()->with(['error' => "Brand Exists."]);
        }catch(QueryException $e){
            return redirect()->back()->with(['error' => "Brand Exists."]);
        }catch (TokenMismatchException $e){
            return redirect()->back()->with(['error' => "Please Enter Again. Token Expired"]);
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
        Expense::findOrFail($id)->delete();

        return redirect()->back()->with(['exp_success' => "Expense Deleted."]);
    }

    public function deleteAll($ids)
    {
        //$ids = $request->ids;
        //DB::table("products")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=> $ids]);

    }
}
