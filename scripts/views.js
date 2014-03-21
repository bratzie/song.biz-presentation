var userid;

$(document).ready(function () {

	searchfilter="";
	activecollection = 1;

	setTimeout(trylogin, 200);
	setTimeout(getSearchResults, 200);
	setTimeout(fillBrowse, 200);
	setTimeout(populateUserCollections, 400);
	setTimeout(updateActiveCollection, 500);

	$('#collectionsongs').droppable({ accept: ".card.song", drop: function (event, ui) {
		model.getCollectionById(activecollection).addSong(parseInt(ui.draggable.attr('data-songid')));
		$('#collectionsongs').fadeOut(100, function () { update(); $('#collectionsongs').fadeIn(100); });
	} });

	$('#trash').droppable({ accept: ".collsongcard", drop: function (event, ui) {
		model.getCollectionById(activecollection).removeSong(parseInt(ui.draggable.attr('data-songid')));
		$('#collectionsongs').fadeOut(100, function () { update(); $('#collectionsongs').fadeIn(100); $('#trash').css("opacity", "0.2");});
	} });

	// Make collections dropable
	$('#usercollections').droppable({ accept: ".card.collection", drop: function (event, ui) {
		model.addCollectionToUser(userid,parseInt(ui.draggable.attr('data-collectionid')))
		$('#usercollections').fadeOut(100, function () { update(); $('#usercollections').fadeIn(100);});
	} });
});

function update() {
	trylogin();
	getSearchResults();
	populateUserCollections();
	updateActiveCollection();
}

function trylogin() {
	var users = model.users;
	var roof = users.length;

	var flag = false;

	for(var i=0; i<roof; i++) {
		if(users[i].getUsername() === current_user) {
			$('#user').html(users[i].getFirstname()+" "+users[i].getSurname());
			userid = users[i].getId();
			flag = true;
			break;
		}
	}

	if(!flag) {
		$('#user').html('<input id="userfield" name="user" type="text" placeholder="Username"><input id="passfield" name="password" type="password" placeholder="Password">');
		$('#user_thing').html("LOGIN");
	}
}

function populateUserCollections() {
	$('#usercollections').html('');

	if(userid) {
		var collections = model.getUserById(userid).getCollections();
		var roof = collections.length;	
	
	
		for(var i=0; i<roof; i++) {
			var coll = model.getCollectionById(collections[i]);

			var mystring = '<div data-collectionid="'+coll.getId()+'" class="usercollection';
			mystring += (activecollection === coll.getId() ? ' selected' : '');
			mystring += '"><button class="deletecollection">x</button><h1 class="lightred">'+coll.getTitle().toUpperCase()+'</h1><h2 class="darkred">'+coll.getSubtitle()+'</h2></div>';

			$('#usercollections').append(mystring);
		}

		$('.usercollection').click(function () {
			$('.usercollection').removeClass('selected');
			$(this).addClass('selected');
			activecollection = parseInt($(this).attr('data-collectionid'));
			update();
		});

		$('.deletecollection').click(function () {
			model.removeCollectionFromUser(userid, parseInt($(this).parent().attr('data-collectionid')));
			update();
		});
	}
}

function updateActiveCollection() {
	$('#collectionsongs').html('');

	var coll = model.getCollectionById(activecollection);
	$('#current_collection').html(coll.getTitle());
	var songs = coll.getSongs();

	songs.forEach(function (songid) {
		var song = model.getSongById(songid);
		var mystring = '<div data-songid="'+song.getId()+'" class="small card collsongcard"><h1>'+song.getTitle()+'</h1></div>';
		$('#collectionsongs').append(mystring);
	});

	$('.collsongcard').draggable({ helper: "clone", revert: "invalid", containment: "document" });
}

function getSearchResults() {
	$('#searchresults').html('');

	var searchtype = $('input[name=type]:checked', '#searchtype').val();

	if(searchtype==='songs'){
		var roof = model.songs.length;
		for(var i=0; i<roof; i++) {
			if(model.songs[i].getComposer().toLowerCase().indexOf(searchfilter) != -1 || model.songs[i].getLyrics().toLowerCase().indexOf(searchfilter) != -1 || model.songs[i].getMelody().toLowerCase().indexOf(searchfilter) != -1 || model.songs[i].getTitle().toLowerCase().indexOf(searchfilter) != -1 || model.songs[i].getType().toLowerCase().indexOf(searchfilter) != -1) {
				$('#searchresults').append('<div data-songid="'+model.songs[i].getId()+'" class="card song"><h1>'+model.songs[i].getTitle()+'</h1><div class="more"><h2>Kompositör: '+model.songs[i].getComposer()+'<br> Melodi: '+model.songs[i].getMelody()+'</h2><p>'+model.songs[i].getLyrics()+'</p></div></div>');
			}
		}
	}
	else if(searchtype==='users'){
		var roof = model.users.length;
		for(var i=0; i<roof; i++) {
			if(model.users[i].getFirstname().toLowerCase().indexOf(searchfilter) != -1 || model.users[i].getSurname().toLowerCase().indexOf(searchfilter) != -1 || model.users[i].getUsername().toLowerCase().indexOf(searchfilter) != -1) {
				$('#searchresults').append('<div class="card user ui-widget-content"><h1>'+model.users[i].getFirstname()+' '+model.users[i].getSurname()+' <span>('+model.users[i].getUsername()+')</span></h1></div>');
			}
		}
	}
	else if(searchtype==='collections'){
		var roof = model.collections.length;
		for(var i=0; i<roof; i++) {
			if(model.collections[i].getTitle().toLowerCase().indexOf(searchfilter) != -1) {
				$('#searchresults').append('<div data-collectionid="'+model.collections[i].getId()+'" class="card collection ui-widget-content"><h1>'+model.collections[i].getTitle()+'</h1></div>');
			}
		}
	}
	$('.card.song').draggable({ revert: "invalid", helper: "clone", start: function(e, ui) { $(ui.helper).addClass("ui-draggable-helper"); } });
	$('.card.song').draggable("option", "cursorAt", { left: 5 });

	$('.card.collection').draggable({ revert: "invalid", helper: "clone", start: function(e, ui) { $(ui.helper).addClass("ui-draggable-helper"); } });
	$('.card.collection').draggable("option", "cursorAt", { left: 5 });

	$('.card').click(function () {
		$('.more', this).slideToggle(100);
	});
}

//Function for putting stuff in the browse view

function fillBrowse() {
	$('#browseStudent').html('');
	var students = $('#browseStudent');
	var count = 0;
	var roof = model.songs.length;
	for(var i=0; i<roof; i++) {
		if(count < 3) {
			if(model.songs[i].getType().toLowerCase()==='student') {
				students.append('<div data-songid="'+model.songs[i].getId()+'" class="card song"><h1>'+model.songs[i].getTitle()+'</h1><div class="more"><h2>Kompositör: '+model.songs[i].getComposer()+'<br> Melodi: '+model.songs[i].getMelody()+'</h2><p>'+model.songs[i].getLyrics()+'</p></div></div>');
				count++;
			}
		}
	}

	$('#browseParty').html('');
	var partys = $('#browseParty');
	count = 0;
	for(var i=0; i<roof; i++) {
		if(count < 3) {
			if(model.songs[i].getType().toLowerCase()==='party') {
				partys.append('<div data-songid="'+model.songs[i].getId()+'" class="card song"><h1>'+model.songs[i].getTitle()+'</h1><div class="more"><h2>Kompositör: '+model.songs[i].getComposer()+'<br> Melodi: '+model.songs[i].getMelody()+'</h2><p>'+model.songs[i].getLyrics()+'</p></div></div>');
				count++;
			}
		}
	}

	$('#browseNa').html('');
	var nas = $('#browseNa');
	count = 0;
	for(var i=0; i<roof; i++) {
		if(count < 3) {
			if(model.songs[i].getType().toLowerCase()==='national anthem') {
				nas.append('<div data-songid="'+model.songs[i].getId()+'" class="card song"><h1>'+model.songs[i].getTitle()+'</h1><div class="more"><h2>Kompositör: '+model.songs[i].getComposer()+'<br> Melodi: '+model.songs[i].getMelody()+'</h2><p>'+model.songs[i].getLyrics()+'</p></div></div>');
				count++;
			}
		}
	}

	$('.card.song').draggable({ revert: "invalid", helper: "clone", start: function(e, ui) { $(ui.helper).addClass("ui-draggable-helper"); } });
	$('.card.song').draggable("option", "cursorAt", { left: 5 });

	$('.browse .card').click(function () {
		$('.more', this).slideToggle(100);
	});
}