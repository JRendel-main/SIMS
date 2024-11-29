$(document).ready(function () {
    // Function to show loader in the add teacher button
    function showLoader() {
        $('#addTeacherManuallyBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
        $('#addTeacherManuallyBtn').prop('disabled', true);
    }

    // Function to hide loader in the add teacher button
    function hideLoader() {
        $('#addTeacherManuallyBtn').html('Add Teacher');
        $('#addTeacherManuallyBtn').prop('disabled', false);
    }

    // Initiate DataTable
    var table = $('#teacher-lists').DataTable({
        "processing": true,
        "serverSide": true,
        "columnDefs": [
            { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 4 }
        ],
        "ajax": {
            "url": "controllers/getTeacherLists.php",
            "type": "GET"
        },
        "columns": [
            {
                title: 'Roll No',
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                title: 'Teacher Name',
                data: 'name'
            },
            {
                title: 'Teacher Title',
                data: 'title'
            },
            {
                title: 'Email Address',
                data: 'email'
            },
            {
                title: 'Gender',
                data: 'gender'
            },
            {
                title: 'Phone',
                data: 'contact_num'
            },
            {
                title: 'Action',
                data: null,
                render: function (data, type, row) {
                    return '<a class="btn btn-primary btn-sm btn-edit" data-id="' + row.teacher_id + '"><i class="bi bi-pencil"></i></a> <a class="btn btn-danger btn-sm btn-delete" data-id="' + row.teacher_id + '"><i class="bi bi-trash"></i></a>';
                }
            }
        ],
    });

    // Event handler for delete button
    $('#teacher-lists').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        // add confirmation alert using swal add two button
        swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'controllers/deleteTeacher.php',
                    type: 'POST',
                    data: { id: $(this).data('id') },
                    success: function (response) {
                        let data = JSON.parse(response);
                        if (data.success == true) {
                            swal.fire({
                                title: "Success!",
                                text: data.message,
                                icon: "success",
                                button: "Ok",
                            }).then((result) => {
                                if (result.value) {
                                    table.ajax.reload();
                                }
                            });
                        } else {
                            swal.fire({
                                title: "Error!",
                                text: data.message,
                                icon: "error",
                                button: "Ok",
                            });
                        }
                    },
                    error: function (error) {
                        swal.fire({
                            title: "Error!",
                            text: "Something went wrong!" + error,
                            icon: "error",
                            button: "Ok",
                        });
                    }
                });
            }
        });

    });

    $('#teacher-lists').on('click', '.btn-edit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'controllers/getTeacher.php',
            type: 'POST',
            data: { id: $(this).data('id') },
            success: function (response) {
                let data = JSON.parse(response);
                let teacher_id = data[0]['teacher_id']
                let first_name = data[0]['first_name']
                let middle_name = data[0]['middle_name']
                let last_name = data[0]['last_name']
                let gender = data[0]['gender']
                let dob = data[0]['dob']
                let title = data[0]['title']
                let email = data[0]['email']
                let contact_num = data[0]['contact']

                $('#editTeacherForm input[name="teacher_id"]').val(teacher_id);
                $('#editTeacherForm input[name="first_name"]').val(first_name);
                $('#editTeacherForm input[name="middle_name"]').val(middle_name);
                $('#editTeacherForm input[name="last_name"]').val(last_name);
                $('#editTeacherForm select[name="gender"]').val(gender);
                $('#editTeacherForm input[name="dob"]').val(dob);
                $('#editTeacherForm input[name="title"]').val(title);
                $('#editTeacherForm input[name="email"]').val(email);
                $('#editTeacherForm input[name="contact_num"]').val(contact_num);
                $('#editTeacherModal').modal('show');
            },
            error: function (error) {
                swal.fire({
                    title: "Error!",
                    text: "Something went wrong!" + error,
                    icon: "error",
                    button: "Ok",
                });
            }
        });
    });

    // Event handler for form submission (Edit Teacher)
    $('#editTeacherForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'controllers/editTeacher.php', // Replace with appropriate endpoint to edit teacher information
            type: 'POST',
            data: formData,
            success: function (response) {
                let data = JSON.parse(response);
                if (data.success == true) {
                    swal.fire({
                        title: "Success!",
                        text: data.message,
                        icon: "success",
                        button: "Ok",
                    }).then((result) => {
                        if (result.value) {
                            $('#editTeacherModal').modal('hide');
                            table.ajax.reload();
                        }
                    });
                } else {
                    swal.fire({
                        title: "Error!",
                        text: data.message,
                        icon: "error",
                        button: "Ok",
                    });
                }
            },
            error: function (error) {
                swal.fire({
                    title: "Error!",
                    text: "Something went wrong!" + error,
                    icon: "error",
                    button: "Ok",
                });
            }
        });
    });

    // Event handler for form submission
    $('#addTeacherForm').submit(function (e) {
        e.preventDefault();
        showLoader(); // Show loader before AJAX request
        var formData = $(this).serialize();
        $.ajax({
            url: 'controllers/addTeacher.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                hideLoader(); // Hide loader after AJAX request completes
                let data = JSON.parse(response);
                if (data.success == true) {
                    swal.fire({
                        title: "Success!",
                        text: data.message,
                        icon: "success",
                        button: "Ok",
                    }).then((result) => {
                        if (result.value) {
                            window.location.reload();
                        }
                    });
                } else {
                    swal.fire({
                        title: "Error!",
                        text: data.message,
                        icon: "error",
                        button: "Ok",
                    });
                }
            },
            error: function (error) {
                hideLoader(); // Hide loader if AJAX request fails
                swal.fire({
                    title: "Error!",
                    text: "Something went wrong!" + error,
                    icon: "error",
                    button: "Ok",
                })
            }
        });
    });
});
