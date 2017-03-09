(function(){

    //If the logo and title section is tapped, toggle the super menu and title arrow direction
    $('.logo').on('click', function()
    {
        $('.super-menu__container').slideToggle();
        $('.logo > span > i').toggleClass('fa-caret-down fa-caret-up');
    })

	// Show all elements with a class of showjs
	$('.showjs').css('display', 'block');
    // Hide all elements with a class of hidejs
    $('.hidejs, .show-uk').css('display', 'none');
	// Show all help buttons
	$('.help').css('display', 'inline-block');
    // Hide all help boxes
    $('.help-box').css('display', 'none');
    //Show the datepicker
    var dates = $("#date").datepicker({
        dateFormat: "d MM yy",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
    });

    // Apply select2 library to select-search-multiple fields
    $('.select2').select2();

    //If there are no page navigation links, hide the blank div
    if($('.page-menu-nav ul.small-font li').length == 0)
    {
        $('.page-menu-nav').hide();
    }

    $('.print-button').on('click', function()
    {
        window.print();
    });

    $('.pdf-export-button').on('click', function()
    {
       $('#content').append('<div class="alert alert-overlay alert-info">Creating PDF – please wait. This can take up to a minute.</div>');
        $('.alert-overlay').hide().slideDown(200).delay(2000).slideUp(200);
    });

    $('.excel-export-button').on('click', function()
    {
        $('#content').append('<div class="alert alert-overlay alert-info">Creating Excel file – please wait. This can take up to a minute.</div>');
        $('.alert-overlay').hide().slideDown(200).delay(2000).slideUp(200);
    });

    $('.list-table-filter').on('change', function()
    {
        $(this).parent('form').submit();
    });

    if($.trim($('.page-menu-nav ul').text()).length == 0) { $('.page-menu-icon-s').hide(); }

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

    //When the confirm button is clicked on the status check page, show a confirmation dialogue box
    //Continue with the confirmation if the OK button is pressed. Otherwise, do nothing.
    $('.status-check-confirm').on("click", function()
    {
        if(confirm("I confirm all client status details are correct and up-to-date.")) { return true; }
        return false;
    });

    //When the trash-logs button is clicked, show a confirmation dialogue box
    //Continue with the trashing if the OK button is pressed. Otherwise, do nothing.
    $('.trash-logs').on("click", function()
    {
        if(confirm("Are you sure you want to delete all event logs?")) { return true; }
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

    // Make the products select box a nicer multi-select box
    $('#product_select').multiSelect();
    // Make the sectors select box a nicer multi-select box
    $('#sector_select').multiSelect();
    // Make the languages select box a nicer multi-select box
    $('#language_select').multiSelect({
        /*keepOrder: true,*/
        selectableHeader: "<div class='custom-header'><strong>Select languages:</strong></div>",
        selectionHeader: "<div class='custom-header'><strong>I speak / write:</strong></div>"
    });
    // Make the fluent languages select box a nicer multi-select box
    $('#fluent_select').multiSelect({
        selectableHeader: "<div class='custom-header'><strong>Select languages:</strong></div>",
        selectionHeader: "<div class='custom-header'><strong>I am fluent in:</strong></div>"
    });


    // Widgets: create a slug from the name entered, if no slug already exists
    $('.widget-name').blur(function()
    {
        if($('.widget-slug').val().length == 0)
       {
           $('.widget-slug').val(sluggerize($('.widget-name').val()).trim());
       }
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


    //Return clients for the selected unit when creating a client link
    getClientsForUnit($('#unit_1'));
    getClientsForUnit($('#unit_2'));

    $('#unit_1').on('change', function()
    {
        getClientsForUnit($('#unit_1'));
    });

    $('#unit_2').on('change', function()
    {
        getClientsForUnit($('#unit_2'));
    });

    // Knowledge list buttons
    $('.button-show-all').on('click', function(e)
    {
        $('.expertise-list__container').show();
        $('.expertise-list__row').show();

       return false;
    });
    $('.button-show-expertise').on('click', function(e)
    {
        $('.expertise-list__row').hide();
        $('.expertise-list__row.user-expertise').show();

        // Use the .user-expertise class to tell if .expertise-list__container contains any user expertise
        // If not, hide the whole container when only showing the user's expertise
        $('.expertise-list__container').each(function()
        {
            if( ! $(this).find('.user-expertise').length) {
                $(this).hide();
            }
        });

        return false;
    });

    function getClientsForUnit($element)
    {
        var $clients_select = $element.closest('.formfield').next().find('.clients');

        if($element.val() != "")
        {
            $.ajax({
                url: "/getclients?unit_id=" + $element.val()
            })
                .done(function( data ) {
                    $clients_select.html('');
                    $clients_select.append('<option value="">Please select...</option>');
                    $.each(data, function(id, name)
                    {
                        $clients_select.append('<option value="' + id + '">' + name + '</option>');
                    });
                });
        }
        else
        {
            $clients_select.html('');
            $clients_select.append('<option value="">Please select a unit...</option>');
        }
    }


//    UK-specific client form add/edit controls
    if($.trim($('.unit-selection option:selected').text()) == 'United Kingdom' || $.trim($('input[name=unit_name]').val()) == 'United Kingdom')
    {
        show_uk_client_form_section();
    }

    $('.unit-selection, .pr-client-selection').on('change', function()
    {
        if($.trim($('.unit-selection option:selected').text()) == 'United Kingdom' || $.trim($('input[name=unit_name]').val()) == 'United Kingdom')
        {
            show_uk_client_form_section();
        }
        else
        {
            hide_uk_client_form_section();
        }
    });

    function show_uk_client_form_section()
    {
        $('.show-uk').slideDown();
        $('.show-uk select, .show-uk input').removeAttr('disabled');
        if($('select[name=pr_client]').val() == 1)
        {
            $('select[name=account_director_id]').find('option:first-child').val(0).text('None');
        }
        else
        {
            $('select[name=account_director_id]').find('option:first-child').val('').text('Please select...');
        }
    };

    function hide_uk_client_form_section()
    {
        $('.show-uk').slideUp();
        $('.show-uk select, .show-uk input').attr('disabled', 'disabled');
        $('select[name=account_director_id]').find('option:first-child').val('').text('Please select...');
    };

    function sluggerize(string)
    {
        return string.toString().toLowerCase().replace(/ /g,"_").replace(/\W/g, '');
    }

})();