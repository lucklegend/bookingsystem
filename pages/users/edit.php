<?php
session_start();
include_once('../../config/config.php');
isset($_SESSION['basic_is_logged_in']) ? $s_id = $_SESSION['basic_is_logged_in'] : $s_id = '';

$getUserData = getUser($conn, $_GET['crypted'], $s_id, $routes);
$id = $getUserData['id'];
$user_type = $getUserData['user_type'];
$name = $getUserData['name'];
$username = $getUserData['username'];
$pageURL = str_replace(".php","",$_SERVER['PHP_SELF']);

checkIfLogIn($id, $routes);
checkIfAdmin($id, $user_type, $routes);

// POST Create
if(isset($_GET['id'])){
  $query = "SELECT * FROM user_account  WHERE id = '".$_GET['id']."' limit 1";
  $result = mysqli_query($conn, $query);
  while($row=mysqli_fetch_array($result)) {
    $formUname = $row['username'];
    $userType = $row['user_type'];
    $formName  = $row['name'];
  }
}

if($_POST['editUser']){        
  $formUname = $_POST['username'];
  $formName = $_POST['name'];
  $userType = $_POST['user_type'];
  $err = '';
  $msg = '';

  if(empty($formUname) || $formUname ==''){
    $err = 'No Username found.';
    $msg = 'error';
  }else{
    $query = "SELECT username FROM user_account WHERE username = '".$_POST['formUname']."' limit 1";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    if($count =='1') {
      $err = 'Username already taken.';
      $msg = 'error';
    }
  }
  if($_POST['password'] != $_POST['confpassword'] ){
    $err = 'Password did not match.';
    $msg = 'error';
  }
  if(strlen($_POST['password'] ) < 8 || strlen($_POST['password'] ) == 0){
    $err = "Password must be at least 8 characters";
    $msg = 'error';
  }
  if($err == '' || empty($err)){
    if(ctype_alnum($_POST['password'])){ 
      mysqli_query($conn, "INSERT INTO user_account (username,password,user_type,name,email,contact_no) value ('".$_POST['username']."','".$_POST['password']."','".$_POST['user_type']."','".$_POST['name']."','".$_POST['email']."','".$_POST['contact']."')") or mysqli_error($conn);
      $err = $_POST['username'].' account has been created. Click <a href="'.$routes['users'].'">here to see the list</a>';
      $msg = 'success';
    } else {
      $err = 'Password must be Alpha Numeric';
      $msg = 'error';
    }
  } 
}


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
    if($user_type == 1){
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
                    <h3 >Create User</h3>
                    <div>
                        <!-- <i class="material-icons refresh-icon">refresh</i>
                        <i class="material-icons options-icon ml-2">more_vert</i> -->
                    </div>
                  </div>
                  <div class="mdc-card p-0">
                    <script language="javascript">
                    //INSERT CUSTOM JAVASCRIPT FILE HERE.          
                      
                    </script>
                    <?php
                      if(isset($msg) && $msg == 'success'){
                    ?>
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> <?php echo $err; ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <?php
                      }else if(isset($msg) AND $msg == 'error'){
                    ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> <?php echo $err;?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <?php  
                      }else{}
                    
                    ?>
                    <div class="container-fluid">
                      <form action="<?php echo $pageURL.'?crypted='.$_GET['crypted'];?>" method="post">
                        <div class="spacer"></div>
                        <div class="row">
                          <div class="col-sm-2">
                            <label>
                              User Type:
                            </label>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                            <select class="form-control" id="userType" name="user_type">
                              <?php 
                              if(isset($userType)){
                                if($userType == 0){
                                  $value = 0;
                                  $desc = 'Residents';
                                }else if($userType == 1){
                                  $value = 1;
                                  $desc = 'Managers';
                                }else if($userType==2){
                                  $value = 2;
                                  $desc = 'Club';
                                }else{
                                  $value = '';
                                  $desc = 'Select User Type';
                                }
                              }else{
                                $value = '';
                                $desc = 'Select User Type';
                              }
                              
                              echo '<option value ="'.$value.'">'.$desc.'</option>';
                              ?>
                              <option value="0">Residents</option>
                              <option value="1">Managers</option>
                              <option value="2">Club</option>
                            </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-2">
                            <label for="username">Username:</label>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?php echo $formUname; ?>" require>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-2">
                            <label for="name">Name:</label>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <input type="text" name="name" class="form-control" id="name" value="<?php echo $formName; ?>" placeholder="Name">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-2">
                            <label for="name">Password:</label>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <input type="password" name="password" class="form-control" id="name" placeholder="Password">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-2">
                            <label for="name">Confirmed Password:</label>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <input type="password" name="confpassword" class="form-control" id="name" placeholder="Password">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6">
                            <input type="hidden" name="crypted" value="<?php echo $_GET['crypted']; ?>">
                            <input class="btn btn-success" type="submit" name="editUser" value="Update">
                            <a class="btn btn-danger" href="<?php echo $routes['users'];?>">Cancel</a>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="spacer"></div>
                  </div>
                  <div class="d-block d-sm-flex justify-content-between align-items-center">
                      <!-- Start Here -->
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
