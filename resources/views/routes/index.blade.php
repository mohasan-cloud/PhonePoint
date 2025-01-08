<x-admin-layout>
    <div class="container-xl px-4">
        <!-- Start page title and breadcrumbs -->
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Routes</li>
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
                        <h5>{{ __('Routes List') }}</h5>
                    </div>
                  
                </div>
            </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('routes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="route_id" value="{{ isset($route) ? $route->id : '' }}">
    
    <!-- Route Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Route Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($route) ? $route->name : '' }}" required>
    </div>

    <!-- Option for Is Need URL -->
    <div class="mb-3">
        <input type="checkbox" id="is_need_url" name="is_need_url" {{ isset($route) && $route->url ? 'checked' : '' }}>
        <label for="is_need_url" class="form-label">Is Need URL</label>
    </div>

    <!-- Option for Is Need Sub Menu -->
    <div class="mb-3">
        <input type="checkbox" id="is_need_sub_menu" name="is_need_sub_menu" {{ isset($route) && $route->module_id ? 'checked' : '' }}>
        <label for="is_need_sub_menu" class="form-label">Is Need Sub Menu</label>
    </div>

    <!-- Route URL (Hidden unless Is Need URL is checked) -->
    <div class="mb-3" id="url_input" style="display: none;">
        <label for="url" class="form-label">Route URL</label>
        <input type="url" class="form-control" id="url" name="url" value="{{ isset($route) ? $route->url : '' }}">
    </div>
    

    <!-- Module ID and Type (Hidden unless Is Need Sub Menu is checked) -->
    <div id="submenu_inputs" style="display: none;">
        <!-- Module ID -->
        <div class="mb-3">
            <label for="module_id" class="form-label">Module ID</label>
            <input type="number" class="form-control" id="module_id" name="module_id" value="{{ isset($route) ? $route->module_id : '' }}">
        </div>

        <!-- Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ isset($route) ? $route->type : '' }}">
        </div>
        <div class="mb-3" id="sub_menu_url" ">
        <label for="sub_menu_url" class="form-label">Route URL</label>
        <input type="text" class="form-control" id="sub_menu_url" name="sub_menu_url" value="{{ isset($route) ? $route->sub_menu_url : '' }}">
    </div>
        
    </div>
    <div class="mb-3">
                <label for="breadcrumb_title" class="form-label">Breadcrumb Title</label>
                <input type="text" class="form-control" id="breadcrumb_title" name="breadcrumb_title" value="{{ isset($route) ? $route->breadcrumb_title : '' }}">
            </div>
            <div class="mb-3">
                <label for="breadcrumb_image" class="form-label">Breadcrumb Image</label>
                <input type="file" class="form-control" id="breadcrumb_image" name="breadcrumb_image">
                @if(isset($route) && $route->breadcrumb_image)
                    <img src="{{ asset($route->breadcrumb_image) }}" alt="Breadcrumb Image" width="100">
                @endif
            </div>
<!-- Option for Is Custom Sub Menu -->
<div class="mb-3">
    <input type="checkbox" id="is_custom_sub_menu" name="is_custom_sub_menu" {{ isset($route) && $route->is_custom_sub_menu ? 'checked' : '' }}>
    <label for="is_custom_sub_menu" class="form-label">Is Custom Sub Menu</label>
</div>

<!-- Custom Sub Menus Container (Hidden unless Is Custom Sub Menu is checked) -->
<div id="custom_submenu_inputs_container" style="display: none;">
    <div id="custom_submenu_inputs">
        <!-- Custom Sub Menu Name and URL fields will be dynamically added here -->
    </div>

    <!-- Button to add new custom sub menu -->
    <div id="custom_submenu_inputs_container">
    <div id="custom_submenu_inputs">
      @if(isset($route) && $route->subMenus)
    @foreach($route->subMenus as $index => $subMenu)
        <div class="custom-submenu-group" id="submenu-group-{{ $index }}">
            <label for="custom_submenu_name_{{ $index }}">Sub Menu Name</label>
            <input type="text" class="form-control" id="custom_submenu_name_{{ $index }}" name="custom_submenu_name[]" value="{{ $subMenu->name }}" required>

            <label for="custom_submenu_url_{{ $index }}">Sub Menu URL</label>
            <input type="url" class="form-control" id="custom_submenu_url_{{ $index }}" name="custom_submenu_url[]" value="{{ $subMenu->url }}" required>
        </div>
    @endforeach
@endif

    </div>

    <button type="button" id="add_custom_submenu">Add Sub Menu</button>
</div>
</div>

    <button type="submit" class="btn btn-primary">{{ isset($route) ? 'Update' : 'Add' }} Route</button>
</form>


<h2 class="mt-5">Existing Routes</h2>
        <table class="table" id="routes-table">
            <thead>
                <tr>
                    <th>Reorder</th>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Order</th> <!-- Add a header for the order -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($routes as $r)
                    <tr id="route-{{ $r->id }}" data-id="{{ $r->id }}">
                        <td class="drag-handle">&#x2630;</td>
                        <td>{{ $r->name }}</td>
                        <td>{{ $r->url }}</td>
                        <td>
                            <input type="number" value="{{ $r->order }}" class="form-control order-input" data-id="{{ $r->id }}" />
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary update-order" data-id="{{ $r->id }}">Update</button>
                            <a href="{{ route('routes.edit', $r->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('routes.destroy', $r->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you want to delete this route?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- JS & SweetAlert Integration -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.update-order').click(function() {
                var routeId = $(this).data('id');
                var newOrder = $(this).closest('tr').find('.order-input').val();

                $.ajax({
                    url: '{{ route("routes.updateOrder") }}', // Use named route for better maintainability
                    type: 'POST',
                    data: {
                        id: routeId,
                        order: newOrder,
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Order updated successfully!',
                            icon: 'success',
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error updating order.',
                            icon: 'error',
                        });
                    }
                });
            });
        });
    </script>

    
<script>
    $(document).ready(function() {
        // Initially check the status of checkboxes and show/hide inputs accordingly
        toggleUrlInput();
        toggleSubMenuInputs();

        // Show/Hide URL input when 'Is Need URL' checkbox is clicked
        $('#is_need_url').change(function() {
            toggleUrlInput();
        });

        // Show/Hide Sub Menu inputs when 'Is Need Sub Menu' checkbox is clicked
        $('#is_need_sub_menu').change(function() {
            toggleSubMenuInputs();
        });

        function toggleUrlInput() {
            if ($('#is_need_url').is(':checked')) {
                $('#url_input').show();
            } else {
                $('#url_input').hide();
            }
        }

        function toggleSubMenuInputs() {
            if ($('#is_need_sub_menu').is(':checked')) {
                $('#submenu_inputs').show();
            } else {
                $('#submenu_inputs').hide();
            }
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Initially check the status of checkboxes and show/hide inputs accordingly
        toggleCustomSubMenuInputs();

        // Show/Hide Custom Sub Menu inputs when 'Is Custom Sub Menu' checkbox is clicked
        $('#is_custom_sub_menu').change(function() {
            toggleCustomSubMenuInputs();
        });

        // Function to show or hide the custom sub-menu inputs
        function toggleCustomSubMenuInputs() {
            if ($('#is_custom_sub_menu').is(':checked')) {
                $('#custom_submenu_inputs_container').show();
            } else {
                $('#custom_submenu_inputs_container').hide();
                $('#custom_submenu_inputs').empty();  // Clear all sub-menus if unchecked
            }
        }

        // Add dynamic sub menu inputs when "Add Sub Menu" button is clicked
        let subMenuCount = 0;
        $('#add_custom_submenu').click(function() {
            subMenuCount++;
            $('#custom_submenu_inputs').append(`
                <div class="custom-submenu-group" id="submenu-group-${subMenuCount}">
                    <h5>Sub Menu ${subMenuCount}</h5>
                    <div class="mb-3">
                        <label for="custom_submenu_name_${subMenuCount}" class="form-label">Custom Sub Menu Name</label>
                        <input type="text" class="form-control" id="custom_submenu_name_${subMenuCount}" name="custom_submenu_name[]" required>
                    </div>
                    <div class="mb-3">
                        <label for="custom_submenu_url_${subMenuCount}" class="form-label">Custom Sub Menu URL</label>
                        <input type="url" class="form-control" id="custom_submenu_url_${subMenuCount}" name="custom_submenu_url[]" required>
                    </div>
                    <button type="button" class="btn btn-danger remove-submenu" data-id="${subMenuCount}">Remove</button>
                    <hr>
                </div>
            `);
        });

        // Remove sub-menu group when "Remove" button is clicked
        $(document).on('click', '.remove-submenu', function() {
            var id = $(this).data('id');
            $('#submenu-group-' + id).remove();
        });
    });
</script>

</x-admin-layout>
