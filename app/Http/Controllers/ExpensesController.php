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

        $paybills = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%'])
            ->sortable()
            ->simplePaginate(10);

        $total_paid_to_paybill = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%'])
            ->sum('withdrawn');
        // Format the total_withdrawn with commas
        $formatted_paid_to_paybill = number_format($total_paid_to_paybill, 2);

        return view('paybill', compact('paybills','formatted_paid_to_paybill'));

    }

    public function send_money()
    {
        $searchString = 'customer transfer to';

        $sent_money = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%'])
            ->sortable()
            ->simplePaginate(10);

        $total_sent = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%'])
            ->sum('withdrawn');

        // Format the total_withdrawn with commas
        $formatted_total_sent = number_format($total_sent);

        return view('send_money', compact('sent_money', 'formatted_total_sent'));

    }
    public function till()
    {
        $searchString = 'Merchant Payment';

        $till_payaments = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%'])
            ->sortable()
            ->simplePaginate(10);

        $total_till_payments = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%'])
            ->sum('withdrawn');

        // Format the total_withdrawn with commas
        $formatted_total_till_payments = number_format($total_till_payments);

        return view('till', compact('till_payaments', 'formatted_total_till_payments'));

    }
}
