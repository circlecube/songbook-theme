jQuery(document).ready(function($) {
	
	$('#mmenu').mmenu();

	$('#options').mmenu({
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
	if (localStorage.hide_guitar == 'true'){
		$('body').addClass('hide-guitar');
		$('#momenu .guitar').text('Show Guitar');
	}

	// show chords inline
	// show guitar chord charts
	// show ukulele chord charts
	// mandolin
	// banjo

});

const VEXTAB_USE_SVG = true;
const ChordBox = vexchords.ChordBox;
const chords = [];

function createChordElement(chordStruct, instrument) {
	if ( !chordStruct.hasOwnProperty('id') || !chordStruct.hasOwnProperty('name') ) {
		return;
	}

	const id = 'chord-' + chordStruct.id + '-' + instrument;
	const chordbox = document.createElement("div");
	chordbox.setAttribute('class', 'chordbox');
	const chordcanvas = document.createElement("div");
	chordcanvas.setAttribute('id', id);
	const chordname = document.createElement("div");
	chordname.setAttribute('class', 'chordname');
	
	if ( chordStruct.archive_link ) {
		const chordarchivelink = document.createElement("a");
		if ( chordStruct.archive_text ) {
			chordarchivelink.setAttribute( 'title', chordStruct.archive_text );
		}
		chordarchivelink.setAttribute( 'href', chordStruct.archive_link );
		chordarchivelink.setAttribute( 'class', 'chordarchivelink' );
		chordarchivelink.textContent = chordStruct.name;
		chordname.appendChild(chordarchivelink);
	} else {
		chordname.textContent = chordStruct.name;
	}

	chordbox.appendChild(chordname);
	chordbox.appendChild(chordcanvas);
	
	if ( chordStruct.edit_link ) {
		const chordeditlink = document.createElement("a");
		chordeditlink.textContent = 'Edit ' + chordStruct.name;
		chordeditlink.setAttribute('href', chordStruct.edit_link);
		chordeditlink.setAttribute('class', 'chordeditlink');
		chordbox.appendChild(chordeditlink);
	}

	var instrument_chord_obj = {
		el: '#'+id,
		instrument: instrument
	};

	if ( 'ukulele' === instrument ) {
		instrument_chord_obj.struct = chordStruct.ukulele;
	} else {
		instrument_chord_obj.struct = chordStruct.guitar;	
	}

	chords.push(instrument_chord_obj);

	return chordbox;
}

function init() {
	var container = document.getElementById('chord_container_guitar');
	var container_uke = document.getElementById('chord_container_ukulele');
	// CHORD_CHARTS - loaded via php to inline script tag
	// console.log( CHORD_CHARTS );
	if ( CHORD_CHARTS ) {
		// Display preset chords (open chords)
		for (var j = 0; j < CHORD_CHARTS.length; ++j) {
			if ( CHORD_CHARTS[j].guitar ) {
				container.appendChild(createChordElement(CHORD_CHARTS[j], 'guitar' ));
			}
			if ( CHORD_CHARTS[j].ukulele ) {
				container_uke.appendChild(createChordElement(CHORD_CHARTS[j], 'ukulele' ));
			}
		}
	}
	
	// Render chords
	chords.forEach(chord => {
		new ChordBox(chord.el, {
			width: 130,
			height: 150,
			defaultColor: '#444',
			tuning: chord.struct.tuning,
			numStrings: chord.struct.numStrings,
		}).draw(chord.struct);
	});
}

init();
