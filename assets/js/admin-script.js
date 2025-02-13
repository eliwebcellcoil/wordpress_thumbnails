jQuery(document).ready(function($) {
    $('#wptr-start-btn').click(function() {
        $(this).prop('disabled', true).text('Processing...');
        $.post(WPTR_Ajax.ajaxurl, { action: 'wptr_regenerate_thumbnails' }, function(response) {
            if (response.success) {
                $('#wptr-progress').html('<pre>' + JSON.stringify(response.data, null, 2) + '</pre>');
            } else {
                alert(response.data.message);
            }
            $('#wptr-start-btn').prop('disabled', false).text('Start Regeneration');
        });
    });
});
