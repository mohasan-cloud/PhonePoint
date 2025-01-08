<x-admin-layout>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin-settings.update') }}" method="POST">
        @csrf
        @if ($setting)
            <input type="hidden" name="id" value="{{ $setting->id }}">
        @endif

        <div class="form-group">
            <label for="admin_email">Admin Email:</label>
            <input type="email" class="form-control" id="admin_email" name="admin_email" value="{{ $setting->admin_email ?? old('admin_email') }}" required>
            @error('admin_email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
</x-admin-layout>

