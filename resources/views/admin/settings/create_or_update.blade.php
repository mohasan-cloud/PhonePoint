<x-admin-layout>



    <div class="page-wrapper">



        <!-- Page Content-->

        <div class="page-content">

            <div class="col-md-12">

                <div class="row justify-content-center">

                    <div class="col-12">

                        <!-- Breadcrumbs -->

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>

                                <li class="breadcrumb-item active" aria-current="page">Admin Setting</li>

                            </ol>

                        </nav>

                    </div>

                </div>

            </div>



            <div class="col-md-12 px-4">

                <div class="card mb-4">



                    <div class="card-body">

                        <style>
                            h1 {
                                font-size: 36px; /* Adjust the size as needed */
                            }
                        </style>

                        <h1>General Information</h1>


                        <!-- Success Message -->

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">

                                {{ session('success') }}

                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>

                            </div>
                        @endif



                        <!-- Error Messages -->

                        @if ($errors->any())

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                <ul>

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>

                            </div>

                        @endif



                        <form action="{{ route('admin.settings.storeOrUpdate') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <!-- Dashboard Name -->

                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="site_name" class="form-label">Site Name</label>

                                        <input type="text" id="site_name" name="site_name"
                                            class="form-control"
                                            value="{{ old('site_name', $setting->site_name ?? '') }}"
                                            >

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="phone_1" class="form-label">Phone 1</label>

                                        <input type="text" id="phone_1" name="phone_1"
                                            class="form-control"
                                            value="{{ old('phone_1', $setting->phone_1 ?? '') }}"
                                            >

                                    </div>

                                </div>
                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="phone_2" class="form-label">Phone 2</label>

                                        <input type="text" id="phone_2" name="phone_2"
                                            class="form-control"
                                            value="{{ old('phone_2', $setting->phone_2 ?? '') }}"
                                            >

                                    </div>

                                </div>
                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="phone_3" class="form-label">Phone 3</label>

                                        <input type="text" id="phone_3" name="phone_3"
                                            class="form-control"
                                            value="{{ old('phone_3', $setting->phone_3 ?? '') }}"
                                            >

                                    </div>

                                </div>
                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="email_1" class="form-label">Email 1</label>

                                        <input type="text" id="email_1" name="email_1"
                                            class="form-control"
                                            value="{{ old('email_1', $setting->email_1 ?? '') }}"
                                            >

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="email_2" class="form-label">Email 2</label>

                                        <input type="email" id="email_2" name="email_2"
                                            class="form-control"
                                            value="{{ old('email_2', $setting->email_2 ?? '') }}"
                                            >

                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="email_3" class="form-label">Email 3</label>

                                        <input type="email" id="email_3" name="email_3"
                                            class="form-control"
                                            value="{{ old('email_3', $setting->email_3 ?? '') }}"
                                            >

                                    </div>

                                </div>
                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="address" class="form-label">Address </label>

                                        <textarea id="address" name="address" class="form-control" >{{ old('address', $setting->address ?? '') }}</textarea>


                                    </div>

                                </div>




                            </div>



                            <button type="submit" class="btn btn-primary">Save Settings</button>

                        </form>



                    </div>

                </div>

            </div>


            <div class="col-md-12 px-4">

                <div class="card mb-4">



                    <div class="card-body">

                        <style>
                            h1 {
                                font-size: 36px; /* Adjust the size as needed */
                            }
                        </style>

                        <h1>Logo & Fav $ Footer Logo Information</h1>





                        <form action="{{ route('admin.settings.storeOrUpdate') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <!-- Dashboard Name -->




                                <!-- Favicon -->

                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="favicon" class="form-label">Favicon</label>

                                        <input type="file" id="favicon" name="favicon" class="form-control">

                                        @if (!empty($setting->favicon))
                                            <img src="{{ asset($setting->favicon) }}" alt="Favicon" class="mt-2"
                                                style="width: 50px;">
                                        @endif

                                    </div>

                                </div>



                                <!-- Logo -->

                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="logo" class="form-label">Logo</label>

                                        <input type="file" id="logo" name="logo" class="form-control">

                                        @if (!empty($setting->logo))
                                            <img src="{{ asset($setting->logo) }}" alt="Logo" class="mt-2"
                                                style="width: 100px;">
                                        @endif

                                    </div>

                                </div>
                                <div class="col-md-4">

                                    <div class="mb-3">

                                        <label for="footer" class="form-label">Footer</label>

                                        <input type="file" id="footer" name="footer_logo"
                                            class="form-control">

                                        @if (!empty($setting->footer_logo))
                                            <img src="{{ asset($setting->footer_logo) }}" alt="Logo"
                                                class="mt-2" style="width: 100px;">
                                        @endif

                                    </div>

                                </div>

                            </div>



                            <button type="submit" class="btn btn-primary">Save Settings</button>

                        </form>



                    </div>

                </div>

            </div>

            <div class="col-md-12 px-4">

                <div class="card mb-4">



                    <div class="card-body">

                        <style>
                            h1 {
                                font-size: 36px; /* Adjust the size as needed */
                            }
                        </style>

                        <h1>Social Information</h1>


                        <!-- Success Message -->





                        <form action="{{ route('admin.settings.storeOrUpdate') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">
                                <!-- Facebook URL -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                            <input type="text" id="facebook" name="facebook" class="form-control"
                                                value="{{ old('facebook', $setting->facebook ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Twitter URL -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="twitter" class="form-label">Twitter URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                            <input type="text" id="twitter" name="twitter" class="form-control"
                                                value="{{ old('twitter', $setting->twitter ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Instagram URL -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="Instagram" class="form-label">Instagram URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                            <input type="text" id="Instagram" name="Instagram" class="form-control"
                                                value="{{ old('Instagram', $setting->Instagram ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Linkedin URL -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="linkedin" class="form-label">Linkedin URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-linkedin-in"></i></span>
                                            <input type="text" id="linkedin" name="linkedin" class="form-control"
                                                value="{{ old('linkedin', $setting->linkedin ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- YouTube URL -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="youtube" class="form-label">YouTube URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                            <input type="text" id="youtube" name="youtube" class="form-control"
                                                value="{{ old('youtube', $setting->youtube ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- TikTok URL -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="tiktok" class="form-label">TikTok URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                            <input type="text" id="tiktok" name="tiktok" class="form-control"
                                                value="{{ old('tiktok', $setting->tiktok ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <button type="submit" class="btn btn-primary">Save Settings</button>

                        </form>



                    </div>

                </div>

            </div>

        </div>

    </div>

</x-admin-layout>
