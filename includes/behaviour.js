$(document).ready(function () {
    // If the order filter is updated, check the val and update form order checkboxes
    $('#filter_order_select').change(function (e) { 
        e.preventDefault();
        var filterOption = '#' + $(this).val();
        $('.filter_order').prop('checked', false);
        $(filterOption).prop('checked', true);

        
    });
});