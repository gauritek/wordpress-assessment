jQuery(function($) {
    $('#project-type-filter').on('change', function() {
        var term_id = $(this).val();

        $.ajax({
            url: projectsFilter.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_projects',
                term_id: term_id
            },
            success: function(response) {
                $('#projects-archive').html(response);
            }
        });
    });
});
