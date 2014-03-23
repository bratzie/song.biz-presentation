<?php

$link = new mysqli("mysql-vt2013.csc.kth.se:3306/matfol","matfoladmin","FU0B1klD", "matfol");
if (!$link) {
	echo '';
 die('Could not connect: ' . mysql_error());
}else {
	echo 'connected';
}
?>