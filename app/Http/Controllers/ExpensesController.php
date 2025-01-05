<?php

namespace App\Http\Controllers;

use App\Imports\ExpensesImport;
use App\Models\Expense;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExpensesController extends Controller
{
    public function import(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        // Validate the uploaded file
        $request->validate(['expenses' => 'required|file|mimes:xlsx,xls']);

        // Queue the import
        Excel::queueImport(new ExpensesImport, $request->file('expenses'));

        // Redirect with success message
        return redirect('/')->with('success', 'Import is being processed!');
    }

    function getExpenses($searchString, $search = null)
    {
        $query = Expense::whereRaw('LOWER(details) LIKE ?', ['%' . strtolower($searchString) . '%']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('details', 'LIKE', "%{$search}%")
                    ->orWhere('date', 'LIKE', "%{$search}%")
                    ->orWhere('withdrawn', 'LIKE', "%{$search}%")
                    ->orWhere('paid_in', 'LIKE', "%{$search}%");
            });
        }

        $total = $query->sum('withdrawn');
        $formattedTotal = number_format($total, 2);

        return [
            'query' => $query,
            'formattedTotal' => $formattedTotal
        ];
    }

    public function paybill(Request $request)
    {
        // Usage for 'pay bill to'
        $searchString = 'pay bill to';
        $search = $request->input('search', null);
        $result = $this->getExpenses($searchString, $search);
        $paybills = $result['query']->sortable()->simplePaginate(10);
        $formatted_paid_to_paybill = $result['formattedTotal'];
        $routeName = 'paybill';

        return view('paybill', compact('paybills', 'formatted_paid_to_paybill', 'routeName'));

    }

    public function send_money(Request $request)
    {
        $searchString = 'customer transfer to';
        $search = $request->input('search', null);
        $result = $this->getExpenses($searchString, $search);
        $total_sent = $result['query']->sortable()->simplePaginate(8);
        $formatted_total_sent = $result['formattedTotal'];
        $routeName = 'send_money';

        return view('send_money', compact('total_sent', 'formatted_total_sent', 'routeName'));
    }
    public function received_money(Request $request)
    {
        $searchString = 'funds received from';
        $search = $request->input('search', null);
        $result = $this->getExpenses($searchString, $search);
        $total_received = $result['query']->sortable()->simplePaginate(8);
        $formatted_total_received = $result['formattedTotal'];
        $routeName = 'received_money';

        return view('received_money', compact('total_received', 'formatted_total_received', 'routeName'));
    }

    public function till(Request $request)
    {
        // Usage for 'Merchant Payment'
        $searchString = 'Merchant Payment';
        $search = $request->input('search', null);
        $result = $this->getExpenses($searchString, $search);
        $till_payments = $result['query']->sortable()->simplePaginate(8);
        $formatted_total_till_payments = $result['formattedTotal'];
        $routeName = 'till';

        return view('till', compact('till_payments', 'formatted_total_till_payments', 'routeName'));
    }

}
