<x-admin-layout>
    <div class="container-xl px-4">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-10">{{ __('Create Role') }}</div>
                    <div class="col-md-2">
                        <div class="input-group input-group-joined border-0 add-button">
                            <a class="btn btn-danger btn-sm" href="{{ url('admin/roles') }}">{{ __('Roles List') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data" class="form">
                    @csrf
                    
                    <div class="sbp-preview">
                        <div class="sbp-preview-content">
                        @include('admin.roles.inc.form', ['role' => new Spatie\Permission\Models\role])
                            <div class="col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }} &nbsp <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
