
$(document).ready(function () {
    // Function to convert the teacher row into input fields
    function makeEditable() {
        // Find all grade component cells within the teacher row and make them editable
        $("#teacherRow .gradeComponent").attr("contenteditable", "true");
    }

    // Event listener for when the teacher row is clicked
    $("#teacherRow").on("click", function () {
        makeEditable();
    });
});

