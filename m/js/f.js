/*
 * Additional function for forms.html
 *	Written by ThemePixels	
 *	http://themepixels.com/
 *
 *	Copyright (c) 2012 ThemePixels (http://themepixels.com)
 *	
 *	Built for Katniss Premium Responsive Admin Template
 *  http://themeforest.net/category/site-templates/admin-templates
 */

jQuery(document).ready(function(){
	
	// Transform upload file
	jQuery('.uniform-file').uniform();
	
	// Date Picker
	jQuery("#datepicker").datepicker();
	
	// Dual Box Select
	var db = jQuery('#dualselect').find('.ds_arrow button');	//get arrows of dual select
	var sel1 = jQuery('#dualselect select:first-child');		//get first select element
	var sel2 = jQuery('#dualselect select:last-child');			//get second select element
	
	sel2.empty(); //empty it first from dom.
	
	db.click(function(){
		var t = (jQuery(this).hasClass('ds_prev'))? 0 : 1;	// 0 if arrow prev otherwise arrow next
		if(t) {
			sel1.find('option').each(function(){
				if(jQuery(this).is(':selected')) {
					jQuery(this).attr('selected',false);
					var op = sel2.find('option:first-child');
					sel2.append(jQuery(this));
				}
			});	
		} else {
			sel2.find('option').each(function(){
				if(jQuery(this).is(':selected')) {
					jQuery(this).attr('selected',false);
					sel1.append(jQuery(this));
				}
			});		
		}
		return false;
	});	
	
	// Tags Input
	jQuery('#tags').tagsInput();

	// Spinner
	jQuery("#spinner").spinner({min: 0, max: 100, increment: 2});
	
	// Character Counter
	jQuery("#textarea2").charCount({
		allowed: 120,		
		warning: 20,
		counterText: 'Characters left: '	
	});
	
	// Select with Search
	jQuery(".chzn-select").chosen();
	
	// Textarea Autogrow
	jQuery('#autoResizeTA').autogrow();	
	
	
	// With Form Validation
	jQuery("#form1").validate({
		rules: {
			p_name: "required",
			d_name: "required",
			d_id: "required",
			p_e_date: "required",
			p_sta: "required",
			b_e_date: "required",
			b_stat: "required",
			i_name: "required",
			i_e_date: "required",
			i_stat: "required",
			i_size: "required",
			i_unit: "required",
			p_img: "required",
			b_name: "required",
			email: {
				required: true,
				email: true,
			},
			location: "required",
			selection: "required"
		},
		messages: {
			p_name: "This Field is Required",
			d_name: "This Field is Required",
			d_id: "This Field is Required",
			p_e_date: "This Field is Required",
			p_sta: "This Field is Required",
			b_e_date: "This Field is Required",
			b_stat: "This Field is Required",
			i_name: "This Field is Required",
			i_stat: "This Field is Required",
			i_e_date: "This Field is Required",
			i_size: "This Field is Required",
			i_unit: "This Field is Required",
			p_img: "Please Select a valid Image",
			b_name: "Please Select a valid Image",
			email: "Please enter a valid email address",
			location: "Please enter your location"
		},
		highlight: function(label) {
			jQuery(label).closest('.control-group').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('Ok!').addClass('valid')
	    		.closest('.control-group').addClass('success');
	    }
	});
	
	jQuery('#timepicker1').timepicker();
	
	
	// color picker
	if(jQuery('#colorpicker').length > 0) {
		jQuery('#colorSelector').ColorPicker({
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				jQuery('#colorSelector span').css('backgroundColor', '#' + hex);
				jQuery('#colorpicker').val('#'+hex);
			}
		});
	}
	
});