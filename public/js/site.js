(function(){
	
	// Show all elements with a class of showjs
	$('.showjs').css('display', 'block');
    // Hide all elements with a class of hidejs
    $('.hidejs').css('display', 'none');
	// Show all help buttons
	$('.help').css('display', 'inline-block');
    // Hide all help boxes
    $('.help-box').css('display', 'none');

    $('.page-menu-icon-s').on('click', function()
    {
        $('nav').slideToggle();
        return false;
    });

    $('.filter-menu-icon-s').on('click', function()
    {
        $('.filters').slideToggle();
        return false;
    });

    //If select-all button is clicked, select all checkboxes on page
    $('button.select-all, a.select-all').on('click', function()
    {
        $('body input[type=checkbox]').prop("checked", !$(this).prop("checked"));
        return false;
    });

    //If deselect-all button is clicked, deselect all checkboxes on page
    $('button.deselect-all, a.deselect-all').on('click', function()
    {
        $('body input[type=checkbox]').removeAttr('checked');
        return false;
    });

    $( ".modal-open" ).on('click', function() {
        var modalName = $(this).data('modal');
        $('.' + modalName).modal({ fadeDuration: 250 });
        return false;
    });

    //Alerts
    $('.alert button.close').on('click', function()
    {
        $(this).parent('.alert').slideUp(500);
    });

    $('.alert-overlay').hide().slideDown(200).delay(2000).slideUp(200);

})();