@extends('layouts.app')

@section('content')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-1/2 h-full mx-auto p-10 m-10">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Symbol
                </th>
                <th scope="col" class="px-6 py-3">
                    Price (USD)
                </th>
                <th scope="col" class="px-6 py-3">
                    Last Updated
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($cryptocurrencies as $crypto)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">{{ $crypto->name }}</td>
                    <td class="px-6 py-4">{{ $crypto->symbol }}</td>
                    <td class="px-6 py-4">{{ $crypto->price }}</td>
                    <td class="px-6 py-4">{{ $crypto->timestamp }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
