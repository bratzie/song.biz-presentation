<?php


$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
 die('Could not connect: ' . mysql_error());
}

    $query="SELECT * FROM $_GET[table]";

    // get data from db
    $result=$link->query($query) or trigger_error($mysqli->error." [$query]");

$rows = array();
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
	$rows[] = $row;
}


// Encode all string children in the array to html entities.
array_walk_recursive($rows, function(&$item, $key) {
    if(is_string($item)) {
        $item = htmlentities($item);
    }
});
$json = json_encode($rows);

// Decode the html entities and end up with unicode again.
$json = html_entity_decode($json);

echo $json;


/* free result set */
$result->free();
/* close connection */
mysqli_close($link);

?>

