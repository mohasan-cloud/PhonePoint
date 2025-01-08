<x-admin-layout>

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">



                </div>
                <!-- Title Section -->


                <!-- Cards Area -->
                <div class="row mt-4 g-4" id="cards-container">
                    <!-- Dynamic cards will be appended here -->
                </div>



                <style>
                    .card {
                        transition: transform 0.2s;
                    }

                    .card:hover {
                        transform: scale(1.05);
                    }

                    .card-title {
                        font-size: 1.2rem;
                    }

                    .card h2 {
                        font-size: 2.5rem;
                    }
                </style>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


                <div class="row">

                    @can('todayearining')
                    <!-- Today's Earnings -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-calendar-day fa-3x text-danger"></i> <!-- Red icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Today's Earnings</h5>
                                    <h2 class="card-text">PKR{{ number_format($todayEarnings) }}</h2> <!-- Today's earnings -->
                                </div>
                            </div>
                            <canvas id="todayEarningsChart" height="100"></canvas>
                        </div>
                    </div>
                    @endcan
                    @can('weakeaning')
                    <!-- Weekly Earnings -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-calendar-week fa-3x text-warning"></i> <!-- Yellow icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Weekly Earnings</h5>
                                    <h2 class="card-text">PKR{{ number_format($weeklyEarnings) }}</h2> <!-- Weekly earnings -->
                                </div>
                            </div>
                            <canvas id="weeklyEarningsChart" height="100"></canvas>
                        </div>
                    </div>
                    @endcan
                    @can('totalearnign')

                        <!-- Total Earnings Card -->
                            <!-- This Month's Earnings Card with Chart -->
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card bg-light text-dark h-100 shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-money-bill-alt fa-3x text-success"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-2">This Month's Earnings</h5>
                                            <h2 class="card-text">{{ number_format($thisMonthEarnings, 2) }} PKR</h2>
                                        </div>
                                    </div>
                                    <!-- Chart for This Month Earnings -->
                                    <canvas id="thisMonthEarningsChart" height="100"></canvas>
                                </div>
                            </div>
                        
                            <!-- Last Month's Earnings Card with Chart -->
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card bg-light text-dark h-100 shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-chart-line fa-3x text-primary"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-2">Last Month's Earnings</h5>
                                            <h2 class="card-text">{{ number_format($lastMonthEarnings, 2) }} PKR</h2>
                                        </div>
                                    </div>
                                    <!-- Chart for Last Month Earnings -->
                                    <canvas id="lastMonthEarningsChart" height="100"></canvas>
                                </div>
                            </div>
                        
                            <!-- Today's Earnings Card with Chart -->
                          
                        <script>
                            // Chart for This Month's Earnings
                            var ctx1 = document.getElementById('thisMonthEarningsChart').getContext('2d');
                            var thisMonthEarningsChart = new Chart(ctx1, {
                                type: 'line',
                                data: {
                                    labels: @json(array_keys($thisMonthEarningsData->toArray())),  // Days of this month
                                    datasets: [{
                                        label: 'Earnings',
                                        data: @json(array_values($thisMonthEarningsData->toArray())),  // Earnings values
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        fill: false
                                    }]
                                }
                            });
                        
                            // Chart for Last Month's Earnings
                            var ctx2 = document.getElementById('lastMonthEarningsChart').getContext('2d');
                            var lastMonthEarningsChart = new Chart(ctx2, {
                                type: 'line',
                                data: {
                                    labels: @json(array_keys($lastMonthEarningsData->toArray())),  // Days of last month
                                    datasets: [{
                                        label: 'Earnings',
                                        data: @json(array_values($lastMonthEarningsData->toArray())),  // Earnings values
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        fill: false
                                    }]
                                }
                            });
                        
                            // Chart for Today's Earnings
                          
                        </script>
                        
                    
                        <!-- Today's Earnings Card -->
                       
                    
                    <!-- Total Earnings -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-dollar-sign fa-3x text-success"></i> <!-- Green icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Total Earnings</h5>
                                    <h2 class="card-text">PKR{{ number_format($totalEarnings) }}</h2> <!-- Display total earnings -->
                                </div>
                            </div>
                            <canvas id="earningsChart" height="100"></canvas>
                        </div>
                    </div>
                    @endcan
                    @can('totalbill')
                    <!-- Total Bills -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-file-invoice-dollar fa-3x text-info"></i> <!-- Blue icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Total Bills</h5>
                                    <h2 class="card-text">{{ $totalBills }}</h2>
                                </div>
                            </div>
                            <canvas id="billsChart" height="100"></canvas>
                        </div>
                    </div>
                    @endcan
                    @can('todaybill')
                    <!-- Today's Bills -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-calendar-day fa-3x text-danger"></i> <!-- Red icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Today's Bills</h5>
                                    <h2 class="card-text">{{ $todayBills }}</h2>
                                </div>
                            </div>
                            <canvas id="todayBillsChart" height="100"></canvas>
                        </div>
                    </div>
                    @endcan



                    @can('pendingbills')
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-calendar-day fa-3x text-danger"></i> <!-- Red icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Pending Bills Total</h5>
                                    <h2 class="card-text">{{ $pendingBillsTotal }}</h2>
                                </div>
                            </div>
                            <canvas id="todayBillsChart" height="100"></canvas>
                        </div>
                    </div>

@endcan

                    @can('weekbill')

                    <!-- Weekly Bills -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-calendar-week fa-3x text-warning"></i> <!-- Yellow icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Weekly Bills</h5>
                                    <h2 class="card-text">{{ $weeklyBills }}</h2>
                                </div>
                            </div>
                            <canvas id="weeklyBillsChart" height="100"></canvas>
                        </div>
                    </div>

                    @endcan
@can('totalusers')


                    <!-- Total Users -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-users fa-3x text-success"></i> <!-- Green icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Total Users</h5>
                                    <h2 class="card-text">{{ $totalUsers }}</h2>
                                </div>
                            </div>
                            <canvas id="usersChart" height="100"></canvas>
                        </div>
                    </div>
                    @endcan
                    <!-- Total Products -->
                    @can('totalproducts')


                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-boxes fa-3x text-primary"></i> <!-- Purple icon -->
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Total Products</h5>
                                    <h2 class="card-text">{{ $totalProducts }}</h2>
                                </div>
                            </div>
                            <canvas id="productsChart" height="100"></canvas>
                        </div>
                    </div>
                    
                    @endcan
                    @can('track expenses')
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div class="mr-3">
                                    <i class="fas fa-dollar-sign fa-3x text-success"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-2">Total Expenses</h5>
                                    <h2 class="card-text">{{ number_format($totalExpenses, 2) }} PKR</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expenses Breakdown -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-light text-dark h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">Expenses Breakdown</h5>
                                <ul class="list-unstyled">
                                    <li><strong>Last Month:</strong> {{ number_format($lastMonthExpenses, 2) }} PKR</li>
                                    <li><strong>This Month:</strong> {{ number_format($thisMonthExpenses, 2) }} PKR</li>
                                    <li><strong>Today:</strong> {{ number_format($todayExpenses, 2) }} PKR</li>
                                </ul>
                            </div>
                        </div>
                    </div>
@endcan

                </div>


<style>
    .card {
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    overflow: hidden; /* Ensure content stays inside */
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #333;
}

.card-text {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff; /* Use a color to match the theme */
}

.card-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.card-body .mr-3 {
    flex-shrink: 0;
}
</style>
        <!-- Bootstrap and Icons CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            var todayEarningsChart = new Chart(document.getElementById('todayEarningsChart'), {
    type: 'line',
    data: {
        labels: @json($todayBillsChartLabels),
        datasets: [{
            label: 'Today\'s Earnings',
            data: @json($todayBillsChartData),
            borderColor: 'rgba(255, 99, 132, 0.6)',
            fill: false
        }]
    }
});

var weeklyEarningsChart = new Chart(document.getElementById('weeklyEarningsChart'), {
    type: 'bar',
    data: {
        labels: @json($weeklyBillsChartLabels),
        datasets: [{
            label: 'Weekly Earnings',
            data: @json($weeklyBillsChartData),
            backgroundColor: 'rgba(255, 159, 64, 0.6)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1
        }]
    }
});

            var earningsChart = new Chart(document.getElementById('earningsChart'), {
    type: 'line',
    data: {
        labels: @json($billsChartLabels), // Reusing $billsChartLabels or you can create a new one
        datasets: [{
            label: 'Total Earnings',
            data: @json($earningsChartData), // The earnings data
            borderColor: 'rgba(40, 167, 69, 0.6)', // Green color
            fill: false
        }]
    }
});

            var billsChart = new Chart(document.getElementById('billsChart'), {
                type: 'line',
                data: {
                    labels: @json($billsChartLabels),
                    datasets: [{
                        label: 'Total Sales',
                        data: @json($billsChartData),
                        borderColor: 'rgba(0, 123, 255, 0.6)',
                        fill: false
                    }]
                }
            });

            var todayBillsChart = new Chart(document.getElementById('todayBillsChart'), {
                type: 'bar',
                data: {
                    labels: @json($todayBillsChartLabels),
                    datasets: [{
                        label: 'Today\'s Sales',
                        data: @json($todayBillsChartData),
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                }
            });

            var weeklyBillsChart = new Chart(document.getElementById('weeklyBillsChart'), {
                type: 'bar',
                data: {
                    labels: @json($weeklyBillsChartLabels),
                    datasets: [{
                        label: 'Weekly Sales',
                        data: @json($weeklyBillsChartData),
                        backgroundColor: 'rgba(255, 159, 64, 0.6)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                }
            });
        </script>

        <!-- Custom CSS -->
        <style>
            .card {
                border-radius: 10px;
            }

            .custom-card {
                background-color: #f8f9fa;
                border: 1px solid #ddd;
                border-radius: 10px;
                text-align: center;
                padding: 20px;
                transition: all 0.3s;
            }

            .custom-card:hover {
                background-color: #e9ecef;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            }

            #selection-info {
                font-size: 1rem;
            }
        </style>

        <!-- JavaScript -->
        <script>
            $(document).ready(function() {
                // Fetch user selection from backend
                $.ajax({
                    url: '{{ route('getUserSelection') }}',
                    method: 'GET',
                    success: function(response) {
                        if (response.industry_id && response.department_id) {
                            $('#selection-info').removeClass('d-none');
                            $('#selected-industry').text(response.industry_name);
                            $('#selected-department').text(response.department_name);
                            $('#select-button').hide();
                            $('#clear-selection').removeClass('d-none');
                            fetchAndDisplayCards(response.industry_id, response.department_id);
                        }
                    }
                });

                // Fetch departments when industry is selected
                $('#industry').on('change', function() {
                    const industryId = $(this).val();
                    $('#department').prop('disabled', true).html(
                        '<option value="" selected disabled>Loading...</option>');

                    if (industryId) {
                        $.ajax({
                            url: '{{ route('getDepartments') }}',
                            method: 'GET',
                            data: {
                                industry_id: industryId
                            },
                            success: function(response) {
                                let options =
                                    '<option value="" selected disabled>Select a Department</option>';
                                response.forEach(function(department) {
                                    options +=
                                        `<option value="${department.id}">${department.title}</option>`;
                                });
                                $('#department').html(options).prop('disabled', false).closest(
                                    '#department-container').show();
                            },
                            error: function() {
                                alert('Error fetching departments. Please try again.');
                            }
                        });
                    }
                });

                // Fetch and display cards when department is selected
                $('#department').on('change', function() {
                    const departmentId = $(this).val();
                    const industryId = $('#industry').val();
                    if (departmentId) {
                        fetchAndDisplayCards(industryId, departmentId);
                        $.ajax({
                            url: '{{ route('storeUserSelection') }}',
                            method: 'POST',
                            data: {
                                industry_id: industryId,
                                department_id: departmentId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                $('#selection-modal').modal('hide');
                                // Remove modal backdrop after closing
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open').css('overflow', 'auto');

                                $('#selection-info').removeClass('d-none');
                                $('#selected-industry').text($('#industry option:selected').text());
                                $('#selected-department').text($('#department option:selected')
                                    .text());
                                $('#select-button').hide();
                                $('#clear-selection').removeClass('d-none');
                            }
                        });
                    }
                });

                // Clear selection
                $('#clear-selection').on('click', function() {
                    $.ajax({
                        url: '{{ route('clearUserSelection') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            $('#cards-container').empty();
                            $('#selection-info').addClass('d-none');
                            $('#select-button').show();
                            $('#clear-selection').addClass('d-none');
                        }
                    });
                });

                function fetchAndDisplayCards(industryId, departmentId) {
                    $('#cards-container').html('<p class="text-center">Loading cards...</p>');
                    $.ajax({
                        url: '{{ route('getCards') }}',
                        method: 'GET',
                        data: {
                            department_id: departmentId,
                            industry_id: industryId
                        },
                        success: function(response) {
                            let cards = '';
                            response.cards.forEach(function(data) {
                                // Constructing the URL
                                let cardUrl = `${data.slug}`;
                                // Constructing the image URL (assuming images are in the public/images directory)
                                let imageUrl = data.image ? `{{ asset('') }}${data.image}` :
                                    '{{ asset('images/placeholder.jpg') }}';

                                cards += `


              <div class="col-md-6 col-lg-4">
    <a href="${cardUrl}" class="card-link" style="text-decoration: none;">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <div class="row d-flex justify-content-center border-dashed-bottom pb-3">
                    <div class="col-9">
                        <p class="text-dark mb-0 fw-semibold fs-14">${data.name}</p>
                    </div>
                    <!--end col-->

                    <div class="col-3 align-self-center">
                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                            <!-- Replace the icon with an image -->
                            <img src="${imageUrl}" alt="${data.name}" class="img-fluid rounded-circle" style="max-width: 60px;">
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </a>
</div>




               `;
                            });
                            $('#cards-container').html(cards);
                        },
                        error: function() {
                            alert('Error fetching cards. Please try again.');
                        }
                    });
                }

            });
        </script>
</x-admin-layout>
