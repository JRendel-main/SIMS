$(document).ready(() => {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    $('#addSubjectForm').submit((e) => {
        e.preventDefault();

        const formData = $('#addSubjectForm').serialize();
        $.ajax({
            url: 'controllers/addSubject.php',
            type: 'POST',
            data: formData,
            success: (response) => {
                response = JSON.parse(response);
                if (response.success) {
                    swal.fire({
                        title: 'Subject Added',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    })
                } else {
                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            }
        })
    });

    // Initialize DataTable
    var table = $('#subject').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "controllers/getSubjects.php",
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": `<button class="btn btn-danger deleteSubject" data-toggle="tooltip" title="Delete">
                                  <i class="bi bi-trash"></i>
                              </button>`
        }],
        "order": [
            [0, 'asc']
        ],
        "responsive": true,
        "columns": [
            {
                title: 'ID',
                data: null,
                render: function (data, type, row) {
                    return data.subject_id;
                }
            },
            {
                title: 'Academic Year',
                data: 'year'
            },
            {
                title: 'Strand',
                data: 'strand_name'
            },
            {
                title: 'Semester',
                data: 'semester_name'
            },
            {
                title: 'Subject',
                data: 'subject_name'
            },
            {
                title: 'Subject Code',
                data: 'subject_code'
            },
            {
                title: 'Actions',
                data: null,
                // Add three buttons for edit, delete, and view
                render: function (data, type, row) {
                    return `<button class="btn btn-danger deleteSubject" data-id="${data.subject_id}" data-toggle="tooltip" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button class="btn btn-warning editSubject" data-id="${data.subject_id}" data-toggle="tooltip" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-info viewSubject" data-id="${data.subject_id}" data-toggle="tooltip" title="View">
                                <i class="bi bi-eye"></i>
                            </button>
                            `;
                }
            }
        ]
    });

    // Handle delete subject
    $('#subject tbody').on('click', '.deleteSubject', function () {
        var data = table.row($(this).parents('tr')).data();
        const subjectId = data.subject_id;
        swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this subject',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'controllers/deleteSubject.php',
                    type: 'POST',
                    data: { subjectId },
                    success: (response) => {
                        response = JSON.parse(response);
                        if (response.success) {
                            swal.fire({
                                title: 'Subject Deleted',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                table.ajax.reload();
                            })
                        } else {
                            swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            })
                        }
                    }
                })
            }
        })
    });

    // Handle edit subject
    $('#subject tbody').on('click', '.editSubject', function () {
        var data = table.row($(this).parents('tr')).data();
        const subjectId = data.subject_id;
        $.ajax({
            url: 'controllers/getSubject.php',
            type: 'POST',
            data: { subjectId },
            success: (response) => {
                response = JSON.parse(response);
                if (response.status === "success") {
                    const subject = response.subject;
                    $('#editSubjectId').val(subject.subject_id);
                    $('#editYear').val(subject.year);
                    $('#editStrand').val(subject.strand_id);
                    $('#editSemester').val(subject.semester_id);
                    $('#editSubjectName').val(subject.subject_name);
                    $('#editSubjectCode').val(subject.subject_code);
                    $('#editSubjectModal').modal('show');
                } else {
                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            }
        })
    });
});
