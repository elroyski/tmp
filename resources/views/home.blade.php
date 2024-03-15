@extends('layouts.app')

@section('content')
    @isset($salesData)
        <canvas id="salesChart"></canvas>
        <script>
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($salesData->pluck('date')),
                    datasets: [{
                        label: 'Sprzedaż za ostatni miesiąc',
                        data: @json($salesData->pluck('sumIloscSztuk')),
                        backgroundColor: 'rgba(0, 123, 255, 0.5)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endisset
@endsection
