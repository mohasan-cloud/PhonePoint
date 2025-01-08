<x-admin-layout>
    <style>.custom-breadcrumb {
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem; /* Adjust font size */
    }

    .custom-breadcrumb .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
    }

    .custom-breadcrumb .breadcrumb-item.active {
        color: #6c757d;
    }

    h1 {
        font-size: 1.5rem; /* Adjust heading size */
        font-weight: 600;
    }
    </style>
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="my-3">
        <ol class="breadcrumb custom-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Class</li>
        </ol>
    </nav>

    <h1 class="mb-4">Edit Class</h1>
    <form action="{{ route('classes.update', $class) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-md-4 mb-3">
            <label for="name" class="form-label">Class Name</label>
            <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ $class->name }}" required>
        </div>
        <button type="submit" class="btn btn-danger btn-sm mx-1">Update Class</button>
    </form>
</x-admin-layout>
