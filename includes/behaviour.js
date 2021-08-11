$(document).ready(function () {
    // Ajax Request for the search form
    $("#__ajax_filter").submit(function(event) {
        // Do Not refresh
        event.preventDefault();
        // Set up AJAX Call
        var filter = $('#__ajax_filter');
        $.ajax({
            url:filter.attr('action'),
            data:filter.serialize(),
            type:filter.attr('method'),
            timeout: 5000, 
            beforeSend:function(){
                $('#results').html('<div class="half-circle-spinner"><div class="circle circle-1"></div><div class="circle circle-2"></div></div>');
            },
            success:function(data){
                setTimeout(function() {
                    $('#results').html(data);
                }, 1000);
            }
        });
        return false;

    });

    // If the order filter is updated, check the val and update form order checkboxes
    $('#filter_order_select').change(function (e) { 
        e.preventDefault();
        var filterOption = '#' + $(this).val();
        $('.filter_order').prop('checked', false);
        $(filterOption).prop('checked', true);
        $('#__ajax_filter').submit();
    });

    $('.autosubmit').change(function (e) { 
        e.preventDefault();
        $('#__ajax_filter').submit();
    });

    $('.select__').change(function (e) { 
        e.preventDefault();
        $(this).addClass('selector_activated');
        
    });

});