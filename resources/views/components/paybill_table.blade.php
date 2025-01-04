@extends('layouts.app')
@section('content')


<div class="w-full max-w-4xl px-4 py-4">
    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead class="flex items-center justify-between">
        <tr class="flex items-center justify-center">
            <th class="text-center py-2 px-2">Date</th>
            <th class="py-2 text-center px-2" >Details</th>
            <th class="py-2 text-center px-2">Paid Out</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paybills as $paybill)
        <tr class="bg-gray-50 border-b dark:bg-gray-800 ">
            <td class="py-2 px-2">{{$paybill->date}}</td>
            <td class="py-2 px-2">{{$paybill->details}}</td>
            <td class="py-2 px-2">{{$paybill->withdrawn}}</td>
        </tr>
        @endforeach


        </tbody>
    </table>
    <div class="px-2 py-2">
        {{$paybills->links()}}
    </div>
</div>
@endsection
