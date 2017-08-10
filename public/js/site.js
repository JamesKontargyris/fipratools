(function(){

    // Confirm if the action should be completed
    $('.js-confirm').on('click', function () {
        var strconfirm = confirm("Are you sure?");
        if (strconfirm == true) {
            return true;
        }

        return false;
    });

    // Initialise Masonry
    $('.masonry-grid').masonry({
        // options
        itemSelector: '.masonry-grid__item',
        columnWidth: '.masonry-grid__grid-sizer',
        percentPosition: true,
    });

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

    // Ensure numeric input
    $('.numeric').numeric();
    // Apply select2 library to select-search-multiple fields
    $('.select2').select2();
    // Apply tagsinput library to tags-input fields
    $('.tags-input').tagsInput({ 'defaultText': '', 'width':'100%', 'height':'90px', 'delimiter': ';'});
    // Don't submit the form with the enter key
    $('form.disable-submit-on-press-return').on("keypress", ":input:not(textarea):not([type=submit])", function(event) {
        if (event.keyCode == 13) { event.preventDefault(); }
    });

    // If "none of the above" is ticked on the team question in the knowledge survey,
    // untick all other ticked expertise areas (and vice versa).
    $('input[type=checkbox][name="expertise_team[]"][value="0"]').on('click', function(e)
    {
       $('input[type=checkbox][name="expertise_team[]"][value!="0"]').attr('checked', false);
    });

    $('input[type=checkbox][name="expertise_team[]"][value!="0"]').on('click', function(e)
    {
        $('input[type=checkbox][name="expertise_team[]"][value="0"]').attr('checked', false);
    });

    // In the knowledge survey, if no membership, association or position checkboxes are ticked,
    // tick the "none of the above" checkbox
    if(! $('.membership-option[checked=checked]').length) {
        $('input[type=checkbox][name="no_memberships"]').attr('checked', true);
    }

    // If "none of the above" is ticked in the memberships section of the knowledge survey,
    // untick all other ticked options (and vice versa).
    $('input[type=checkbox][name="no_memberships"][value="0"]').on('click', function(e)
    {
        $('.membership-option').attr('checked', false).each(function() {
            var target = $('.' + $(this).attr('name') + '_details');
            if(this.checked) {
                target.slideDown();
            } else {
                target.slideUp();
            }
        });
    });
    $('.membership-option[value!="0"]').on('click', function(e)
    {
        $('input[type=checkbox][name="no_memberships"]').attr('checked', false);
    });


    // Remove repeatable row when cross icon clicked
    $('.remove-repeatable-row').on('click', function()
    {
        $(this).closest('tr').remove();
        return false;
    });

    $('.entry-table-new-row-button').on('click', function(e)
    {
        var targetTable = $(this).data('target-table'),
            repeatingRow = $(targetTable + ' tbody .entry-table-repeatable-row').clone(),
            noOfRows = $(this).data('id-index') + 1;

        repeatingRow.find('input').prop('disabled', false);
        repeatingRow.find('select').prop('disabled', false);

        // public-office table
        if(targetTable == '.public-office') {
            repeatingRow.find('.position-field').attr('name', 'public_office[' + noOfRows + '][position]');
            repeatingRow.find('.from-field').attr('name', 'public_office[' + noOfRows + '][from]');
            repeatingRow.find('.to-field').attr('name', 'public_office[' + noOfRows + '][to]');
        }

        // political-party table
        if(targetTable == '.political-party') {
            repeatingRow.find('.position-field').attr('name', 'political_party[' + noOfRows + '][position]');
            repeatingRow.find('.party-field').attr('name', 'political_party[' + noOfRows + '][party]');
            repeatingRow.find('.from-field').attr('name', 'political_party[' + noOfRows + '][from]');
            repeatingRow.find('.to-field').attr('name', 'political_party[' + noOfRows + '][to]');
        }

        // unit_staff_positions_in_public_office table (Head of Unit survey)
        if(targetTable == '.unit_staff_positions_in_public_office_people') {
            repeatingRow.find('.name-field').attr('name', 'unit_staff_positions_in_public_office_people[' + noOfRows + '][name]');
            repeatingRow.find('.position-field').attr('name', 'unit_staff_positions_in_public_office_people[' + noOfRows + '][position]');
            repeatingRow.find('.from-field').attr('name', 'unit_staff_positions_in_public_office_people[' + noOfRows + '][from]');
        }

        // unit_staff_carrying_out_public_affairs table (Head of Unit survey)
        if(targetTable == '.unit_staff_carrying_out_public_affairs') {
            repeatingRow.find('.name-field').attr('name', 'unit_staff_carrying_out_public_affairs[' + noOfRows + '][name]');
            repeatingRow.find('.seniority-field').attr('name', 'unit_staff_carrying_out_public_affairs[' + noOfRows + '][seniority]');
        }

        // points_of_contact_people table (Head of Unit survey)
        if(targetTable == '.points_of_contact_people') {
            repeatingRow.find('.name-field').attr('name', 'points_of_contact_people[' + noOfRows + '][name]');
        }

        // online_platform_other_details table (Head of Unit survey)
        if(targetTable == '.online_platform_other_details') {
            repeatingRow.find('.name-field').attr('name', 'online_platform_other_details[' + noOfRows + '][name]');
            repeatingRow.find('.url-field').attr('name', 'online_platform_other_details[' + noOfRows + '][url]').addClass('url-format');
        }

        $(this).data('id-index', noOfRows);

        $(targetTable + ' tbody').append('<tr>' + repeatingRow.html() + '</tr>');

        // Trigger the remove button
        $('.remove-repeatable-row').on('click', function()
        {
            $(this).closest('tr').remove();
            return false;
        });
        // Trigger adding http:// to url fields if the user hasn't already
        $('.url-format').on('blur', function()
        {
            var urlEntry = $(this);
            urlEntry.val(urlEntry.val().replace(/^https?:\/\//i, ""));
            urlEntry.val('http://' + urlEntry.val());
        });

        return false;
    });

    // Make sure contract percentage fields on Head of Unit survey add up to 100%
    $('.percent_100_field_1, .percent_100_field_2').on('keyup', function()
    {
       var $this = $(this),
       percentage = $this.val();
       console.log(percentage);
       if(percentage >= 0 && percentage <= 100) {
           if($this.hasClass('percent_100_field_1')) {
               $('.percent_100_field_2').val(100 - percentage);
           } else {
               $('.percent_100_field_1').val(100 - percentage);
           }
       }
    });

    // Add http:// to url fields if the user hasn't already
    $('.url-format').on('blur', function()
    {
        var urlEntry = $(this);
        urlEntry.val(urlEntry.val().replace(/^https?:\/\//i, ""));
        urlEntry.val('http://' + urlEntry.val());
    });

    // Reveal further details entry box on Knowledge Survey form

    // On page load
    $('.reveal-details-entry').each(function()
    {
        var target = $('.' + $(this).attr('name') + '_details');

       if(this.checked) {
        target.show().find(':input').each(function()
        {
            if( $(this).attr('name').indexOf('999') == -1)
            {
                $(this).prop('disabled', false);
            }
        });
       }
    });

    // When clicked
    $('.reveal-details-entry, .membership-option').change(function()
    {
        var target = $('.' + $(this).attr('name') + '_details');
       if(this.checked) {
            target.slideDown().find(':input').each(function()
            {
                if( $(this).attr('name').indexOf('999') == -1)
                {
                    $(this).prop('disabled', false);
                }
            });
       } else {
           target.slideUp().find(':input').each(function()
           {
               if( $(this).attr('name').indexOf('999') == -1)
               {
                   $(this).prop('disabled', true);
               }
           });
       }
    });

    // Add .hide-details-entry class logic for radio buttons
    // On page load
    $('.hide-details-entry').each(function()
    {
        var target = $('.' + $(this).attr('name') + '_details');

        if(this.checked) {
            target.hide().find(':input').each(function()
            {
                if( $(this).attr('name').indexOf('999') == -1)
                {
                    $(this).prop('disabled', true);
                }
            });;
        }
    });

    // When clicked
    $('.hide-details-entry').change(function()
    {
        var target = $('.' + $(this).attr('name') + '_details');
        if(this.checked) {
            target.slideUp().find(':input').each(function()
            {
                if( $(this).attr('name').indexOf('999') == -1)
                {
                    $(this).prop('disabled', true);
                }
            });;
        }
    });

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

    // Show only expertise areas in profile view on page load
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

    // Show more button functionality
    // Reveals more rows in an index-table
    // First, get all the group names set in data-show-more-group attributes
    var items = {};
    $('[data-show-more-group]').each(function() {
        items[$(this).attr('data-show-more-group')] = true;
    });
    var result = new Array();
    for(var i in items)
    {
        result.push(i);
    }

    // Then iterate through them to set up each group of rows
    $.each(result, function(key, group)
    {
        console.log(group);
        var showMoreRows = $('.show-more__row[data-show-more-group="' + group + '"]'),
            showMoreButton = $('.show-more__button[data-target-group="' + group + '"]');
        if(showMoreRows.length > 10) {
            // Display the show more button as there are more than 20 rows in the group
            showMoreButton.addClass('active');
            showMoreRows.addClass('show-more__row--hidden');
            var hiddenRowsToShow = $('.show-more__row--hidden[data-show-more-group="' + group + '"]:lt(10)');
            hiddenRowsToShow.each(function()
            {
                $(this).toggleClass('show-more__row--hidden', 'show-more__row');
            });
        }
    });


    $('.show-more__button').on('click', function(e)
    {
        var targetGroup = $(this).data('target-group'),
            hiddenRowsToShow = $('.show-more__row--hidden[data-show-more-group="' + targetGroup + '"]:lt(10)'),
            showMoreButton = $(this);
        hiddenRowsToShow.each(function()
        {
            $(this).fadeIn();
            $(this).toggleClass('show-more__row--hidden', 'show-more__row', function()
            {
                var remainingHiddenRows = $('.show-more__row--hidden[data-show-more-group="' + targetGroup + '"]');
                if( remainingHiddenRows.length == 0 )
                {
                    showMoreButton.hide();
                }
            });
        });

        return false;
    })


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