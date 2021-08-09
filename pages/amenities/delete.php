<?php
session_start();
include_once('../../config/config.php');
isset($_SESSION['basic_is_logged_in']) ? $s_id = $_SESSION['basic_is_logged_in'] : $s_id = '';

$getUserData = getUser($conn, $_GET['crypted'], $s_id, $routes);
$id = $getUserData['id'];
$user_type = $getUserData['user_type'];
$name = $getUserData['name'];
$username = $getUserData['username'];
$usertype = $getUserData['user_type'];

checkIfLogIn($id, $routes);
checkIfAdmin($id, $usertype, $routes);

if(isset($_GET['code'])){
  $code = $_GET['code'];
}else{
  $code = '';
}
$morecode = explode(",", $code);

$catsql = "SELECT category FROM armenities WHERE id = '".$morecode[0]."'";
$catresult = mysqli_query($conn, $catsql);
$catrow = mysqli_fetch_array($catresult);
$categorytogo = $catrow['category'];
	
	if (substr_count($code, ",") == 1) {
    $query = "DELETE FROM armenities WHERE id = '".$morecode[0]."'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ; 
	}
	else {
		$i = 0;
		$j = substr_count($code, ",");
		
		while ($i < $j) {
      $query = "DELETE FROM armenities WHERE id = '".$morecode[$i]."'";
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ; 
		  $i++;
		}
	}

	// find out if thecategory is empty, if empty, delete it also
	$armsql = "SELECT * FROM armenities WHERE category = '$categorytogo'";
	$armresult = mysqli_query($conn, $armsql);
	$armnum = mysqli_num_rows($armresult);
	if ($armnum == 0){
		$query = "DELETE FROM categories WHERE title = '".$categorytogo."'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ; 
	}	
	echo "<script type=text/javascript language=javascript> window.location.href = '".$routes['amenities']. "&msg=1'; </script> ";
?>