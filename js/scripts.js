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

const VEXTAB_USE_SVG = true;
const ChordBox = vexchords.ChordBox;
const chords = [];

function createChordElement(chordStruct) {
	if ( !chordStruct.hasOwnProperty('id') || !chordStruct.hasOwnProperty('name') ) {
		return;
	}

	const id = 'chord-'+chordStruct.id;
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

	chords.push({
		el: '#'+id,
		struct: chordStruct
	});

	return chordbox;
}

function init() {
	var container = document.getElementById('chord_containter');
	// console.log(chordCharts);
	if ( chordCharts ) {
		// Display preset chords (open chords)
		for (var j = 0; j < chordCharts.length; ++j) {
			if ( chordCharts[j].chord ) {
				container.appendChild(createChordElement(chordCharts[j]));
			}
		}
	}

	// Render chords
	chords.forEach(chord => {
		//console.log(chord.struct);
		new ChordBox(chord.el, {
			width: 130,
			height: 150,
			defaultColor: '#444'
		}).draw(chord.struct);
	});
}

init();
