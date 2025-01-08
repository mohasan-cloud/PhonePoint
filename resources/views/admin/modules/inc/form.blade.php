<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Module Name', 'name', ['class' => '']) !!}
            {!! Html::text('name', null)->class('form-control')->id('module_name')->placeholder('Enter Module Name') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Module Term', 'term', ['class' => '']) !!}
            {!! Html::text('term', null)->class('form-control')->id('term')->placeholder('Module Term') !!}
        </div>
    </div>
</div>
@php
$fields = array(
0 => 'No',
1 => 'Yes',
);
@endphp

@php
for ($i=1; $i <=50 ; $i++) {
   $extra_fields[$i] = $i;
}

$fields_list = array();
if(isset($module)){
   $fields_list = $module->fields()->pluck('field')->toArray();
}
@endphp


<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('Module Slug', 'is_slug', ['class' => '']) !!}
            {!! Html::select('is_slug', $fields, null)->class('form-control')->id('is_slug') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Html::label('Module Menus', 'is_menu', ['class' => '']) !!}
            {!! Html::select('is_menu', $fields, null)->class('form-control')->id('is_menu') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Html::label('Module Preview', 'is_preview', ['class' => '']) !!}
            {!! Html::select('is_preview', $fields, null)->class('form-control')->id('is_preview') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Html::label('Module Description', 'is_description', ['class' => '']) !!}
            {!! Html::select('is_description', $fields, null)->class('form-control')->id('is_description') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Html::label('Module Highlights', 'is_highlights', ['class' => '']) !!}
            {!! Html::select('is_highlights', $fields, null)->class('form-control')->id('is_highlights') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Html::label('Module Seo', 'is_seo', ['class' => '']) !!}
            {!! Html::select('is_seo', $fields, null)->class('form-control')->id('is_seo') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Html::label('Module Category', 'category', ['class' => '']) !!}
            {!! Html::select('category', $fields, null)->class('form-control')->id('category') !!}
        </div>
    </div>
    @php
    // Ensure $industries_data and $department_data are set correctly
    $industries_data = isset($industries_id) ? $industries_id->industry_id : null;
    $department_data = isset($industries_id) ? $industries_id->department_id : null;
@endphp

<div class="col-md-4">
    <div class="mb-3">
        {!! Html::label('Industries and Department', '', ['class' => '']) !!}

        <input type="radio" id="toggle-industry-department" name="toggle-fields" value="1" 
            @if(isset($industries_data) && $industries_data) checked @endif> Enable
        
        <input type="radio" id="toggle-industry-department" name="toggle-fields" value="0"
            @if(!isset($industries_data) || !$industries_data) checked @endif> Disable
    </div>
</div>

<!-- Industry Selection -->
<div class="col-md-6" id="industry-section" style="display: none;">
    <div class="mb-3">
        {!! Html::label('Industry', 'industry_id', ['class' => '']) !!}
        <select name="industry_id" id="industry_id" class="form-control">
            <option value="">Select Industry</option>
            @foreach($industries as $id => $name)
                <option value="{{ $id }}" {{ $id == $industries_data ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
        
    </div>
</div>

<!-- Department Selection -->
<div class="col-md-6" id="department-section" style="display: none;">
    <div class="mb-3">
        {!! Html::label('Department', 'department_id', ['class' => '']) !!}
        <select name="department_id" id="department_id" class="form-control" disabled>
            <option value="">Select Department</option>
        </select>
    </div>
</div>


    


    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Module Category', 'parent_id', ['class' => '']) !!}
            {!! Html::select('parent_id', [''=>'Select Category'] + $categories, null)->class('form-control')->id('parent_id') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Multiple Categories', 'multiple_category', ['class' => '']) !!}
            {!! Html::select('multiple_category', $fields, null)->class('form-control')->id('multiple_category') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Module Sub Category', 'sub_category', ['class' => '']) !!}
            {!! Html::select('sub_category', $fields, null)->class('form-control')->id('sub_category') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Module Sub Category', 'parent_sub_id', ['class' => '']) !!}
            {!! Html::select('parent_sub_id', [''=>'Select Sub Category'] + $categories, null)->class('form-control')->id('parent_sub_id') !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('Module Tags', 'tags', ['class' => '']) !!}
            {!! Html::select('tags', $fields, null)->class('form-control')->id('tags') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Image', 'image', ['class' => 'form-label']) !!}
            <div class="mb-2">
                <!-- Display the current image if available -->
                @if(!empty($module->image))
                    <img src="{{ asset($module->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                @else
                    <p>No image uploaded</p>
                @endif
            </div>
            <!-- File input for uploading a new image -->
            {!! Html::file('image')->class('form-control')->id('image') !!}
        </div>
    </div>
    <div class="col-md-6 sidebar_icon_section"">
        <div class="mb-3">
            {!! Html::label('Sidebar Icon', 'sidebar_icon', ['class' => '']) !!}
            {!! Html::text('sidebar_icon', $module->sidebar_icon ?? null)
                ->class('form-control')
                ->id('sidebar_icon')
                ->placeholder('Sidebar Icon') !!}
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('Add Permission', 'actions', ['class' => '']) !!}
            <div class="row">
                <!-- List -->
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="list" name="actions[list]" value="List">
                        
                        <label class="form-check-label" for="list">List</label>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="list_name" class="form-control action-name" id="list_name" placeholder="List Module" />
                    </div>
                </div>
    
                <!-- Add -->
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="add" name="actions[add]" value="Add">
                        <label class="form-check-label" for="add">Add</label>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="add_name" class="form-control action-name" id="add_name" placeholder="Add Module" />
                    </div>
                </div>
    
                <!-- Edit -->
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="edit" name="actions[edit]" value="Edit">
                        <label class="form-check-label" for="edit">Edit</label>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="edit_name" class="form-control action-name" id="edit_name" placeholder="Edit Module" />
                    </div>
                </div>
    
                <!-- Update -->
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="update" name="actions[update]" value="Update">
                        <label class="form-check-label" for="update">Update</label>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="update_name" class="form-control action-name" id="update_name" placeholder="Update Module" />
                    </div>
                </div>
    
                <!-- Delete -->
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="delete" name="actions[delete]" value="Delete">
                        <label class="form-check-label" for="delete">Delete</label>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="delete_name" class="form-control action-name" id="delete_name" placeholder="Delete Module" />
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    @push('js')
    <script>
     $(document).ready(function () {
    var permissions = @json($permissions); // Pass permissions data from the controller to the view
    var term = $('#term').val(); // Get the module term value

    // Loop through each action and pre-fill the corresponding checkbox and name field
    ['list', 'add', 'edit', 'update', 'delete'].forEach(function(action) {
        let checkbox = $('#' + action); // Match checkbox by ID
        let nameField = $('#' + action + '_name'); // Match input field by ID
        let permissionKey = action + ' ' + term; // Combine action and term to match permission

        // Check if the permission exists for the current action and term
        if (permissions[permissionKey]) {
            checkbox.prop('checked', true); // Check the checkbox if permission exists
            nameField.val(permissions[permissionKey].name); // Fill the name field with the permission name
        } else {
            checkbox.prop('checked', false); // Uncheck if permission doesn't exist
            nameField.val(''); // Clear the field
        }
    });

    // When the term input field changes, update corresponding checkboxes and name fields
    $('#term').on('input', function () {
        var moduleName = $(this).val(); // Get the entered module name

        // Update the input fields for each action based on the term
        $('#list_name').val(moduleName);
        $('#add_name').val(moduleName);
        $('#edit_name').val(moduleName);
        $('#update_name').val(moduleName);
        $('#delete_name').val(moduleName);

        // Check the checkboxes if the corresponding name field has a value
        $('#list').prop('checked', $('#list_name').val() != '');
        $('#add').prop('checked', $('#add_name').val() != '');
        $('#edit').prop('checked', $('#edit_name').val() != '');
        $('#update').prop('checked', $('#update_name').val() != '');
        $('#delete').prop('checked', $('#delete_name').val() != '');
    });
});

</script>
    @endpush
    
    
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Module Image', 'is_image', ['class' => '']) !!}
            {!! Html::select('is_image', $fields, null)->class('form-control')->id('is_image') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Html::label('Multi Images', 'multi_images', ['class' => '']) !!}
            {!! Html::select('multi_images', $fields, null)->class('form-control')->id('multi_images') !!}
        </div>
    </div>
    <div class="col-md-6 image_section" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Thumbnail Height', 'thumbnail_height', ['class' => '']) !!}
            {!! Html::text('thumbnail_height', null)->class('form-control')->id('thumbnail_height')->placeholder('Thumbnail Height') !!}
        </div>
    </div>
    <div class="col-md-6 image_section" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Thumbnail Width', 'thumbnail_width', ['class' => '']) !!}
            {!! Html::text('thumbnail_width', null)->class('form-control')->id('thumbnail_width')->placeholder('Thumbnail Width') !!}
        </div>
    </div>



</div>

<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            {!! Html::label('Extra Fields', 'extra_fields',['class' => '']) !!}
            {!! Html::select('extra_fields', [''=>'Select Extra Fields'] + $extra_fields, null)->class('form-control')->id('extra_fields') !!}
        </div>
    </div>
</div>

@php
$field_types = [
    'text' => 'text',
    'textarea' => 'textarea',
    'number' => 'number',
    'select' => 'select',
    'date' => 'date',
    'color' => 'color',
    'time' => 'time',
    'checkbox' => 'checkbox',
    'file' => 'file',
    'auto' => 'auto',
];
@endphp

<div class="row">
    @for ($i=1; $i <=25 ; $i++)
    <div class="col-md-12 extra_field_title" style="display: none;">
        <hr>
        <div class="mb-3">
            {!! Html::label('Extra Field Title '.$i, 'extra_field_title_'.$i, ['class' => '']) !!}
            {!! Html::text('extra_field_title_'.$i)->class('form-control')->id('extra_field_title_'.$i)->placeholder('Extra Field Title '.$i) !!}
        </div>
    </div>
    <div class="col-md-6 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Extra Field Type '.$i, 'extra_field_type_'.$i, ['class' => '']) !!}
            {!! Html::select('extra_field_type_'.$i, [''=>'Select Field Type'] + $field_types)->class('form-control')->id('extra_field_type_'.$i) !!}
        </div>
    </div>
    <div class="col-md-6 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Extra Field '.$i.' Attr', 'extra_field_attr_'.$i, ['class' => '']) !!}
            {!! Html::select('extra_field_attr_'.$i, [''=>'Select Attr'] + $categories)->class('form-control')->id('extra_field_attr_'.$i) !!}
        </div>
    </div>
    <div class="col-md-4 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Extra Field '.$i.' Sort', 'extra_field_sort_'.$i, ['class' => '']) !!}
            {!! Html::number('extra_field_sort_'.$i)->class('form-control')->id('extra_field_sort_'.$i)->placeholder('Extra Field '.$i.' Sort') !!}
        </div>
    </div>
    <div class="col-md-4 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Extra Field '.$i.' Col Class', 'extra_field_col_'.$i, ['class' => '']) !!}
            {!! Html::number('extra_field_col_'.$i)->class('form-control')->id('extra_field_col_'.$i)->placeholder('Extra Field '.$i.' Col Class') !!}
        </div>
    </div>
    <div class="col-md-4 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Extra Field '.$i.' Max Length', 'extra_field_max_length_'.$i, ['class' => '']) !!}
            {!! Html::number('extra_field_max_length_'.$i)->class('form-control')->id('extra_field_max_length_'.$i)->placeholder('Extra Field '.$i.' Max Length') !!}
        </div>
    </div>
    <div class="col-md-4 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Is Extra Field '.$i.' Required?', 'extra_field_required_'.$i, ['class' => '']) !!}
            {!! Html::select('extra_field_required_'.$i, $fields)->class('form-control')->id('extra_field_required_'.$i) !!}
        </div>
    </div>
    <div class="col-md-4 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Extra Field '.$i.' Required Message', 'extra_field_required_message_'.$i, ['class' => '']) !!}
            {!! Html::text('extra_field_required_message_'.$i)->class('form-control')->id('extra_field_required_message_'.$i)->placeholder('Extra Field '.$i.' Required Message') !!}
        </div>
    </div>
    <div class="col-md-4 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Is Extra Field '.$i.' show?', 'extra_field_show_'.$i, ['class' => '']) !!}
            {!! Html::select('extra_field_show_'.$i, $fields)->class('form-control')->id('extra_field_show_'.$i) !!}
        </div>
    </div>
    <div class="col-md-12 extra_field_title" style="display: none;">
        <div class="mb-3">
            {!! Html::label('Is Extra Field '.$i.' show in listing?', 'extra_field_show_in_list_'.$i, ['class' => '']) !!}
            {!! Html::select('extra_field_show_in_list_'.$i, $fields, in_array('extra_field_'.$i, $fields_list) ? 1 : 0)->class('form-control')->id('extra_field_show_in_list_'.$i) !!}
        </div>
    </div>
    @endfor
</div>


@push('js')
<script type="text/javascript">
   extrafields("{{old('extra_fields', (isset($module))? $module->extra_fields:'')}}");
    $('#extra_fields').on('change',function(){
        extrafields($(this).val());
    })
    function extrafields(val){
        $('.extra_field_title').hide();
        for (var i = 1; i <= val; i++) {
            $('#extra_field_title_'+i).parent().parent().show();
            $('#extra_field_type_'+i).parent().parent().show();
            $('#extra_field_attr_'+i).parent().parent().show();
            $('#extra_field_sort_'+i).parent().parent().show();
            $('#extra_field_col_'+i).parent().parent().show();
            $('#extra_field_max_length_'+i).parent().parent().show();
            $('#extra_field_required_'+i).parent().parent().show();
            $('#extra_field_required_message_'+i).parent().parent().show();
            $('#extra_field_show_'+i).parent().parent().show();
            $('#extra_field_show_in_list_'+i).parent().parent().show();
        }
    }


    show_thumb("{{old('is_image', (isset($module))? $module->is_image:'')}}");

    $('#is_image').on('change',function(){

        show_thumb($(this).val());

    })



    function show_thumb(val){

        if(val==1){

            $('.image_section').show();

        }else{

            $('.image_section').hide();

        }

    }

    document.addEventListener('DOMContentLoaded', function () {
    const industrySelect = document.getElementById('industry_id');
    const departmentSelect = document.getElementById('department_id');
    const industrySection = document.getElementById('industry-section');
    const departmentSection = document.getElementById('department-section');
    const toggleFields = document.querySelectorAll('input[name="toggle-fields"]');
    
    // Show or Hide Industry and Department fields based on the toggle
    toggleFields.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === "1") {
                // Show Industry and Department
                industrySection.style.display = "block";
                departmentSection.style.display = "block";

                // Enable form elements
                industrySelect.disabled = false;
                departmentSelect.disabled = false;

                // If industry_id is already selected, fetch departments
                if (industrySelect.value) {
                    fetchDepartments(industrySelect.value);
                }
            } else {
                // Hide Industry and Department
                industrySection.style.display = "none";
                departmentSection.style.display = "none";

                // Disable form elements to avoid submission
                industrySelect.disabled = true;
                departmentSelect.disabled = true;
            }
        });
    });

    // Initialize form elements as disabled
    industrySelect.disabled = true;
    departmentSelect.disabled = true;

    // Pre-load the industry and department dropdowns if data is present
    if ('{{ $industries_data }}' && '{{ $industries_data }}' != '') {
        // Show Industry and Department sections
        industrySection.style.display = "block";
        departmentSection.style.display = "block";
        industrySelect.disabled = false;

        // Set the pre-selected industry
        industrySelect.value = '{{ $industries_data }}';

        // If department_id is selected, fetch departments
        if ('{{ $department_data }}' && '{{ $department_data }}' != '') {
            departmentSelect.disabled = false;
            departmentSelect.value = '{{ $department_data }}'; // Set the selected department
        }

        // Fetch departments based on the selected industry
        fetchDepartments('{{ $industries_data }}');
    }

    // Listen for changes in the industry dropdown
    industrySelect.addEventListener('change', function () {
        const industryId = this.value;
        fetchDepartments(industryId);
    });

    // Function to fetch departments based on the selected industry
    function fetchDepartments(industryId) {
        departmentSelect.innerHTML = '<option value="">Loading...</option>';  // Show loading message
        
        // Send AJAX request to fetch departments
        fetch('{{ route('new.get.departments') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ industry_id: industryId })
        })
        .then(response => response.json())
        .then(data => {
            // Clear and populate the departments dropdown
            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            Object.entries(data).forEach(([id, title]) => {
                const selected = (id == '{{ $department_data }}') ? 'selected' : ''; // Check if this is the default selected department
                departmentSelect.innerHTML += `<option value="${id}" ${selected}>${title}</option>`;
            });
        })
        .catch(() => {
            departmentSelect.innerHTML = '<option value="">Failed to load departments</option>';
        });
    }
});

</script>

@endpush
