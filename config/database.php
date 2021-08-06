<?php
$set = 1;
if($set==1) {
	$dbhost = 'localhost';
	// $dbuser = 'axon';
	// $dbpass = 'axondev';
	// $dbname = 'axonsg_dev';
	
	//for localhost
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'facility_ardmorepark';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to mysql');
}
else {
	$dbhost = 'localhost';
	$dbuser = 'facility_ardmore';
	$dbpass = '29zpTYRHgJV8';
	$dbname = 'facility_ardmorepark';

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to mysql');
} 
?>