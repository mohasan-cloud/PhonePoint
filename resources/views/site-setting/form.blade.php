<x-admin-layout>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">



    <div class="container">
    <h1 class="mb-4">{{ $siteSetting->id ? 'Update Form' : 'Create Form' }}</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


            <form action="{{ $siteSetting->id ? route('site-settings.storeOrUpdate', $siteSetting->id) : route('site-settings.storeOrUpdate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{$siteSetting->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" class="form-control" id="description" value="{{$siteSetting->description }}" required>
        </div>
            <!-- Locations Section -->
            <div class="form-group">
                <label for="locations">Locations</label>
                <div id="locations-wrapper">
                        <div class="location-group">
                            <input type="text" name="locations" class="form-control mb-2" value="{{$siteSetting->locations }}" placeholder="Location">
                        </div>
                </div>
            </div>

            <!-- Protected Emails Section -->
            <div class="form-group">
                <label for="protected_emails">Protected Emails</label>
                <div id="emails-wrapper">
                        <div class="email-group">
                            <input type="email" name="protected_emails" class="form-control mb-2" value="{{$siteSetting->protected_emails }}" placeholder="Protected Email">
                        </div>
                </div>
            </div>

            <!-- Phone Numbers Section -->
            <div class="form-group">
                <label for="phone_numbers">Phone Numbers</label>
                <div id="phones-wrapper">
                        <div class="phone-group">
                            
                            <input type="text" name="phone_numbers" class="form-control mb-2" value="{{$siteSetting->phone_numbers }}" placeholder="Phone Number">
                        </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save Settings</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</x-admin-layout>
