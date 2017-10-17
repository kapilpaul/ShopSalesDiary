<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Sells;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function sells(){

        $monthly_sales = $this->sellsReport();

        $years = $this->years();

        return view('admin.reports.sells', compact('monthly_sales', 'years'));
    }



    public function sellsReport(){
        // Get year
        $year = request('year');
        if (empty($year)) {
            $year = Carbon::now()->year;
        }
        $years = $monthly_sales = [];

        for($i=1; $i<=12; $i++){
            $monthly_sales[] = Sells::whereMonth('created_at', $i)->whereYear('created_at', $year)->sum('total_amount');
        }


        return $monthly_sales;
    }



    public function expense(){
        $monthly_expense = $this->expenseReport();

        $years = $this->years();

        return view('admin.reports.expense', compact('monthly_expense', 'years'));
    }



    public function expenseReport(){
        // Get year
        $year = request('year');
        if (empty($year)) {
            $year = Carbon::now()->year;
        }
        $years = $monthly_expense = [];

        for($i=1; $i<=12; $i++){
            $monthly_expense[] = Expense::whereMonth('date', $i)->whereYear('date', $year)->sum('amount');
        }

        return $monthly_expense;
    }





    public function sellsVsExpense(){
        $monthly_sales = $this->sellsReport();
        $monthly_expense = $this->expenseReport();

        $total = [];
        for($i=0; $i<12; $i++){
            $total[] = $monthly_sales[$i] - $monthly_expense[$i];
        }

        $years = $this->years();

        return view('admin.reports.sellsVsExpense', compact('monthly_sales', 'monthly_expense', 'years', 'total'));
    }


    public function years(){
        $years = [];
        $currentYear = Carbon::now()->year;

        for($i=$currentYear;$i>=2010;$i--){
            $years[$i] = $i;
        }

        return $years;
    }
}
