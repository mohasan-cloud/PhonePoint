<x-admin-layout>
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="page-content">
            <div class="container-xxl">

                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($user) ? 'Edit User' : 'Create User' }}</li>
                    </ol>
                </nav>

                <div class="container-xl px-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h2 class="mb-0">{{ isset($user) ? 'Edit User' : 'Create User' }}</h2>
                        </div>
                        <div class="card-body">

                            <!-- Success Message -->
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Form -->
                            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                                @csrf
                                @if(isset($user))
                                    @method('PUT')
                                @endif

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $user->first_name ?? old('first_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="second_name" class="form-label">Second Name</label>
                                            <input type="text" name="second_name" id="second_name" class="form-control" value="{{ $user->second_name ?? old('second_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email ?? old('email') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone_number" class="form-label">Phone Number</label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number ?? old('phone_number') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="role" class="form-label">Role</label>
                                            <select name="role" id="role" class="form-select" required>

                                                @foreach ($roles as $role)
                                                @if (Auth::user()->hasRole('super admin') || (Auth::user()->hasRole('Admin') && $role->name == 'user'))
                                                    <option value="{{ $role->name }}" {{ (isset($user) && $user->hasRole($role->name)) ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endif
                                            @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        {{ isset($user) ? 'Update User' : 'Create User' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif
            });
        </script>
    @endpush

</x-admin-layout>
