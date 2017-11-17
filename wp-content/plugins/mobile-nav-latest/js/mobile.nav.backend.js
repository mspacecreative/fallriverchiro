jQuery(document).ready(function( $ ) {

	//show hide the "left menu width" setting
	var menu_pos_switch = $('#sdmn_menu_pos'),
        searchbar = $('#sdmn_searchbar'),
		menu_pos_switch_val = menu_pos_switch.val(),
        custom_for_logged_in = $('#custom_for_logged_in'),
        custom_for_logged_in_val = custom_for_logged_in.val(),
        searchbar_val = searchbar.val(),
		left_width_set = menu_pos_switch.closest('tr').first().next('tr'),
        searchbar_set = searchbar.closest('tr').first().next('tr'),
        logged_in_menu = $('#logged_in_menu'),
        logged_in_menu_set = logged_in_menu.closest('tr').first();



	(menu_pos_switch_val == 'top')? left_width_set.hide() : left_width_set.show();
    (custom_for_logged_in_val == 'no')? logged_in_menu_set.hide() : logged_in_menu_set.show();

	menu_pos_switch.on('change', function() {
		menu_pos_switch_val = $(this).val();
		(menu_pos_switch_val == 'top')? left_width_set.hide() : left_width_set.show();
	});

    custom_for_logged_in.on('change', function() {
        custom_for_logged_in_val = $(this).val();
        (custom_for_logged_in_val == 'no')? logged_in_menu_set.hide() : logged_in_menu_set.show();
    });

	$('#upload_bar_logo_button').click(function(e) {
    	e.preventDefault();

    	var sdrn_logo_uploader = wp.media({
        	title: 'Sellect the logo for Mobile.Nav menu bar',
        	button: {
            	text: 'Select image'
        	},
        	multiple: false
    	}).on('select', function() {
        var attachment = sdrn_logo_uploader.state().get('selection').first().toJSON();
            //console.log(attachment.url);
        	$('.sdrn_bar_logo_prev').attr('src', attachment.url).show();
        	$('.sdrn_bar_logo_url').val(attachment.url);
    	}).open();
	});

	$('.sdrn_disc_bar_logo').click(function(e) {
    	e.preventDefault();
    	$('.sdrn_bar_logo_prev').hide();
    	$('.sdrn_bar_logo_url').val('');
    });


    (searchbar_val == 'no')? searchbar_set.hide() : searchbar_set.show();

    searchbar.on('change', function() {
        searchbar_val = $(this).val();
        (searchbar_val == 'no')? searchbar_set.hide() : searchbar_set.show();
    });




    $('.cii_select_file').click(function(e) {
        e.preventDefault();
        var t = $(this);

        var sdrn_icon_uploader = wp.media({
            title: 'Sellect the icon image for this menu item',
            button: {
                text: 'Select image'
            },
            multiple: false
        }).on('select', function() {
        var attachment = sdrn_icon_uploader.state().get('selection').first().toJSON();
        //console.log(attachment.url);
            t.parent().find('.cii_image_prev').attr('src', attachment.url).show();
            t.parent().find('.cii_image_input').val(attachment.url);
        }).open();
    });
    $('.remove_cii').click(function(e) {
        e.preventDefault();
        var t = $(this);
        t.parent().parent().find('.cii_image_prev').hide();
        t.parent().parent().find('.cii_image_input').val('');
    });


});
