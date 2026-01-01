
jQuery(document).ready(function($) {
    $('#rsvpf').submit(function(e) {
        e.preventDefault(); 
        
        var eventDate = jQuery('#hidden-event-date').val();
        console.log('RSVP - Event Date being submitted:', eventDate);

        var formData = new FormData(this); 

        $.ajax({
            url: ajax_obj.ajax_url, 
            type: 'POST',
            data: formData,
            contentType: false,  
            processData: false,  
            success: function(response) {
                if (response.success) {
                    alert('RSVP successfully submitted!');
                    $('#rsvpf')[0].reset(); 
                    $('#rsvp-form').hide(); 
                    $('#event-details').hide(); 
                }
            },
            error: function() {
                alert('Something went wrong!');
            }
        });
    });
});

