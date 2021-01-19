jQuery(document).ready(function($) {
	
	$('#mmenu').mmenu();

	$('#options').mmenu({
         position: "right"
      });

	/* OPTIONS */
	// Color scheme
	$('#options .dark_mode').on('click', function(e){
		$('body').toggleClass('colorscheme_dark');
		if( $('body').hasClass('colorscheme_dark') ){
			$(this).text('✓ Dark Mode');
			localStorage.colorscheme_dark = 'true';
		}
		else{
			$(this).text('✘ Dark Mode');
			localStorage.colorscheme_dark = 'false';
		}
	});
	if (localStorage.colorscheme_dark === 'true'){
		$('body').addClass('colorscheme_dark');
		$('#options .dark_mode').text('✓ Dark Mode');
	}

	// Show chords inline
	$('#options .show_chords').on('click', function(e){
		$('body').toggleClass('hide-chords');
		if( $('body').hasClass('hide-chords') ){
			$(this).text('✘ Inline Chords');
			localStorage.hide_chords = 'true';
		}
		else{
			$(this).text('✓ Inline Chords');
			localStorage.hide_chords = 'false';
		}
	});
	if (localStorage.hide_chords === 'true'){
		$('body').addClass('hide-chords');
		$('#options .show_chords').text('✘ Inline Chords');
	}

	// Guitar Chord Charts
	$('#options .guitar').on('click', function(e){
		$('body').toggleClass('hide_guitar');
		if( $('body').hasClass('hide_guitar') ){
			$(this).text('✘ Guitar Chords');
			localStorage.hide_guitar = 'true';
		}
		else{
			$(this).text('✓ Guitar Chords');
			localStorage.hide_guitar = 'false';
		}
	});
	if (localStorage.hide_guitar === 'true'){
		$('body').addClass('hide_guitar');
		$('#options .guitar').text('✘ Guitar Chords');
	}

	// Ukulele Chord Charts
	$('#options .ukulele').on('click', function(e){
		$('body').toggleClass('hide_ukulele');
		if( $('body').hasClass('hide_ukulele') ){
			$(this).text('✘ Ukulele Chords');
			localStorage.hide_ukulele = 'true';
		}
		else{
			$(this).text('✓ Ukulele Chords');
			localStorage.hide_ukulele = 'false';
		}
	});
	if (localStorage.hide_ukulele === 'true'){
		$('body').addClass('hide_ukulele');
		$('#options .ukulele').text('✘ Ukulele Chords');
	}

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
