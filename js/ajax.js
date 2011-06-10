$(document).ready(function() {
// Click-Event für Bewertungs-Button.
$('#submit_rating').click(function () {
	var rating = $('select[name=rating]');
	var comment = $('textarea[name=text]');
	
	// Formulardaten serialisieren.
	dataString = $("#rating_form").serialize();
	
	// Daten absenden.
	$.ajax({
		// Ziel URL
		url: "addRating.php",
		// Request-Typ
		type: "post",
		// Formulardaten
		data: dataString,
		// Callback-Handler, welcher bei erfolgreicher Übertragung aufgerufen wird.
		success: function(response, textStatus, jqXHR){
			// Kommentarlänge prüfen.
			if($("#comment_text").val().length <= 50)
			{
				// Kommentarformular ausblenden.
				$('#form').fadeOut('slow');
				// Nachricht einblenden.
				$('#done').fadeIn('slow');
			
				// Alter Bewertungsdurchschnitt und -anzahl parsen.
				var rnt_cnt = parseInt($('#rating_cnt').html());
				var rnt_avg = parseInt($('#rating_all').width())/16;
				
				// Neuer Bewertungswert parsen.
				var new_rnt = parseInt(rating.val());
			
				// Neuer Bewertungsdurchschnitt berechnen.
				var a = rnt_cnt * rnt_avg;
				var b = a + new_rnt;
				var c = b / ++rnt_cnt;
			
				// Bewertungsdurchschnitt und -anzahl ändern.
				$('#rating_all').width(c*16);
				$('#rating_cnt').html(rnt_cnt);
			
				// Die Zeichen (<, >, &) in HTML-Entities umwandlen.
				var tmp = comment.val().replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
				// Neue Bewertung in die Seite einfügen.
				$('<div class="comment_box"><div class="rating_bg"><div class="rating_stars" style="width:'+rating.val()*20+'%"></div></div><p>'+tmp+'</p></div><hr />').insertBefore('#comments');
			}
			else
			{
				// Fehlermeldung, falls der Kommentar zu lang ist.
				$('#done').html('Der eingegebene Kommentar ist zu lang (über 50 Zeichen).');
				$('#done').css('color','#fff');
				$('#done').css('background','#c00');
				$('#done').fadeIn('slow');
			}
		},
		// Callback-Handler, der bei Fehler aufgerufen wird.
		error: function(jqXHR, textStatus, errorThrown){
			// Fehlernachricht einblenden.
			$('#done').html('Sorry, something went wrong.<br />A team of highly trained monkeys has been dispatched to deal with this situation.<br /><br />'+errorThrown);
			$('#done').css('color','#fff');
			$('#done').css('background','#c00');
			$('#done').fadeIn('slow');
		},
		// Callback-Handler, der aufgerufen wird, wenn die Übertragung fertig ist.
		// Das bedeutet, egal oder die Übertragung erfolgreich war oder nicht.
		complete: function(){
		}
	});
	
	return false;
	});
});
