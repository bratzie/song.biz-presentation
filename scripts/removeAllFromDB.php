<?php


$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}

/*
To use this connection way, make sure to have table as indata so that the right deletion can
be picked. In addtion to this, all of the neccessary values have to be added.
*/

$table = "$_GET[table]";

/*
To add a song the following indata is required:
songid
*/
if($table == "songs"){
	mysqli_query($link,"DELETE FROM songs");
}

/*
To add a collection the following indata is required:
collectionid
*/
if($table == "collections"){
	mysqli_query($link,"DELETE FROM collections");
}

/*
To add a song the following indata is required:
userid
*/
if($table == "users"){
	mysqli_query($link,"DELETE FROM users");
}

/*
To add a song the following indata is required:
collectionid
songid
*/
if($table == "cslink"){
	mysqli_query($link,"DELETE FROM cslink");
}
/*
To add a song the following indata is required:
userid
collectionid
*/
if($table == "uclink"){
	mysqli_query($link,"DELETE FROM uclink");
}

/* close connection */
mysqli_close($link);

?>

