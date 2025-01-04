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
    public function paybill(Request $request)
    {
        $searchString = 'pay bill to';
        $query = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('details', 'LIKE', "%{$search}%")
                    ->orWhere('date', 'LIKE', "%{$search}%")
                    ->orWhere('withdrawn', 'LIKE', "%{$search}%")
                    ->orWhere('paid_in', 'LIKE', "%{$search}%");
            });
        }

        $paybills = $query->sortable()->simplePaginate(10);

        $total_paid_to_paybill = $query->sum('withdrawn');
        $formatted_paid_to_paybill = number_format($total_paid_to_paybill, 2);
        $routeName = 'paybill';

        return view('paybill', compact('paybills', 'formatted_paid_to_paybill','routeName'));

    }

    public function send_money(Request $request)
    {
        $searchString = 'customer transfer to';
        $query = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%']);

        if ($request->has('search')) {
            $search = $request->input('search');
            \Log::info('Search query: ' . $search);
            $query->where(function($q) use ($search) {
                $q->where('details', 'LIKE', "%{$search}%")
                    ->orWhere('date', 'LIKE', "%{$search}%")
                    ->orWhere('withdrawn', 'LIKE', "%{$search}%")
                    ->orWhere('paid_in', 'LIKE', "%{$search}%");
            });
        }

        $sent_money = $query->sortable()->simplePaginate(10);

        $total_sent = $query->sum('withdrawn');
        $formatted_total_sent = number_format($total_sent);

        $routeName = 'send_money';

        return view('send_money', compact('sent_money', 'formatted_total_sent', 'routeName'));
    }
    public function till(Request $request)
    {
        $searchString = 'Merchant Payment';
        $query = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%']);

        if ($request->has('search')) {
            $search = $request->input('search');
            \Log::info('Search query: ' . $search);
            $query->where(function($q) use ($search) {
                $q->where('details', 'LIKE', "%{$search}%")
                    ->orWhere('date', 'LIKE', "%{$search}%")
                    ->orWhere('withdrawn', 'LIKE', "%{$search}%")
                    ->orWhere('paid_in', 'LIKE', "%{$search}%");
            });
        }

        $till_payaments = $query->sortable()->simplePaginate(10);


        $total_till_payments = $query->sum('withdrawn');
        $formatted_total_till_payments = number_format($total_till_payments);

        $routeName = 'till';

        return view('till', compact('till_payaments', 'formatted_total_till_payments', 'routeName'));
    }

}
