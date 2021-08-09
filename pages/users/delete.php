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

if(isset($_GET['dele'])){
  echo $_GET['dele'] ." = ". $_GET['crypted'];
  echo $routes['users']."msg=delete";
  $result = mysqli_query($conn, "UPDATE user_account SET active ='0' WHERE id ='".$_GET['dele']."' limit 1") or die(mysqli_error(($conn)));
  // echo $_GET['dele']
  echo "<script type=text/javascript language=javascript> window.location.href ='".$routes['users']."&msg=delete'; </script> ";			
}
?>