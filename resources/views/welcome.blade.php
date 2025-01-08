<x-app-layout>

    @include('includes.breadcrums')


    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ session('status') }}
        </div>
    @endif        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <section class="section-login padding-tb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title bb-center" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="section-detail">
                            <h2 class="bb-title">Log <span>In</span></h2>
                            <p>Hi Welcome to umrosh buy your own Beautiful Glasses </p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="bb-login-contact" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="bb-login-wrap">
                                <label for="email">Email*</label>
                                <input type="email" id="email" name="email" placeholder="Enter Your Email" value="{{ old('email') }}" required>
                            </div>
                            <div class="bb-login-wrap">
                                <label for="password">Password*</label>
                                <input type="password" id="password" name="password" placeholder="Enter Your Password" required>
                            </div>

                            <div class="bb-login-button">
                                <button class="bb-btn-2" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif
    </script>

</x-app-layout>
