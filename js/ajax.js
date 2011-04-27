$(document).ready(function() {
//click event for submit button
$('#submit_rating').click(function () {
	var rating = $('select[name=rating]');
	var comment = $('textarea[name=text]');
	
	dataString = $("#rating_form").serialize();
	
	$.ajax({
		url: "addRating.php?fid=3",
		type: "post",
		data: dataString,
		// callback handler that will be called on success
		success: function(response, textStatus, jqXHR){
			// hide form
			$('#form').fadeOut('slow');
			// show confirmation
			$('#done').fadeIn('slow');
		},
		// callback handler that will be called on error
		error: function(jqXHR, textStatus, errorThrown){
			// log the error to the console
			//alert("error: " + errorThrown);
			$('#done').html('Fehler: '+errorThrown);
			$('#done').fadeIn('slow');
		},
		// callback handler that will be called on completion
		// which means, either on success or error
		complete: function(){
			// insert new rating
			$('<div class="comment_box"><div class="rating_bg"><div class="rating_stars" style="width:'+rating.val()*20+'%"></div></div><p>'+comment.val()+'</p></div><hr />').insertBefore('#comments');
		}
	});
	
	return false;
	});
});
