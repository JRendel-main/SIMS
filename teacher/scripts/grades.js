$(document).ready(function () {
    var table = $('#gradesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: '/teacher/grades',
            type: 'POST'
        },
        "columns": [
            { "data": "student" },
            { "data": "grade" },
            { "data": "date" },
            { "data": "actions" }
        ],
        "columnDefs": [
            {
                "targets": 3,
                "orderable": false,
                "render": function (data, type, row) {
                    return '<a href="/teacher/grades/' + row.id + '/edit" class="btn btn-primary btn-sm">Edit</a>' +
                        '<a href="/teacher/grades/' + row.id + '/delete" class="btn btn-danger btn-sm">Delete</a>';
                }
            }
        ]
    });
});