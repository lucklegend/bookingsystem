<?php
session_start();
include_once('config/config.php');
include_once('inc/lapsed.php');
isset($_SESSION['basic_is_logged_in']) ? $s_id = $_SESSION['basic_is_logged_in'] : $s_id = '';

$getUserData = getUser($conn, $_GET['crypted'], $s_id, $routes);
$id = $getUserData['id'];
$user_type = $getUserData['user_type'];
$name = $getUserData['name'];
$username = $getUserData['username'];
$usertype = $getUserData['user_type'];

checkIfLogIn($id, $routes);

//For Declaration of page in header section
if($usertype == 0 ){
  $headerTitle = 'Resident Section';
}else if($usertype == 1){
  $headerTitle = 'Admin Section';
}else{
  $headerTitle = 'Club Section';
}

//ADD HEADER HERE
include_once('layout/header.php'); 
?>
<script src="assets/js/preloader.js"></script>
  <div class="body-wrapper">
    <!-- sidebar -->
    <?php
    $homeActive = 'active'; 
    if($usertype == 1){
      include_once('layout/sidebar-admin.php');
    }else{
      include_once('layout/sidebar.php');
    }
    ?>
    <!-- end of sidebar -->
    <?php
    if($user_type == 1){
      include_once('index-admin.php');
    }else{
      include_once('index-resident.php');
    }
    ?>
  </div>
<?php include_once('layout/base_footer_and_script.php'); ?>