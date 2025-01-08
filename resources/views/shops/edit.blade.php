<x-admin-layout>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">{{ isset($shop) ? 'Edit Shop' : 'Add Shop' }}</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ isset($shop) ? route('shops.update', $shop->id) : route('shops.store') }}"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @if(isset($shop)) @method('PUT') @endif

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="shop_name" class="form-label">Shop Name</label>
                                            <input type="text"
                                                   name="shop_name"
                                                   id="shop_name"
                                                   class="form-control"
                                                   value="{{ $shop->shop_name ?? '' }}"
                                                   placeholder="Enter shop name"
                                                   required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="owner_name" class="form-label">Owner Name</label>
                                            <input type="text"
                                                   name="owner_name"
                                                   id="owner_name"
                                                   class="form-control"
                                                   value="{{ $shop->owner_name ?? '' }}"
                                                   placeholder="Enter owner name"
                                                   required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="shop_location" class="form-label">Shop Location</label>
                                            <input type="text"
                                                   name="shop_location"
                                                   id="shop_location"
                                                   class="form-control"
                                                   value="{{ $shop->shop_location ?? '' }}"
                                                   placeholder="Enter shop location"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="near_shop" class="form-label">Near Shop</label>
                                            <input type="text"
                                                   name="near_shop"
                                                   id="near_shop"
                                                   class="form-control"
                                                   value="{{ $shop->near_shop ?? '' }}"
                                                   placeholder="Enter nearby shop">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="reference_name" class="form-label">Reference Name</label>
                                            <input type="text"
                                                   name="reference_name"
                                                   id="reference_name"
                                                   class="form-control"
                                                   value="{{ $shop->reference_name ?? '' }}"
                                                   placeholder="Enter reference name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="reference_shop" class="form-label">Reference Shop</label>
                                            <input type="text"
                                                   name="reference_shop"
                                                   id="reference_shop"
                                                   class="form-control"
                                                   value="{{ $shop->reference_shop ?? '' }}"
                                                   placeholder="Enter reference shop">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="cnic_image" class="form-label">CNIC Image</label>
                                            @if(isset($shop->cnic_image) && file_exists(public_path($shop->cnic_image)))
                                            <div>
                                                <img src="{{ asset( $shop->cnic_image) }}" alt="CNIC Image" class="img-thumbnail" width="150">
                                            </div>
                                        @endif
                                            <input type="file"
                                                   name="cnic_image"
                                                   id="cnic_image"
                                                   class="form-control">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="balance" class="form-label">Balance</label>
                                            <input type="number"
                                                   step="0.01"
                                                   name="balance"
                                                   id="balance"
                                                   class="form-control"
                                                   value="{{ $shop->balance ?? '' }}"
                                                   placeholder="Enter balance"
                                                   required>
                                        </div>
                                    </div>

                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($shop) ? 'Update Shop' : 'Create Shop' }}
                                        </button>
                                        <a href="{{ route('shops.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif
    </script>
</x-admin-layout>
