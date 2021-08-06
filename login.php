<?php
//INSERT PHP CODES HERE.. 
session_start();
include('config/config.php');

if(isset($_POST["loginSubmit"])){
	
	$query  = "SELECT * FROM user_account  WHERE 
					username = '" . mysqli_real_escape_string($conn, $_POST['username']) . "' AND 
					password = '" . mysqli_real_escape_string($conn, $_POST['password']) . "' AND active = '1'";
					
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ;
	$count = mysqli_num_rows($result);
 
	if($count > 0 ){
 		  $row = mysqli_fetch_array($result);
			$id = $row['id'];
			$crypted = $row['crypted'];
		 	$_SESSION['basic_is_logged_in'] = "$id";
      $_SESSION['last_activity'] = time();
			include_once('config/random_char.php');
      $date_set = date("D, jS F Y @ H:i:s");
			$query = "UPDATE user_account set crypted = '".$pwd."', last_logged_in = '".$date_set."' where id = '".$id."' limit 1";
			$result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ; 
			echo "<script type=text/javascript language=javascript> window.location.href = '".$routes['home']."?crypted=".$pwd."'; </script> ";
	}
	else {
			echo "<script type=text/javascript language=javascript> window.location.href = '".$routes['login']."?ops=1'; </script> ";
			exit;
	}
}
$headerTitle = 'User Login';
//ADD HEADER HERE
include_once('layout/header.php'); 
?>
<script src="assets/js/preloader.js"></script>
  <div class="body-wrapper">
    <div class="main-wrapper">
      <div class="page-wrapper full-page-wrapper d-flex align-items-center justify-content-center" id="loginPage">
        <main class="auth-page">
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-6-tablet">
                <div class="mdc-card">
                  <form action="<?php echo $_SERVER['REQUEST_URI']; ?>"method="post" id="loginForm">
                    <div class="mdc-layout-grid">
                      <div class="mdc-layout-grid__inner">
                        <?php
                          if(isset($_GET['ops']) && $_GET['ops'] == 1){
                            echo '
                              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                <div class="alert alert-danger full-width" role="alert">
                                  Username or password did not match.
                                </div>
                              </div>
                            ';
                          }
                        ?>
                        
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                          <div class="mdc-text-field w-100">
                            <input class="mdc-text-field__input" name="username" id="text-field-hero-input" required>
                            <div class="mdc-line-ripple"></div>
                            <label for="text-field-hero-input" class="mdc-floating-label">Username</label>
                          </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                          <div class="mdc-text-field w-100">
                            <input class="mdc-text-field__input" name="password" type="password" id="text-field-hero-input" required>
                            <div class="mdc-line-ripple"></div>
                            <label for="text-field-hero-input" class="mdc-floating-label">Password</label>
                          </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                          <div class="mdc-form-field">
                            <div class="mdc-checkbox mdc-checkbox--secondary">
                              <input type="checkbox"
                                      class="mdc-checkbox__native-control"
                                      id="checkbox-1"/>
                              <div class="mdc-checkbox__background">
                                <svg class="mdc-checkbox__checkmark"
                                      viewBox="0 0 24 24">
                                  <path class="mdc-checkbox__checkmark-path"
                                        fill="none"
                                        d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                </svg>
                                <div class="mdc-checkbox__mixedmark"></div>
                              </div>
                            </div>
                            <label for="checkbox-1">Remember me</label>
                          </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex align-items-center justify-content-end">
                          <a href="#">Forgot Password</a>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                          <button type="submit" name="loginSubmit" class="mdc-button mdc-button--raised w-100 submitBtn-redish">
                            Login
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
  <?php include_once('layout/base_footer_and_script.php'); ?>