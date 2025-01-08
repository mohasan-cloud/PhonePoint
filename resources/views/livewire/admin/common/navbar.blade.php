<div class="topbar d-print-none">

    <div class="container-xxl">

        <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">





            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0 w-100">

                <!-- Mobile Menu Button -->

                <li class="me-3">

                    <button class="nav-link mobile-menu-btn nav-icon btn btn-light shadow-sm" id="togglemenu">

                        <i class="iconoir-menu-scale"></i>

                    </button>

                </li>



                <!-- Welcome Text, Clock, and Location -->

                <li class="me-3 flex-grow-1">

                    <div class="d-flex align-items-center justify-content-between flex-wrap">

                        <!-- Greeting Section -->

                        <h3 class="mb-0 fw-bold text-truncate me-3" id="greeting">

                            Welcome, {{ auth()->user()->name }}!

                        </h3>



                        <!-- Clock and Location -->

                        <span id="live-clock" class="text-muted me-3"></span>

                        <span id="location" class="text-muted"></span>

                    </div>

                </li>





                <!-- Industry & Department -->





                <!-- Buttons -->









            <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">





                <li class="topbar-item">

                    <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">

                        <i class="icofont-moon dark-mode"></i>

                        <i class="icofont-sun light-mode"></i>

                    </a>

                </li>

                <li class="dropdown topbar-item position-relative">
                    <a class="nav-link dropdown-toggle arrow-none nav-icon p-0 show" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                        <!-- Dynamic User Avatar -->
                        <img src="{{  asset('/admin_assets/images/users/avatar-1.jpg') }}" alt="User Avatar" class="thumb-lg rounded-circle border border-light shadow-sm">
                    </a>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-lg overflow-hidden" aria-labelledby="navbarDropdown" style="min-width: 250px;">
                        <!-- User Info Section -->
                        <li class="bg-light text-center p-3 border-bottom">
                            <img src="{{  asset('/admin_assets/images/users/avatar-1.jpg') }}" alt="User Avatar" class="thumb-md rounded-circle mb-2">
                            <h6 class="my-1 fw-bold text-dark fs-14">{{ auth()->user()->name }}</h6>
                            <small class="text-muted">
                                {{ auth()->user()->email }}
                            </small>
                                                    </li>

                        <!-- Divider -->
                        <li><hr class="dropdown-divider my-0"></li>

                        <!-- Logout -->
                        <li>
                            <a class="dropdown-item text-danger d-flex align-items-center py-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="las la-power-off fs-18 me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const dropdownToggle = document.getElementById('navbarDropdown');
                    const dropdownMenu = document.querySelector('.dropdown-menu');

                    // Ensure the dropdown hides when clicking outside of it
                    document.addEventListener('click', function(e) {
                        if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                            if (dropdownMenu.classList.contains('show')) {
                                dropdownMenu.classList.remove('show');
                            }
                        }
                    });

                    // Handle dropdown toggle animation
                    dropdownToggle.addEventListener('click', function() {
                        if (dropdownMenu.classList.contains('show')) {
                            dropdownMenu.classList.remove('show');
                        } else {
                            dropdownMenu.classList.add('show');
                        }
                    });

                    // Optional: Add hover effect for better UX
                    dropdownToggle.addEventListener('mouseover', function() {
                        dropdownMenu.classList.add('show');
                    });

                    dropdownToggle.addEventListener('mouseout', function() {
                        setTimeout(function () {
                            if (!dropdownMenu.matches(':hover')) {
                                dropdownMenu.classList.remove('show');
                            }
                        }, 200);
                    });

                    dropdownMenu.addEventListener('mouseleave', function () {
                        dropdownMenu.classList.remove('show');
                    });
                });
                </script>








            </ul><!--end topbar-nav-->

        </nav>

        <!-- end navbar-->

    </div>

</div>

<script> document.addEventListener('DOMContentLoaded', function () {

    // Update the greeting and clock

    function updateClockAndGreeting() {

        const now = new Date();

        const hours = now.getHours();

        const minutes = now.getMinutes();

        const seconds = now.getSeconds();



        // Update clock

        const timeString = `${hours.toString().padStart(2, '0')}:${minutes

            .toString()

            .padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        document.getElementById('live-clock').textContent = `Time: ${timeString}`;



        // Update greeting

        let greeting;

        if (hours < 12) {

            greeting = "Good Morning";

        } else if (hours < 18) {

            greeting = "Good Afternoon";

        } else {

            greeting = "Good Evening";

        }

        document.getElementById('greeting').textContent = `${greeting}, {{ auth()->user()->name }}!`;

    }



    // Get location

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(

            function (position) {

                const { latitude, longitude } = position.coords;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)

                    .then(response => response.json())

                    .then(data => {

                        const location = data.address.city || data.address.state || data.address.country;

                        document.getElementById('location').textContent = ` | Location: ${location}`;

                    })

                    .catch(() => {

                        document.getElementById('location').textContent = ` | Location: Unavailable`;

                    });

            },

            function () {

                document.getElementById('location').textContent = ` | Location: Unavailable`;

            }

        );

    } else {

        document.getElementById('location').textContent = ` | Location: Unavailable`;

    }



    // Initialize clock and greeting

    updateClockAndGreeting();

    setInterval(updateClockAndGreeting, 1000); // Update every second

});</script>

