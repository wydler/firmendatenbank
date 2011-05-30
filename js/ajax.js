$(document).ready(function() {
//click event for submit button
$('#submit_rating').click(function () {
	var rating = $('select[name=rating]');
	var comment = $('textarea[name=text]');
	
	dataString = $("#rating_form").serialize();
	
	$.ajax({
		url: "addRating.php",
		type: "post",
		data: dataString,
		// callback handler that will be called on success
		success: function(response, textStatus, jqXHR){
			// insert new rating
			if($("#comment_text").val().length <= 50)
			{
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
			
				var tmp = comment.val().replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
				$('<div class="comment_box"><div class="rating_bg"><div class="rating_stars" style="width:'+rating.val()*20+'%"></div></div><p>'+tmp+'</p></div><hr />').insertBefore('#comments');
			}
			else
			{
				$('#done').html('Der eingegebene Kommentar ist zu lang (über 50 Zeichen).');
				$('#done').css('color','#fff');
				$('#done').css('background','#c00');
				$('#done').fadeIn('slow');
			}
		},
		// callback handler that will be called on error
		error: function(jqXHR, textStatus, errorThrown){
			// log the error to the console
			//alert("error: " + errorThrown);
			$('#done').html('Sorry, something went wrong.<br />A team of highly trained monkeys has been dispatched to deal with this situation.<br /><br />'+errorThrown);
			$('#done').css('color','#fff');
			$('#done').css('background','#c00');
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
