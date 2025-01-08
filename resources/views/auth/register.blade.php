<x-app-layout>
    @include('includes.breadcrums')

    <section class="section-register padding-tb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bb-register" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-title bb-center">
                                    <div class="section-detail">
                                        <h2 class="bb-title">Register</h2>
                                        <p>Hi! Welcome to Umrosh. Register now and buy your own beautiful glasses.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <form id="signupForm">
                                    @csrf
                                    <div class="bb-register-wrap bb-register-width-50">
                                        <label>First Name*</label>
                                        <input type="text" name="firstname" placeholder="Enter your first name" required>
                                    </div>
                                    <div class="bb-register-wrap bb-register-width-50">
                                        <label>Last Name*</label>
                                        <input type="text" name="lastname" placeholder="Enter your last name" required>
                                    </div>
                                    <div class="bb-register-wrap bb-register-width-50">
                                        <label>Email*</label>
                                        <input type="email" name="email" placeholder="Enter your email" required>
                                    </div>
                                    <div class="bb-register-wrap bb-register-width-50">
                                        <label>Phone Number*</label>
                                        <input type="number" name="phonenumber" placeholder="Enter your phone number" required>
                                    </div>
                                    <div class="bb-register-wrap bb-register-width-50">
                                        <label>Address*</label>
                                        <input type="text" name="address" placeholder="Enter your address" required>
                                    </div>
                                    <div class="bb-register-wrap bb-register-width-50">
                                        <label>City*</label>
                                        <input type="text" name="city" placeholder="Enter your city name" required>
                                    </div>
                                    <div class="bb-register-wrap bb-register-width-50">
                                        <label>Post Code*</label>
                                        <input type="number" name="post_code" placeholder="Enter your post code" required>
                                    </div>
                                    <div class="bb-register-wrap bb-register-width-50">
                                        <label>Password*</label>
                                        <input type="password" name="password" placeholder="Enter your Password" required>
                                    </div>
                                    <div class="bb-register-button">
                                        <button type="submit" class="bb-btn-2">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Email Verification Modal -->
    <div id="emailVerificationModal" class="modal fade" tabindex="-1" aria-labelledby="emailVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailVerificationModalLabel">Email Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please enter the verification PIN sent to your email:</p>
                    <input type="email" id="verificationEmail" class="form-control mb-3" placeholder="Enter your email" required>
                    <input type="text" id="verificationPin" class="form-control mb-3" placeholder="Enter your PIN" required>
                </div>
                <div class="modal-footer">
                    <button id="verifyEmailButton" class="btn btn-primary">Verify</button>
                </div>
            </div>
        </div>
    </div>

    <script>
       document.getElementById('signupForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('{{ route("signup.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
        .then(response => {
            // Check if the response is JSON
            if (response.headers.get('content-type')?.includes('application/json')) {
                return response.json();
            } else {
                throw new Error('Server returned an invalid response');
            }
        })
        .then(data => {
            if (data.message) {
                alert(data.message);
                const modal = new bootstrap.Modal(document.getElementById('emailVerificationModal'));
                modal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
});

document.getElementById('verifyEmailButton').addEventListener('click', function () {
    const email = document.getElementById('verificationEmail').value;
    const pin = document.getElementById('verificationPin').value;

    fetch('{{ route("signup.verify") }}', {
        method: 'POST',
        body: JSON.stringify({ email, pin }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
        .then(response => {
            if (response.headers.get('content-type')?.includes('application/json')) {
                return response.json();
            } else {
                throw new Error('Server returned an invalid response');
            }
        })
        .then(data => {
            alert(data.message);
            if (data.message === 'Email verified successfully!') {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
});

    </script>
</x-app-layout>
