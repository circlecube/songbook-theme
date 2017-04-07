jQuery(document).ready(function($) {
	
	$('#mmenu').mmenu();

	$('#momenu').mmenu({
         position: "right"
      });


	$('.show_chords').on('click', function(e){
		$('body').toggleClass('hide-chords');
		if( $('body').hasClass('hide-chords') ){
			$(this).text('Show Chords');
			localStorage.hide_chords = 'true';
		}
		else{
			$(this).text('Hide Chords');
			localStorage.hide_chords = 'false';
		}
	});

	$('.colorscheme_dark').on('click', function(e){
		$('body').toggleClass('colorscheme_dark');
		if( $('body').hasClass('colorscheme_dark') ){
			$(this).text('Light');
			localStorage.colorscheme_dark = 'true';
		}
		else{
			$(this).text('Dark');
			localStorage.colorscheme_dark = 'false';
		}
	});

	if (localStorage.colorscheme_dark == 'true'){
		$('body').addClass('colorscheme_dark');
		$('#momenu .colorscheme_dark').text('Light');
	}
	if (localStorage.hide_chords == 'true'){
		$('body').addClass('hide-chords');
		$('#momenu .show_chords').text('Show Chords');
	}

});