$(document).ready(function () {
    // ajax
    $.ajax({
        url: 'controllers/getAdminInfo.php',
        type: 'GET',
        success: function (data) {
            var userInfo = JSON.parse(data);
            $('#username').text(userInfo.username);
            $('#role').text(userInfo.category); // Assuming role is a property in userInfo
        }
    });
});
