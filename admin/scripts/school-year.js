$(document).ready(function () {
    // Initiate DataTable
    var table = $('#school-year').DataTable({
        "columns": [
            {
                title: 'Academic ID',
                data: null,
                render: function (data, type, row, meta) {
                    data = meta.row + 1;
                    return data;
                }
            },
            {
                title: 'Academic Year',
                data: 'year'
            },
            {
                title: 'Status',
                data: 'status'
            },
            {
                title: 'Action',
                data: null,
                render: function (data, type, row) {
                    return '<button class="btn btn-danger btn-sm btn-delete" data-id="' + row.academic_year_id + '">Delete</button>' +
                        '<button class="btn btn-info btn-sm btn-edit" data-id="' + row.academic_year_id + '">Edit</button>';
                }
            }
        ],
        dom: 'Bfrtip'
    });

    // Fetch data from PHP controller
    $.ajax({
        url: 'controllers/getAcademicYear.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            // Populate DataTable with fetched data
            table.rows.add(response).draw();
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });

    // Event handler for delete button
    $('#school-year').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var rowId = $(this).data('id');

        // Send request to delete data
        $.ajax({
            url: 'controllers/deleteAcademicYear.php',
            type: 'POST',
            data: {
                id: rowId
            },
            success: function (response) {
                var response = JSON.parse(response);
                if (response.status === 'success') {
                    swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success'
                    }).then(function () {
                        // Refresh the page
                        location.reload();
                    });
                }
            },
            error: function (error) {
                console.error('Error deleting data:', error);
            }
        });
    });


    // Event handler for form submission
    $('.submit-school').on('click', function (e) {
        // prevent default form submission
        e.preventDefault();
        var schoolYear = $('#schoolYear').val();

        $.ajax({
            url: 'controllers/addAcademicYear.php',
            type: 'POST',
            data: {
                schoolYear: schoolYear
            },
            success: function (response) {
                var response = JSON.parse(response);
                if (response.status === 'success') {
                    swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success'
                    });
                }
            },
            error: function (error) {
                console.error('Error adding school year:', error);
            }
        })
    });

    $('#addSchoolYearForm').submit(function () {

    });
});
