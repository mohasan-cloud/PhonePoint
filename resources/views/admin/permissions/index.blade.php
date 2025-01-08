<x-admin-layout>
    <div class="col-md-12 px-4">
        <!-- Start page title and breadcrumbs -->
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End page title and breadcrumbs -->

        <!-- Start card -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">
                        <h5>{{ __('Permissions List') }}</h5>
                    </div>
                    <div class="col-md-2 text-end">
                        <a class="btn btn-primary btn-sm" href="{{ url('admin/permissions/create') }}">{{ __('Add New Permission') }}</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Flash message -->
                @if(session()->has('message.added'))
                    <div class="alert alert-{!! session('message.added') !!} alert-dismissible fade show" role="alert">
                        <strong>{{ __('Congratulations') }}!</strong> {!! session('message.content') !!}.
                    </div>
                @endif

                <!-- Permissions Table -->
                <table class="table table-bordered" id="table-permissions">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Guard') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                                <td>
                                    <a class="btn btn-icon btn-transparent-dark me-2" href="{{ route('admin.permissions.edit', [$permission->id]) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a class="btn btn-icon btn-transparent-dark" href="{{ route('admin.permissions.destroy', [$permission->id]) }}" onclick="return confirm('Are you sure you want to delete this permission?');">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End card -->
    </div>
</x-admin-layout>
