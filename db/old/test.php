<?php

$userspath = "users.json";
$collectionspath = "collections.json";
$songspath = "songs.json";
$uclinkspath = "uclinks.json";
$cslinkspath = "cslinks.json";

$songs = json_decode(file_get_contents($songspath), true);
$users = json_decode(file_get_contents($userspath), true);

$users = $users["users"];

$i = 0;
while ($i < sizeof($users)) {
	echo "<h2>Welcome ";
	echo $users[$i]["username"];
	echo " your real name is ";
	echo $users[$i]["firstname"] . " " . $users[$i]["surname"] . ". Enjoy your stay!";
	echo "</h2>";
	echo "<br>";
	$i++;
}
?>