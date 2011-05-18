$(document).ready(function() {
	$('#toggle_schwerpunkte').click(function() {
		var showOrHide = $('#filter_schwerpunkte').css('display');
		if(showOrHide == 'none') {
			$('#filter_schwerpunkte').show('fast');
			$('#toggle_schwerpunkte > img').replaceWith('\<img src=\".\/img\/dots_white_left.png\" alt=\"Clear\" \/\>');
		} else {
			$('#toggle_schwerpunkte > img').replaceWith('\<img src=\".\/img\/dots_white_down.png\" alt=\"Clear\" \/\>');
			$('#filter_schwerpunkte').hide('fast');
		}
	});
	
	$('#toggle_rating').click(function() {
		var showOrHide = $('#filter_rating').css('display');
		if(showOrHide == 'none') {
			$('#filter_rating').show('fast');
			$('#toggle_rating > img').replaceWith('\<img src=\".\/img\/dots_white_left.png\" alt=\"Clear\" \/\>');
		} else {
			$('#toggle_rating > img').replaceWith('\<img src=\".\/img\/dots_white_down.png\" alt=\"Clear\" \/\>');
			$('#filter_rating').hide('fast');
		}
	});
	
	$('#toggle_themen').click(function() {
		var showOrHide = $('#filter_themen').css('display');
		if(showOrHide == 'none') {
			$('#filter_themen').show('fast');
			$('#toggle_themen > img').replaceWith('\<img src=\".\/img\/dots_white_left.png\" alt=\"Clear\" \/\>');
		} else {
			$('#toggle_themen > img').replaceWith('\<img src=\".\/img\/dots_white_down.png\" alt=\"Clear\" \/\>');
			$('#filter_themen').hide('fast');
		}
	});
	
	var toggle = false;
	$('#toggle_bewertungen').click(function() {
		if(toggle == false) {
			$('.comment_box:gt(4)').show('fast');
			$('#toggle_bewertungen').html('Neuste anzeigen');
			toggle = true;
		} else {
			$('.comment_box:gt(4)').hide('fast');
			$('#toggle_bewertungen').html('Alle anzeigen');
			toggle = false;
		}
	});
});
