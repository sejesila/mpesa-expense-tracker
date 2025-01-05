<x-layout :routeName="$routeName">
    <x-slot:heading>
        Send Money
    </x-slot:heading>
    <div>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="py-2 text-center px-2">@sortablelink('date', 'Date')</th>
                <th class="py-2 text-center px-2">@sortablelink('details', 'Name')</th>
                <th class="py-2 text-center px-2">@sortablelink('withdrawn', 'Amount')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($total_received as $inflow)
                <tr class="bg-gray-50 border-b dark:bg-gray-800 ">

                    <td class="py-2 px-2 text-left">{{ $inflow->formatted_date }}</td>
                    <td class="py-2 px-2 text-center">{{ $inflow->formatted_details }}</td>
                    <td class="py-2 text-center px-2">{{$inflow->paid_in}}</td>

                </tr>
            @endforeach

            </tbody>
        </table>
        <div class="px-2 py-2">
            {{ $total_received->appends(request()->query())->links() }}
        </div>
    </div>
    <div>
        <h1 class="text-center text-slate-800 uppercase px-4 py-4 decoration-4 underline decoration-dotted">Summary</h1>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="py-2 text-center px-2">Total Received</th>

            </tr>
            </thead>
            <tbody>

            <tr class="bg-gray-50 border-b dark:bg-gray-800 ">

                <td class="py-2 px-2 text-left">{{ $formatted_total_received }}</td>

            </tr>


            </tbody>
        </table>

    </div>

</x-layout>
