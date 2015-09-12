$(document).ready(function() {
    $('.calendar-button').click(function() {
        $(this).next('input').focus();
    });
});