@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">Welcome to KGFs ADMIN</h1>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-900">Overview Statistics</h2>
        </div>
        <!-- Overview Chart -->
        <canvas id="statsChart" class="w-full h-64"></canvas>
    </div>

    <!-- Handler Statistics Table -->
    @if(isset($handlerStats) && count($handlerStats) > 0)
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Handler Statistics</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Handler</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Birds Handled</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($handlerStats as $stat)
                    <tr>
                        <!-- Handler Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="{{ asset('storage/images/' . $stat['image']) }}" 
                                     alt="{{ $stat['name'] }}" 
                                     class="h-10 w-10 rounded-full object-cover">
                                <span class="ml-4 text-sm font-medium text-gray-900">{{ $stat['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $stat['position'] }}
                        </td>

                        <!-- Birds Handled with Hover Modal -->
                        <td class="px-6 py-4 whitespace-nowrap relative group">
                            <!-- Birds Handled Count -->
                            <span class="px-2 py-1 text-sm rounded-full {{ $stat['bird_count'] > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $stat['bird_count'] }} birds
                            </span>

                            <!-- Hover Modal -->
                            @if($stat['bird_count'] > 0)
                            <div class="absolute z-50 top-[90%] left-0 -mt-2 w-96 bg-white p-4 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                <h3 class="font-semibold text-gray-900 mb-3">Birds Handled by {{ $stat['name'] }}</h3>
                                <div class="max-h-60 overflow-y-auto">
                                    @foreach($stat['birds'] as $bird)
                                        <div class="flex items-center space-x-3 mb-2 p-2 hover:bg-gray-50 rounded">
                                            <img src="{{ asset('storage/images/' . $bird['image']) }}" 
                                                alt="{{ $bird['breed'] }}" 
                                                class="h-10 w-10 rounded-full object-cover"
                                                onerror="this.onerror=null; this.src='{{ asset('storage/images/default.jpg') }}'">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $bird['breed'] }}</div>
                                                <div class="text-xs text-gray-500">Owner: {{ $bird['owner'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Handlers', 'Birds'],
                datasets: [{
                    label: 'Total Count',
                    data: [{{ $workerCount }}, {{ $birdCount }}],
                    backgroundColor: ['rgba(59, 130, 246, 0.5)', 'rgba(16, 185, 129, 0.5)'],
                    borderColor: ['rgba(59, 130, 246, 1)', 'rgba(16, 185, 129, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endpush
