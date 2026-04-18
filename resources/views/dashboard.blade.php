<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 text-green-600 font-bold">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-bold mb-4">Your Bookings</h3>
                    
                    @if($bookings->isEmpty())
                        <p>No bookings found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->room->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->check_in }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $booking->check_out }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $currencyService->format($booking->total_price) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
