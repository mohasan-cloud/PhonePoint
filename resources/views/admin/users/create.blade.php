<x-admin-layout>
    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">

                    <div class="col-lg-10 col-md-12">
                        <!-- Card Container -->
                        <div class="card mb-4 shadow-sm">
                            <livewire:admin.common.header
                                :title="'Edit User'"
                                :content="'List of all Users are below'"
                                :icon="'fa-school'"
                                :term="'User'"
                                :slug="url('/admin/users')"
                                :button="__('Users List')"
                            />

                            <div class="card-body">
                                <!-- Success or Error Message -->
                                @if(session()->has('message.added'))
                                    <div class="alert alert-{{ session('message.added') }} alert-dismissible fade show" role="alert">
                                        <strong>{{ __('Congratulations') }}!</strong> {!! session('message.content') !!}.
                                    </div>
                                @endif

                                <!-- User Edit Form -->
                                {{ html()->form('POST', route('admin.users.store'))->open() }}

                                <div class="form-container mb-4">
                                    @include('admin.users.inc.form')

                                    <!-- Submit Button -->
                                    <div class="col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            {{ __('Create') }} &nbsp;<i class="fa-solid fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                {{ html()->form()->close() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
