<x-layout>
    <x-slot:heading>
        Send Money
    </x-slot:heading>
    <div class="w-full  px-4 py-4">
        <table class="table-fixed w-full border-collapse border border-gray-300">
                <thead >
                <tr>
                    <th class="py-2 text-center px-2" >@sortablelink('date', 'Date')</th>
                    <th class="py-2 text-center px-2" >Details</th>
                    <th class="py-2 text-center px-2">@sortablelink('withdrawn', 'Money Sent')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sent_money as $expense)
                    <tr class="bg-gray-50 border-b dark:bg-gray-800 ">

                        <td class="py-2 px-2 text-center">{{ $expense->formatted_date }}</td>
                        <td class="py-2 px-2">{{$expense->details}}</td>
                        <td class="py-2 text-center px-2">{{$expense->withdrawn}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div class="px-2 py-2">
                {{ $sent_money->appends(request()->except('page'))->links() }}
            </div>
        </div>
</x-layout>
