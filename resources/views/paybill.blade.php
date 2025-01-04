<x-layout>
    <x-slot:heading>
        Paybill Payments
    </x-slot:heading>
    <div>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="py-2 text-center px-2">@sortablelink('date', 'Date')</th>
                <th class="py-2 text-center px-2">@sortablelink('details', 'Details')</th>
                <th class="py-2 text-center px-2">@sortablelink('withdrawn', 'Paid Out')</th>
            </tr>
            </thead>
            <tbody class="">
            @foreach($paybills as $paybill)
                <tr class="bg-gray-50 border-b dark:bg-gray-800">
                    <td class="py-2 text-center px-2">{{$paybill->date}}</td>
                    <td class="py-2 px-2">{{$paybill->formatted_paybill}}</td>
                    <td class="py-2 text-center px-2">{{$paybill->withdrawn}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="px-2 py-2">
            {{$paybills->links()}}
        </div>
    </div>
    <div>
        <h1 class="text-center text-slate-800 uppercase px-4 py-4 decoration-4 underline decoration-dotted">Summary</h1>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="py-2 text-center px-2">Total Paid</th>

            </tr>
            </thead>
            <tbody>

            <tr class="bg-gray-50 border-b dark:bg-gray-800 ">

                <td class="py-2 px-2 text-left">{{ $formatted_paid_to_paybill }}</td>

            </tr>


            </tbody>
        </table>

    </div>
</x-layout>
