<x-admin-layout>
    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-xxl">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <!-- Breadcrumbs -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/admin/modules')}}">Modules</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Module</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="container-xl px-4">
                <!-- Space between breadcrumb and form -->
                <div class="mb-4"></div> <!-- This adds some margin space -->

                <!-- Card for Module Edit Form -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10">
                                <h5 class="card-title">{{__('Add Module')}}</h5>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-danger btn-sm" href="{{url('/admin/modules')}}">{{__('Back to Modules List')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Body -->
                    <div class="card-body">
                        {{ html()->form('POST', route('admin.modules.store'))->attribute('enctype', 'multipart/form-data')->open() }}

                        <div class="sbp-preview">
                            <div class="sbp-preview-content">
                                @include('admin.modules.inc.form')

                                <!-- Submit Button -->
                                <div class="col-sm-12 col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{__('Create')}} &nbsp;<i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
