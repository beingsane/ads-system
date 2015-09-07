$(document).ready(function() {
    $('.add-ajax').click(function() {
        var url = $(this).data('url');
        var container = $(this).data('container');
        
        var html =
            '<div class="ajax-item">'
            + '</div>';
        
        $(html)
            .appendTo($(container))
            .load(url);
    });
    
    $('body').on('click', '.remove-item', function() {
        $(this).closest($(this).data('dismiss')).remove();
    });
});