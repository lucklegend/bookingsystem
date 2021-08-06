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


// Declare the header title.
$headerTitle = 'Users Section';

//ADD HEADER HERE
include_once('../../layout/header.php'); 
?>
<script src="<?php echo $routes['URL'];?>assets/js/preloader.js"></script>
  <div class="body-wrapper">
    <!-- sidebar -->
    <?php
    $parentSub = 'system'; 
    if($amenitiesActive){
      echo '<script>console.log("wow amenities open");</script>';
    }
    if($usertype == 1){
      include_once('../../layout/sidebar-admin.php');
    }else{
      include_once('../../layout/sidebar.php');
    }
    ?>
  
    <!-- end of sidebar -->
    <div class="main-wrapper mdc-drawer-app-content">
      <!-- navbar -->
      <?php include_once('../../layout/navbar.php'); ?>
      <!-- end of navbar -->
      <!-- CONTENT HERE -->
      <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <div class="d-flex justify-content-between">
                    <h3>Calendar</h3>
                    <div>
                        <!-- <i class="material-icons refresh-icon">refresh</i>
                        <i class="material-icons options-icon ml-2">more_vert</i> -->
                    </div>
                  </div>
                  <div class="mdc-card p-0">
                  
                  </div>
                </div> 
              </div>
            </div>
          </div>
        </main>
        <!-- layout/footer -->
        <?php include_once('../../layout/footer.php');?>
        <!-- end of layout/footer -->
      </div>
    </div>
  </div>
<?php include_once('../../layout/base_footer_and_script.php'); ?>

