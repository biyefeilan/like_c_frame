//window.onscroll = function()
//{
//    if( window.XMLHttpRequest ) {
//        if (document.documentElement.scrollTop > 0 || self.pageYOffset > 0) {
//            jQuery('#primary_left').css('position','fixed');
//            jQuery('#primary_left').css('top','0');
//        } else if (document.documentElement.scrollTop < 0 || self.pageYOffset < 0) {
//            jQuery('#primary_left').css('position','absolute');
//            jQuery('#primary_left').css('top','175px');
//        }
//    }
//}

function initMenu() {
    jQuery('#menu ul ul').hide();
    jQuery('#menu li.current ul').show();
	jQuery('#menu > ul > li').click(function() {
		if (!jQuery(this).hasClass('current')) {
			jQuery(this).parent().find("ul").slideUp('fast');
			jQuery(this).parent().find("li").removeClass("current");
			jQuery(this).find("ul").slideToggle('fast');
			jQuery(this).toggleClass("current");
		}
	});
	jQuery('#menu ul li li').click(function() {
		jQuery(this).parent().parent().parent().find("ul li").removeClass("active");
		jQuery(this).addClass("active");
	});
	jQuery('#menu a').click(function(event){
		if (!/^\s*#\s*$|^\s*javascript/i.test($(this).attr('href'))) {
			event.preventDefault();
			load($(this).attr('href'));
		}
	});
}

function load(_url) {
	jQuery('#primary_right').showLoading();
	$.ajax({
		url: _url,
		cache: false,
		success: function(html){
			jQuery('#primary_right').hideLoading();
			$('#primary_right > .inner').html(html);
			add_style();
		}
	});
}

function load_page_json(url, data, func) {
	url += (url.indexOf('?')==-1 ? '?' : '&') + 'json='+(new Date()).getTime();
	data = typeof data==='number' ? {"page":data} : data;
	jQuery('#primary_right').showLoading();
	jQuery.getJSON(url, data, function(json){
		jQuery('#primary_right').hideLoading();
		func(json);
		add_style();
	});
}

function page_list(url, page_count, current_page, func)
{
	func = typeof func == 'string' ? func : (/function\s+([^\{\(\s]+)/.test(func) ? RegExp['$1'] : 'Unknown');
	var get_page = function (start, end) {
		var str = '';
		for (var i=start; i<=end; i++) {
			str += '<a href="javascript:load_page_json(\''+url+'\', '+i+', '+func+')"'+(i==current_page?' class="current"':'')+'>'+i+'</a>';
		}
		return str;
	};	
	var main_show_count = 5;
	var minor_show_count = 3;
	
	var str = '';
	if (page_count < main_show_count+minor_show_count) {
		str += get_page(1, page_count);
	} else if (current_page+main_show_count>page_count) {
		str += get_page(1, minor_show_count) + '<span class="more">..</span>' + get_page(page_count-main_show_count, page_count); 
	} else {
		var start = end = current_page;
		var count = main_show_count;
		while (count>1) {
			if (start > 1) {
				start--;
				count--;
			}
			if (end < Math.min(page_count-minor_show_count, current_page+main_show_count)) {
				end++;
				count--;
			}
		}
		str += get_page(start, end) + '<span class="more">..</span>' + get_page(page_count-minor_show_count+1, page_count);
	}
	return str;
}

function add_style() {
	jQuery(".tooltip").easyTooltip({
		xOffset: -60,
		yOffset: 70
	}); 
	jQuery('.iphone').iphoneStyle();
	jQuery('.fade_hover').hover(
		function() {
			jQuery(this).stop().animate({opacity:0.6},200);
		},
		function() {
			jQuery(this).stop().animate({opacity:1},200);
		}
	);
	jQuery("table.stats").each(function() {
		if(jQuery(this).attr('rel')) { var statsType = jQuery(this).attr('rel'); }
		else { var statsType = 'area'; }
		
		var chart_width = (jQuery(this).parent().parent(".ui-widget").width()) - 60;
		jQuery(this).hide().visualize({		
			type: statsType,	// 'bar', 'area', 'pie', 'line'
			width: '800px',
			height: '240px',
			colors: ['#6fb9e8', '#ec8526', '#9dc453', '#ddd74c']
		}); // used with the visualize plugin. Statistics.
	});
			
	jQuery(".tabs").tabs(); // Enable tabs on all '.tabs' classes
	
	jQuery( ".datepicker" ).datepicker();
	
	// Slider
	jQuery(".slider").slider({
		range: true,
		values: [20, 70]
	});
				
	// Progressbar
	jQuery(".progressbar").progressbar({
		value: 40 
	});
	
	jQuery(".column").sortable({
		connectWith: '.column',
		placeholder: 'ui-sortable-placeholder',
		forcePlaceholderSize: true,
		scroll: false,
		helper: 'clone'
	});
				
	jQuery(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all").find(".portlet-header").addClass("ui-widget-header ui-corner-all").prepend('<span class="ui-icon ui-icon-circle-arrow-s"></span>').end().find(".portlet-content");

	jQuery(".portlet-header .ui-icon").click(function() {
		jQuery(this).toggleClass("ui-icon-minusthick");
		jQuery(this).parents(".portlet:first").find(".portlet-content").toggle();
	});

	jQuery(".column").disableSelection();
	
	jQuery('.checkall').click(function(){
			if (jQuery(this).attr('checked')) {
				jQuery(this).parent().parent().parent().parent().find("input[type='checkbox']").attr('checked', 'checked');
			} else {
				jQuery(this).parent().parent().parent().parent().find("input[type='checkbox']").removeAttr('checked');
			}
	});
}
 
function resize_window() {
	jQuery('#container').width(jQuery(window).width()).height(jQuery(window).height());
	jQuery('#primary_right').width(jQuery(window).width()-$('#menu').width()).height(jQuery(window).height());
}

window.onresize = resize_window;

jQuery(document).ready(function() {
	resize_window();
	initMenu();
	
	load($('#menu a:first').attr('href'));
	/*
	Cufon.replace('h1, h2, h5, .notification strong', { hover: 'true' }); // Cufon font replacement
	
			
	jQuery('#dialog').dialog({
		autoOpen: false,
		width: 650,
		buttons: {
			"Done": function() { 
				jQuery(this).dialog("close"); 
			}, 
			"Cancel": function() { 
				jQuery(this).dialog("close"); 
			} 
		}
	}); // Default dialog. Each should have it's own instance.
			
	jQuery('.dialog_link').click(function(){
		jQuery('#dialog').dialog('open');
		return false;
	}); // Toggle dialog
	
	jQuery('.notification').hover(function() {
 		jQuery(this).css('cursor','pointer');
 	}, function() {
		jQuery(this).css('cursor','auto');
	}); // Close notifications
			
	jQuery('.checkall').click(
		function(){
			jQuery(this).parent().parent().parent().parent().find("input[type='checkbox']").attr('checked', jQuery(this).is(':checked'));   
		}
	); // Top checkbox in a table will select all other checkboxes in a specified column
			
	jQuery('.iphone').iphoneStyle(); //iPhone like checkboxes

	jQuery('.notification span').click(function() {
		jQuery(this).parents('.notification').fadeOut(800);
	}); // Close notifications on clicking the X button
			
	jQuery(".tooltip").easyTooltip({
		xOffset: -60,
		yOffset: 70
	}); // Tooltips! 
			
	jQuery('.fade_hover').hover(
		function() {
			jQuery(this).stop().animate({opacity:0.6},200);
		},
		function() {
			jQuery(this).stop().animate({opacity:1},200);
		}
	); // The fade function
			
	//sortable, portlets
	jQuery(".column").sortable({
		connectWith: '.column',
		placeholder: 'ui-sortable-placeholder',
		forcePlaceholderSize: true,
		scroll: false,
		helper: 'clone'
	});
				
	jQuery(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all").find(".portlet-header").addClass("ui-widget-header ui-corner-all").prepend('<span class="ui-icon ui-icon-circle-arrow-s"></span>').end().find(".portlet-content");

	jQuery(".portlet-header .ui-icon").click(function() {
		jQuery(this).toggleClass("ui-icon-minusthick");
		jQuery(this).parents(".portlet:first").find(".portlet-content").toggle();
	});

	jQuery(".column").disableSelection();
	
	jQuery("table.stats").each(function() {
		if(jQuery(this).attr('rel')) { var statsType = jQuery(this).attr('rel'); }
		else { var statsType = 'area'; }
		
		var chart_width = (jQuery(this).parent().parent(".ui-widget").width()) - 60;
		jQuery(this).hide().visualize({		
			type: statsType,	// 'bar', 'area', 'pie', 'line'
			width: '800px',
			height: '240px',
			colors: ['#6fb9e8', '#ec8526', '#9dc453', '#ddd74c']
		}); // used with the visualize plugin. Statistics.
	});
			
	jQuery(".tabs").tabs(); // Enable tabs on all '.tabs' classes
	
	jQuery( ".datepicker" ).datepicker();
	
	// Slider
	jQuery(".slider").slider({
		range: true,
		values: [20, 70]
	});
				
	// Progressbar
	jQuery(".progressbar").progressbar({
		value: 40 
	});
	*/
});

