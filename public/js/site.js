(function(){
	
	// Show all elements with a class of showjs
	$('.showjs').css('display', 'block');
    // Hide all elements with a class of hidejs
    $('.hidejs').css('display', 'none');
	// Show all help buttons
	$('.help').css('display', 'inline-block');
    // Hide all help boxes
    $('.help-box').css('display', 'none');
    //Show the datepicker
    var dates = $("#start_date, #end_date").datepicker({
        dateFormat: "d MM yy",
        numberOfMonths: 1,
        onSelect: function(selectedDate) {
            var option = this.id == "start_date" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });

    if($.trim($('.page-menu-nav ul').text()) == '') { $('.page-menu-icon-s').hide(); }

    $('.page-menu-icon-s').on('click', function()
    {
        $('.page-menu-nav').slideToggle();
        $(this).animate({opacity:0.1}, 300, function()
        {
            $(this).html($.trim($(this).text()) == 'Actions' ? 'Close <i class="fa fa-lg fa-caret-up"></i>' : 'Actions <i class="fa fa-lg fa-caret-down"></i>');
        }).animate({opacity:1}, 300);

        return false;
    });

    $('.mobile-user-details-but').on('click', function() {
        $('.mobile-user-details-container').slideToggle();
        $('.mobile-site-nav-container').slideUp();
    });

    $('.mobile-site-nav-but').on('click', function()
    {
        $('.mobile-site-nav-container').slideToggle();
        $('.mobile-user-details-container').slideUp();
    });

    $('.filter-menu-icon-m').on('click', function()
    {
        $(this).text(function(i, text){
            return text === "Filters" ? "Close" : "Filters";
        })
        $('.filters').slideToggle();
        return false;
    });

    //When the delete-row button is clicked, show a confirmation dialogue box
    //Continue with the deletion if the OK button is pressed. Otherwise, do nothing.
    $('.delete-row').on("click", function()
    {
        if(confirm("Are you sure you want to delete this " + $(this).data('resource-type') + '?')) { return true; }
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
    $('.alert button.close').on('click', function() { $('.alert-container').slideUp(500); });

    $('.alert-overlay').hide().slideDown(200).delay(2000).slideUp(200);

    //Reveal new reporting category box on sectors.create
    $('select[name=category]').on('change', function()
    {
        if($(this).val() == 'new') {
            $('.' + $(this).data('reveal')).slideDown();
            if($('.new-category').val() == '')
            {
                $('.new-category').val($(this).val());
            }
        } else {
            $('.' + $(this).data('reveal')).slideUp();
        }
    });

    $('.sector-name').on('blur', function()
    {

    })

})();