<?php
echo "<br>";
echo phpversion();

$dbhandle = sqlite_open('songbiz.db', 0666, $error);
if (!$dbhandle) die ($error);

// create the users table
$userstm = "CREATE TABLE Users(
	userid integer AUTO_INCREMENT UNIQUE NOT NULL PRIMARY KEY,
    firstname text, 
    surname text,
    registered timestamp,
    password text
)";

$ok = sqlite_exec($dbhandle, $userstm, $error);

if (!$ok)
   die("Cannot execute query. $error");

echo "Database Users created successfully";

// create the collections table
$collectionstm = "CREATE TABLE Collections(
	collectionid integer AUTO_INCREMENT NOT NULL PRIMARY KEY,
    songid integer NOT NULL PRIMARY KEY, 
    title text,
    subtitle text,
    private boolean
)";

$ok = sqlite_exec($dbhandle, $collectionstm, $error);

if (!$ok)
   die("Cannot execute query. $error");

echo "Database Collections created successfully";

// create the songs table
$songstm = "CREATE TABLE Songs(
	songid integer AUTO_INCREMENT UNIQUE NOT NULL PRIMARY KEY,
    title text, 
    lyrics text,
    melody text,
    composer text,
    type text
)";

$ok = sqlite_exec($dbhandle, $songstm, $error);

if (!$ok)
   die("Cannot execute query. $error");

echo "Database Songs created successfully";

// create the link table
$linkstm = "CREATE TABLE Link(
	userid integer NOT NULL PRIMARY KEY,
    collectionid integer NOT NULL PRIMARY KEY
)";

$ok = sqlite_exec($dbhandle, $linkstm, $error);

if (!$ok)
   die("Cannot execute query. $error");

echo "Database Link created successfully";

sqlite_close($dbhandle);
?>