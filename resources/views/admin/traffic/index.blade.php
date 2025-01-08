<x-admin-layout>

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Breadcrumbs -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Modules</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="container-xl px-4">
                <div class="card mb-4 shadow-sm border-light">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="m-0 text-primary">Traffic Analytics</h2>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-outline-primary btn-sm">Export Data</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Traffic Charts -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card border-light shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title text-center text-primary">Traffic by Location</h5>
                                        <canvas id="trafficByLocation"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-light shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title text-center text-primary">Traffic by Referrer</h5>
                                        <canvas id="trafficByReferrer"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Traffic Table -->
                        <div class="table-responsive mt-4">
                            <table class="table table-striped table-bordered" id="trafficTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>IP Address</th>
                                        <th>Location</th>
                                        <th>Referrer</th>
                                        <th>Duration (sec)</th>
                                        <th>Device</th>
                                        <th>Browser</th>
                                        <th>Visited At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trafficData as $data)
                                        <tr>
                                            <td>{{ $data->ip_address }}</td>
                                            <td>{{ $data->location }}</td>
                                            <td>{{ $data->referrer }}</td>
                                            <td>{{ $data->duration }}</td>
                                            <td>{{ $data->device }}</td>
                                            <td>{{ $data->browser }}</td>
                                            <td>{{ $data->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const trafficByLocation = document.getElementById('trafficByLocation').getContext('2d');
        const trafficByReferrer = document.getElementById('trafficByReferrer').getContext('2d');

        const locationChart = new Chart(trafficByLocation, {
    type: 'pie',
    data: {
        labels: @json($trafficData->pluck('location')->unique()),
        datasets: [{
            data: @json($trafficData->groupBy('location')->map->count()),
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ": " + tooltipItem.raw + " visits";
                    }
                }
            }
        }
    }
});


        const referrerChart = new Chart(trafficByReferrer, {
            type: 'doughnut',
            data: {
                labels: @json($trafficData->pluck('referrer')->unique()),
                datasets: [{
                    data: @json($trafficData->groupBy('referrer')->map->count()),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ": " + tooltipItem.raw + " visits";
                            }
                        }
                    }
                }
            }
        });
    </script>

</x-admin-layout>
