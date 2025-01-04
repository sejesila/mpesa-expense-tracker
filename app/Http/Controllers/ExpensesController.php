<?php

namespace App\Http\Controllers;

use App\Imports\ExpensesImport;
use App\Models\Expense;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpensesController extends Controller
{
    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate(['expenses' => 'required|file|mimes:xlsx,xls']);

        // Queue the import
        Excel::queueImport(new ExpensesImport, $request->file('expenses'));

        // Redirect with success message
        return redirect('/')->with('success', 'Import is being processed!');
    }
    public function paybill()
    {
        $searchString = 'pay bill to';

        $paybills = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%'])->paginate(50);;

        return view('components.paybill_table', compact('paybills'));

    }
    public function send_money()
    {
        $searchString = 'customer transfer to';

        $sent_money = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%'])->paginate(50);;

        return view('components.send_money_table', compact('sent_money'));

    }
}
