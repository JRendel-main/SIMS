$(document).ready(() => {
    $.ajax({
        url: 'controllers/getSection.php',
        type: 'GET',
        dataType: 'json',
        success: (response) => {
            $('#section').DataTable({
                data: response,
                columns: [
                    {
                        title: 'Section ID',
                        data: 'section_id'
                    },
                    {
                        title: 'Adviser',
                        data: 'advisor_name'
                    },
                    {
                        title: 'Section Name',
                        data: 'section_name'
                    },
                    {
                        title: 'Year Level',
                        data: 'year'
                    },
                    {
                        title: 'Strand',
                        data: 'strand_name'
                    },
                    {
                        title: 'Action',
                        data: null,
                        render: function (data, type, row) {
                            return '<button class="btn btn-danger btn-sm btn-delete" data-id="' + row.section_id + '"><i class="bi bi-trash"></i></button> ' +
                                '<button class="btn btn-info btn-sm btn-edit" data-id="' + row.section_id + '"><i class="bi bi-pencil"></i></button>';
                        }
                    }
                ],
            });
        },
        error: (error) => {
            console.error('Error fetching data:', error);
        }
    });

    // get all teachers for select option and add search bar for modal
    $.ajax({
        url: 'controllers/getTeacherLists.php',
        type: 'GET',
        dataType: 'json',
        success: (response) => {
            response.forEach(teacher => {
                $('#teacher_id').append(`<option value="${teacher.teacher_id}">${teacher.teacher_name}</option>`);
            });
        },
        error: (error) => {
            console.error('Error fetching data:', error);
        }
    });

    $('#section').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var rowId = $(this).data('id');

        // add swal confirmation first
        swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this section.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform delete operation (AJAX call to server)
                $.ajax({
                    url: 'controllers/deleteSection.php',
                    type: 'POST',
                    data: { id: rowId },
                    success: function (response) {
                        var data = JSON.parse(response);

                        if (data.status === "success") {
                            swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            swal.fire({
                                title: 'Failed!',
                                text: data.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function (error) {
                        // Handle error
                        console.error('Error:', error);
                    }
                });
            }
        });


    });

    $('#section').on('click', '.btn-edit', function (e) {
        e.preventDefault();
        var rowId = $(this).data('id');

        // open changeAdvisorModal modal
        $('#changeAdvisorModal').modal('show');
    });

    $('#addSectionForm').on('submit', function (e) {
        e.preventDefault();

        // Get form data
        var formData = $(this).serialize();

        // Perform add operation (AJAX call to server)
        $.ajax({
            url: 'controllers/addSection.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                var data = JSON.parse(response);

                if (data.success) {
                    swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    swal.fire({
                        title: 'Failed!',
                        text: data.message,
                        icon: 'error'
                    });

                }
            },
            error: function (error) {
                // Handle error
                console.error('Error:', error);
            }
        });
    });
})