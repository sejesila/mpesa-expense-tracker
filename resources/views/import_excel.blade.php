@extends('layouts.app')
@section('content')

<div class="min-w-full mx-auto py-2 px-2">
    <div class="flex items-center justify-center m-2 p-2">
        <form action="{{route('import')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input  type="file" name="expenses" required>
            <button type="submit" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md">Import</button>
        </form>

    </div>
</div>
@endsection
