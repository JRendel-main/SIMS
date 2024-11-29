$(document).ready(() => {
    $.ajax({
        url: 'controllers/getStrand.php',
        type: 'GET',
        dataType: 'json',
        success: (response) => {
            $('#strand').DataTable({
                data: response,
                columns: [
                    {
                        title: 'Strand ID',
                        data: 'strand_id'
                    },
                    {
                        title: 'Strand Name',
                        data: 'strand_name'
                    },
                    {
                        title: 'Action',
                        data: null,
                        render: function (data, type, row) {
                            return '<button class="btn btn-danger btn-sm btn-delete" data-id="' + row.section_id + '">Delete</button>' +
                                '<button class="btn btn-info btn-sm btn-edit" data-id="' + row.section_id + '">Edit</button>';
                        }
                    }
                ],
            });
        },
        error: (error) => {
            console.error('Error fetching data:', error);
        }
    });

    $('#addStrandForm').on('submit', function (e) {
        e.preventDefault();

        var data = $(this).serialize();

        $.ajax({
            url: 'controllers/addStrand.php',
            type: 'POST',
            data: data,
            success: (response) => {
                console.log(response);
                swal.fire({
                    title: 'Success',
                    text: 'Strand added successfully',
                    icon: 'success'
                }).then(() => {
                    location.reload();
                });
            },
            error: (error) => {
                console.error('Error adding strand:', error);
                swal.fire({
                    title: 'Error',
                    text: 'An error occurred. Please try again.',
                    icon: 'error'
                });
            }
        });
    });
})