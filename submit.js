$(document).on('submit', '#reg-form', function(e) {
    e.preventDefault(); // Prevent default form submission
        $.post('submit.php', $(this).serialize(), function(data) {
            $(".result").html(data); // Display the response in the result div
                $("#form1")[0].reset(); // Reset the form fields
                $('input:checkbox').prop('checked', false); // Uncheck all checkboxes
            });
        });

        // Initialize Select2 Elements
$(function() {
    $(".select2").select2();
});