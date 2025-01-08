<x-admin-layout>
    <style>
        .custom-breadcrumb {
            background-color: #e9ecef; /* Light grey background */
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 0.9rem; /* Adjust font size */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }

        .custom-breadcrumb .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }

        .custom-breadcrumb .breadcrumb-item.active {
            color: #6c757d;
            font-weight: 600; /* Make active item bold */
        }

        h1 {
            font-size: 1.5rem; /* Adjust heading size */
            font-weight: 600;
        }

        .form-container {
            max-width: 600px; /* Adjust the max width of the form */
            margin: auto; /* Center the form */
            padding: 2rem; /* Add padding */
            border: 1px solid #dee2e6; /* Add a border */
            border-radius: 0.25rem; /* Rounded corners */
            background-color: #ffffff; /* White background for the form */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }
    </style>
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="my-3">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Class</li>
        </ol>
    </nav>

    <div class="form-container">
        <h1 class="mb-4">Create Class</h1>
        <form action="{{ route('classes.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Class Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Class Name" required>
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            </div>
            <button type="submit" class="btn btn-danger btn-sm mx-1">Create Class</button>
        </form>
    </div>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</x-admin-layout>

<!-- Add Bootstrap CDN -->
