$(document).ready(() => {
    $('#addStudentForm').submit((e) => {
        e.preventDefault();
        const form = $('#addStudentForm');
        const data = form.serialize();
        $.ajax({
            url: 'controllers/add-student.php',
            type: 'POST',
            data: data,
            success: (response) => {
                response = JSON.parse(response);
                if (response.success) {
                    swal.fire({
                        title: 'Success',
                        text: 'Student added successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    form.trigger('reset');
                } else {
                    swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: (err) => {
                swal.fire({
                    title: 'Error',
                    text: 'An error occurred. Please try again',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
    });
})