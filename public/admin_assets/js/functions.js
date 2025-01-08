// Function to handle radio button selection
function handleRadioSelection() {
    $('input[type=radio]').change(function() {
        if ($(this).is(':checked')) {
            $('.form-check').removeClass('form-check-selected');
            $(this).parent().addClass('form-check-selected');
        }
    });
}

$('#tag_ids').select2();

// Function to initialize DataTable
function initializeDataTable(tableId, url, columns) {
    return $('#' + tableId).DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        searching: false,
        "bPaginate": false,
        "ordering": false,
        "info": false,
        responsive: true,
        ajax: {
            url: $('#' + url).val(),
            data: function (d) {
                d.name = $('input[name=name]').val();
                d.email = $('#email').val();
                d.location = $('#location').val();
                d.status = $('#status').val();
            }
        },
        columns: columns
    });
}

// Function to handle common table input events
function handleTableInputEvents(table, selectors) {
    selectors.forEach(selector => {
        $(selector).on('input change', function(e) {
            table.draw();
            e.preventDefault();
        });
    });
}

// Function to create DataTable columns based on conditions
function createDataTableColumns(enableAction, fields) {
    const columns = [
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'location', name: 'location' },
        { data: 'status', name: 'status' }
    ];

    if (enableAction == 'yes') {
        columns.push({ data: 'action', name: 'action', orderable: false, searchable: false });
    }

    return columns;
}

// Function to create DataTable for various sections
function createSectionDataTable(section, enableAction, fields) {
    const tableId = 'table-' + section;
    const url = 'table-' + section + '-url';
    const columns = createDataTableColumns(enableAction, fields);
    const dataTable = initializeDataTable(tableId, url, columns);
    handleTableInputEvents(dataTable, ['#name', '#email', '#location', '#status']);

    return dataTable;
}

// Initialization
$(document).ready(function() {
    handleRadioSelection();

    // Campuses
    const campusesTable = createSectionDataTable('campuses', $('#is_enable_campuses_action').val());
    
    // Designations
    const designationsTable = createSectionDataTable('designations', $('#is_enable_designations_action').val());

    // Courses
    const coursesTable = createSectionDataTable('courses', $('#is_enable_courses_action').val());

    // Programs
    const programsTable = createSectionDataTable('programs', $('#is_enable_programs_action').val());

    // Teachers
    const teachersTable = createSectionDataTable('teachers', $('#is_enable_teachers_action').val());

    // Students
    const studentsTable = createSectionDataTable('students', $('#is_enable_students_action').val());
    
    // Other common actions
    $('[name="all_permission"]').on('click', function() { /* ... */ });
});