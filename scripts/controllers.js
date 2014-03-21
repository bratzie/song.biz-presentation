$(document).ready(function () {
	$('#searchBtn').click(function () {
		swapMiddleView('search');
	});

	$('#browseBtn').click(function () {
		swapMiddleView('browse');
	});

	$('#searchBtn').click();

	$('#searchField').keyup(function () {
		searchfilter = $('#searchField').val().toLowerCase();
		getSearchResults();
	});

	$('#passfield').keydown(function (e) {
		var code = (e.keyCode ? e.keyCode : e.which);
		console.log(code);
		if(code === 13) {
			if(current_user == "") {
				window.location.href = "?user="+$('#userfield').val()+"&password="+$('#passfield').val();
			}
		} else {
			// do nothing if it wasn't enter
		}
	});

	$('#searchtype').change(function () {
		getSearchResults();
	});

	$('#addBtn').click(function () {

		var title = $('#collectionName').val();
		var subtitle = $('#collectionDescription').val();
		var collectionId = model.getHighestCollectionId() + 1;

		if (title !== "" || subtitle !== "") {
			model.addCollection(collectionId, title, subtitle, userid, true);
			model.addCollectionToUser(userid, collectionId);
			update();

			// reset input
			$('#collectionName').val("");
			$('#collectionDescription').val("");
		}

	});

	$('#addSongBtn').click(function() {
		$('#overlay').show();

	});

	$('#submitSongBtn').click(function() {
		var title = $('#songTitle').val();
		var lyrics = $('#songLyrics').val();
		var melody = $('#songMelody').val();
		var composer = $('#songComposer').val();
		var type = $('#songType').val();
		var songId = model.getHighestSongId() + 1;

		if(title !== "" || lyrics !== "" || melody !== "" || composer !== "" || type !== "") {
			model.addSong(songId, title, lyrics, melody, composer, type);
			update();

			$('#songTitle').val("");
			$('#songLyrics').val("");
			$('#songMelody').val("");
			$('#songComposer').val("");
			$('#songType').val("");
			$('#overlay').hide();
		}

	});

	$('#returnBtn').click(function() {
		$('#songTitle').val("");
		$('#songLyrics').val("");
		$('#songMelody').val("");
		$('#songComposer').val("");
		$('#songType').val("");
		$('#overlay').hide();

	});

	$('#user_thing').click(function () {
		if(current_user == "") {
			window.location.href = "?user="+$('#userfield').val()+"&password="+$('#passfield').val();
		}
		else {
			window.location.href = "?logout=1";
		}
	});
});

function swapMiddleView(type) {
	if(type === 'search') {
		$('.search').show();
		$('.browse').hide();

		$('#searchBtn').removeClass('inactive');
		$('#browseBtn').addClass('inactive');

		$('#a2').css('background', '#FFB3AE');
		$('#b2').css('background', '#FFB3AE');
		$('#c2').css('background', '#FFB3AE');
	}
	else if(type === 'browse') {
		$('.browse').show();
		$('.search').hide();

		$('#searchBtn').addClass('inactive');
		$('#browseBtn').removeClass('inactive');

		$('#a2').css('background', '#68B287');
		$('#b2').css('background', '#68B287');
		$('#c2').css('background', '#68B287');
	}
}