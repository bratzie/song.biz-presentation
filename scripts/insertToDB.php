<?php


$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}

/*
To use this connection way, make sure to have table as indata so that the right insertion can
be picked. In addtion to this, all of the neccessary values have to be added.
*/

$table = "$_GET[table]";

/*
To add a song the following indata is required:
title
lyrics
melody
composer
type
*/
if($table == "songs"){
	mysqli_query($link,"INSERT INTO songs (title, lyrics, melody, composer, type) VALUES ('$_GET[title]','$_GET[lyrics]','$_GET[melody]','$_GET[composer]','$_GET[type]');");
		// echo true;
}

/*
To add a collection the following indata is required:
title
subtitle
creator
public
*/
if($table == "collections"){
	if("$_GET[isPublic]" == true){
		$public = 1;
	} else {
		$public = 0;
	}
	mysqli_query($link,"INSERT INTO collections (title, subtitle, creator, public) VALUES ('$_GET[title]','$_GET[subtitle]','$_GET[creator]',$public);");
}

/*
To add a song the following indata is required:
username
firstname
surname
password
*/
if($table == "users"){
	mysqli_query($link,"INSERT INTO users (username, firstname, surname, password) VALUES ('$_GET[username]','$_GET[firstname]','$_GET[surname]','$_GET[password]')");
}

/*
To add a song the following indata is required:
collectionid
songid
*/
if($table == "cslink"){
	mysqli_query($link,"INSERT INTO cslink VALUES ('$_GET[collectionid]','$_GET[songid]');");
}
/*
To add a song the following indata is required:
userid
collectionid
*/
if($table == "uclink"){
	mysqli_query($link,"INSERT INTO uclink VALUES ('$_GET[userid]','$_GET[collectionid]');");
}

/* close connection */
mysqli_close($link);

?>

