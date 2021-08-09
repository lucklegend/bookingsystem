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
// GET THE DATA FORM $code to update
$newsql = "SELECT * FROM armenities WHERE id = $code";
$newresult = mysqli_query($conn, $newsql);

if(isset($newresult)){
	$newrow = mysqli_fetch_array($newresult);
	$category = $newrow['category'];
	$display_name = $newrow['display_name'];
	$telephone = $newrow['telephone'];
	$address = $newrow['address'];
	$url = $newrow['url'];
	$fax = $newrow['fax'];
	$emergency = $newrow['emergency'];
	$moreid = $newrow['id'] . ",";
}
// END OF GETTING $code DATA

// IF update button is clicked
if(isset($_POST['update'])){
	$category = $_POST['cat'];
	$morecategory = explode(",", $category);
	$telephone = $_POST['telephone'];
	$emergency = $_POST['emergency'];
	$fax = $_POST['fax'];
	$display_name = $_POST['display_name'];
	$address = $_POST['address'];
	$url = $_POST['url'];
	$moreid = $_POST['moreid'];
	$explodedids = explode(",", $moreid);
	
	if (substr_count($moreid, ",") == 1){
		$query = "UPDATE armenities SET telephone = '".$telephone."', emergency = '".$emergency."', fax = '".$fax."', display_name = '".$display_name."', address = '".$address."', url = '".$url."' WHERE id = '".$explodedids[0]."'";
		$result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ; 
	}
	else {
		$i = 0;
		$j = substr_count($moreid, ",");
		
		while ($i < $j) {
			$query = "UPDATE armenities SET telephone = '".$telephone."', emergency = '".$emergency."', fax = '".$fax."', display_name = '".$display_name."', address = '".$address."', url = '".$url."' WHERE id = '".$explodedids[$i]."'";
			$result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ; 
			$i++;
		}
	}

	if (substr_count($category, ",") > 1) {
		$i = 0;
		$j = substr_count($category, ",");
		
		while ($i < $j) {
			// check if the title has that category
			$categorysql = "SELECT * FROM armenities WHERE category = '".$morecategory[$i]."' AND display_name = '".$display_name."'";
			$categoryresult = mysqli_query($conn, $categorysql);
			$catenum = mysqli_num_rows($categoryresult);
			
			if ($catenum == 0) {
				$query = "INSERT INTO armenities(category, telephone, emergency, fax, display_name, address, url) VALUES ('".$morecategory[$i]."', '".$telephone."', '".$emergency."', '".$fax."', '".$display_name."', '".$address."', '".$url."')";
				$result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ; 
			}
			$i++;
		}
	}
	
	// check if there are new category entered
	$category = $_POST['cat'];
	$morecategory = explode(",", $category);
	$i = 0;
	$j = substr_count($category, ",");
	
	while ($i < $j) {
		$categorysql = "SELECT * FROM categories WHERE title = '$morecategory[$i]'";
		$categoryresult = mysqli_query($conn, $categorysql);
		$catenum = mysqli_num_rows($categoryresult);
		if ($catenum == 0) {
			$query = "INSERT INTO categories (title) VALUES ('$morecategory[$i]')";
			$result = mysqli_query($conn, $query) or die(mysqli_error($conn)) ; 
		}
		$i++;
	}
	
	echo "<script type=text/javascript language=javascript> window.location.href = '".$routes['amenitiesEdit']."&code=".$code."&msg=1'; </script> ";
}
// END Of Update Button Clicked

// Declare the header title.
$headerTitle = 'Amenities Section';

//ADD HEADER HERE
include_once('../../layout/header.php'); 
?>
<script src="<?php echo $routes['URL'];?>assets/js/preloader.js"></script>
  <div class="body-wrapper">
    <!-- sidebar -->
    <?php
    //for showing the buttons on sidebar
    $parentSub = 'manage content'; 

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
                    <h3>Amenities</h3>
                    <div>
                        <i class="material-icons refresh-icon">refresh</i>
                        <i class="material-icons options-icon ml-2">more_vert</i>
                    </div>
                  </div>
                  <div class="mdc-card p-0">
                    <script language="javascript">
                      //<!-- hide from old browsers
                      function enable() {
                        // enable update button if applicable
                      }

                      function addCat(x) {
                        y = document.form1.category.options.length;
                        z = "";
                        if (x.options){
                          z = x.options[x.selectedIndex].value;
                        }else {
                          z = document.form1.newcategory.value;
                          if (z == "") {
                            alert("Please provide a category name.");
                            document.form1.newcategory.focus();
                            return;
                          }
                        }
                        for(i=0; i < y; i++) {
                          if (document.form1.category.options[i].value == z)
                            return;
                        }
                        document.form1.category.options[y] = new Option(z,z);

                        if (!x.options) {
                          document.form1.newcategory.value = "";
                          document.form1.newcategory.focus();
                        }
                        enable();
                      }

                      function delSelected(x) {
                        x.options[x.selectedIndex] = null;
                        enable();
                      }

                      function validate() {
                        if (document.form1.category) {
                          if (document.form1.category.options.length == 0) {
                            alert("Please indicate a cateogry.");
                            document.form1.newcategory.focus();
                            return false;
                          }
                          // consolidate categories
                          var temp = "";
                          for(i = 0; i < document.form1.category.options.length; i++) {
                            temp += document.form1.category.options[i].value + ",";
                          }
                          document.form1.cat.value = temp;
                        }

                        if (document.form1.display_name.value.length == 0) {
                          alert("Please provide a name.");
                          document.form1.display_name.focus();
                          return false;
                        }
                        return true;
                      }

                      function count(x,maxLength) {
                        var count = x.value.length;
                        if (count > maxLength) {
                          x.value = x.value.substring(0,maxLength);
                          count = maxLength;
                        }
                        enable();
                      }
                      // done hiding-->
                    </script>
                    <?php
                      if(isset($_GET['msg'])){
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Datas for <strong><?php echo $newrow['display_name']; ?></strong> is now updated.
                      Click <a href="<?php echo $routes['amenities'];?>">here to return to the list.</a>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php
                      }
                    ?>
                    <form name="form1" onSubmit="return validate()" method="post" action="<?php echo $routes['amenitiesEdit'].'&code='.$code;?>">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-sm-6">

                            <input type="hidden" name="code">
                            <input type="hidden" value="amenity" name="ty">
                            <input type="hidden" name="cat">

                            <div class="form-group">
                              <h5>Category</h5>
                              <small class="text-muted">Click selection below to remove<br></small>
                              <?php 
                                // FIND OUT IF THERE ARE ANY OTHER CATEGORIES THIS TITLE BELONG TO
                                $anothersql = "SELECT id, category FROM armenities WHERE display_name = '".$newrow['display_name']."' AND category != '".$newrow['category']."'";
                                $anotherresult = mysqli_query($conn, $anothersql);
                                $anotheramt = mysqli_num_rows($anotherresult);
                                ?>
                                  <select class="form-control" onclick="delSelected(this)" id="category" size="7" name="category">
                                    <option value="<?php echo $newrow['category']; ?>"><?php echo $newrow['category']; ?></option>
                                <?php
                                  if ($anotheramt == 0) {
                                  }
                                  else {
                                    while ($anotherrow = mysqli_fetch_array($anotherresult)) {
                                      $moreid .= $anotherrow['id'] . ",";
                                ?>
                                    <option value="<?php echo $anotherrow['category']; ?>"><?php echo $anotherrow['category']; ?></option>
                                <?php						
                                    }
                                  }
                                ?>
                                  </select>
                            </div>
                            <div class="form-group">
                              <h5 style="margin-top:10px;">Telephone</h5>
                              <input type="text" class="form-control" id="telephone" onKeyDown="enable()" name="telephone" value="<?php echo $newrow['telephone']; ?>">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <h5>&nbsp;</h5>
                              <small class="text-muted">Type a category to add<br></small>
                              <div class="input-group mb-3">
                                <input class="form-control" type="text" id="newcategory" name="newcategory" aria-describedby="btnAddCat">
                                  <div class="input-group-append">
                                    <button class="btn btn-danger" type="button" id="btnAddCat" onClick="addCat(this)">Add</button>
                                  </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <i class="mdc-drawer-arrow material-icons">reply_all</i>
                              <var>Click to add on category list</var>
                              <select class="form-control" id="catSelect" onclick="addCat(this)" size="7" name="catSelect">
                                <?php $categorysql = "SELECT title FROM categories ORDER BY title ASC";
                                  $catresult = mysqli_query($conn, $categorysql);
                                    while ($catrow = mysqli_fetch_array($catresult))
                                    {
                                    ?>
                                    <option value="<?php echo $catrow['title']; ?>"><?php echo $catrow['title']; ?></option>
                                    <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <h5>Emergency</h5>
                              <input class="form-control" id="emergency" onKeyDown="enable()" name="emergency" value="<?php echo $newrow['emergency']; ?>">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <h5>Fax</h5>
                              <input class="form-control" id="fax" onKeyDown="enable()" name="fax" value="<?php echo $newrow['fax']; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <h5>Display Name</h5>
                              <input class="form-control" id="display_name" onKeyDown="enable()" name="display_name" value="<?php echo $newrow['display_name']; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <h5>Address</h5>
                              <textarea class="form-control" onKeyDown="enable()" name="address" rows="3"><?php echo $newrow['address']; ?> </textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <h5>Website</h5>
                              <input class="form-control" id="url" onKeyDown="enable()" name="url" value="<?php echo $newrow['url']; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="spacer"></div>
                        <div class="row justify-content-center"">
                          <div class="col align-self-center ">
                            <div class="form-group ">
                              <input type="hidden" name="moreid" value="<?php echo $moreid; ?>">
                              <button type="submit" name="update" class="btn btn-success">Update</button>
                              <a href="<?php echo $routes['amenities'];?>" class="btn btn-danger">Cancel</a>
                            </div>
                          </div>
                        </div>
                        <div class="spacer"></div>
                      </div>
                    </form>
                    
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
