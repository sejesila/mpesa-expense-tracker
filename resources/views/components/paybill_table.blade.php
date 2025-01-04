<x-layout>
    <x-slot:heading>
        Paybill Payments
    </x-slot:heading>
    <div class="w-full  px-4 py-4">
        <table class="table-fixed w-full border-collapse border border-gray-300">
            <thead>
            <tr>

                <th class="py-2 text-center px-2" >@sortablelink('date', 'Date')</th>
                <th class="py-2 text-center px-2" >Details</th>
                <th class="py-2 text-center px-2">@sortablelink('withdrawn', 'Paid Out')</th>
            </tr>
            </thead>
            <tbody class="">
            @foreach($paybills as $paybill)
            <tr class="bg-gray-50 border-b dark:bg-gray-800">
                <td class="py-2 text-center px-2">{{$paybill->date}}</td>
                <td class="py-2 px-2">{{$paybill->details}}</td>
                <td class="py-2 text-center px-2">{{$paybill->withdrawn}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="px-2 py-2">
            {{$paybills->links()}}
        </div>
    </div>
</x-layout>
