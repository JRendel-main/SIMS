$.ajax({
    url: 'controllers/getAllBoys.php',
    type: 'POST',
    data: {
        teacher_id: $('#teacher_id').val()
    },
    success: function (response) {
        var data = JSON.parse(response);
        var table = $('#boys').DataTable({
            responsive: true,
            data: data,
            columns: [{
                title: 'Student ID',
                data: 'student_id',
                visible: false
            },
            {
                title: 'Name',
                data: 'name'
            },
            {
                title: 'Action',
                data: 'student_id',
                render: function (data) {
                    return `<a href="student-profile.php?id=${data}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Grades"><i class="bi bi-bar-chart"></i></a> 
                                <a href="student-profile.php?id=${data}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Profile"><i class="bi bi-person"></i></a> 
                                <a href="student-profile.php?id=${data}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i></a>`;
                }
            },
            ],
            order: [1, 'desc']
        });
        // Activate tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});

// for girl list
$.ajax({
    url: 'controllers/getAllGirls.php',
    type: 'POST',
    data: {
        teacher_id: $('#teacher_id').val()
    },
    success: function (response) {
        var data = JSON.parse(response);
        var table = $('#girls').DataTable({
            responsive: true,
            data: data,
            columns: [{
                title: 'Student ID',
                data: 'student_id',
                visible: false
            },
            {
                title: 'Name',
                data: 'name'
            },
            {
                title: 'Action',
                data: 'student_id',
                render: function (data) {
                    return `<a href="student-profile.php?id=${data}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Grades"><i class="bi bi-bar-chart"></i></a> 
                                <a href="student-profile.php?id=${data}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Profile"><i class="bi bi-person"></i></a> 
                                <a href="student-profile.php?id=${data}" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="bi bi-trash"></i></a>`;
                }
            },
            ],
            order: [1, 'desc']
        });
        // Activate tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});