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
			
			// parse rating avg and cnt
			var rnt_cnt = parseInt($('#rating_cnt').html());
			var rnt_avg = parseInt($('#rating_all').width())/16;
			var new_rnt = parseInt(rating.val());
			
			// calulate new rating avg
			var a = rnt_cnt * rnt_avg;
			var b = a + new_rnt;
			var c = b / ++rnt_cnt;
			
			// change rating avg
			$('#rating_all').width(c*16);
			$('#rating_cnt').html(rnt_cnt);
			// insert new rating
			$('<div class="comment_box"><div class="rating_bg"><div class="rating_stars" style="width:'+rating.val()*20+'%"></div></div><p>'+comment.val()+'</p></div><hr />').insertBefore('#comments');
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
			// do something
		}
	});
	
	return false;
	});
});
