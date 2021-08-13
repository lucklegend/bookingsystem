<?php
session_start();
include_once('../../config/config.php');
isset($_SESSION['basic_is_logged_in']) ? $s_id = $_SESSION['basic_is_logged_in'] : $s_id = '';

$getUserData = getUser($conn, $_GET['crypted'], $s_id, $routes);
$id = $getUserData['id'];
$user_type = $getUserData['user_type'];
$name = $getUserData['name'];
$username = $getUserData['username'];

checkIfLogIn($id, $routes);
checkIfAdmin($id, $user_type, $routes);

if(isset($_GET['cat'])){
  $cat = $_GET['cat'];
}else{
  $cat = '';
}
// Declare the header title.
$headerTitle = 'Amenities Section';

//ADD HEADER HERE
include_once('../../layout/header.php'); 
?>
<script src="<?php echo $routes['URL'];?>assets/js/preloader.js"></script>
  <div class="body-wrapper">
    <!-- sidebar -->
    <?php
    //showing which is active
    $parentSub = 'manage content'; 
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
                    <h3 >Amenities</h3>
                    <div>
                        <i class="material-icons refresh-icon">refresh</i>
                        <i class="material-icons options-icon ml-2">more_vert</i>
                    </div>
                  </div>
                  <div class="mdc-card p-0">
                  <!-- START OF TABLE -->
                    <div class="table-responsive">
                    <script language="javascript">
                              
                      function selectAll(){
                        bState = document.form1.xAll.checked;
                        var elements = document.form1.getElementsByTagName("input");
                        for(i = 0; i < elements.length; i++){
                          if (elements[i].type == "checkbox")
                            elements[i].checked = bState;
                        }
                      }
                      function ChangeCat(){
                        location.href = "<?php echo $routes['amenities'];?>&cat=" + document.form1.cat.options[document.form1.cat.selectedIndex].value;
                      }
                      function del(){
                        var code = "";
                        var elements = document.form1.getElementsByTagName("input");
                        for (i = 0; i < elements.length; i ++){
                          if (elements[i].type == "checkbox" && 
                            elements[i].name != "xAll" &&
                            elements[i].checked)
                          {
                            //if (code != "")
                            //	code += ",";
                            code += elements[i].name += ",";
                          }
                        }

                        if (code.length == 0)	{
                          alert("Please select an item to delete.");
                          return;
                        }
                        
                        document.form1.action = "<?php echo $routes['amenitiesDelete'];?>&code="+code;
                        document.form1.code.value = code;
                        if (confirm("Do you really want to delete the item(s)?"))	{
                          document.form1.submit();
                        }
                      }
                    </script>
                    <?php
                      if(isset($_GET['msg'])){
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> Data[s] is now deleted.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php
                      }
                    ?>
                      <form name="form1" method="post">
                        <input type="hidden" name="code">
                        <input type="hidden" value="amenity" name="ty">
                        <table class="table table-hoverable" >
                          <thead>
                            <tr>
                              <th colspan="3" class="text-left"> 
                                <div class="form-group">
                                  <label for="select_category">Filter via:</label>
                                      <select onChange="ChangeCat()" name="cat" class="form-control" id="select_category">
                                        <option value="-1" <?php 
                                          if(isset($cat)){
                                            if($cat == '-1'){
                                              echo 'selected';
                                            }else{
                                              echo '';
                                            }
                                          }else{
                                            echo '';
                                          }
                                        ?>>View All</option>
                                        <?php $categorysql = "SELECT title FROM categories ORDER BY title ASC";
                                          $catresult = mysqli_query($conn, $categorysql);
                                          while ($catrow = mysqli_fetch_array($catresult)){
                                        ?>
                                            <option value="<?php echo $catrow['title']; ?>" <?php if ($cat == $catrow['title']) { echo "selected"; }else{echo '2  ';} ?> ><?php echo $catrow['title']; ?></option>
                                        <?php 
                                          } 
                                        ?>
                                      </select>
                                </div>
                              </th>
                              <th colspan="1">
                                <a class="mdc-button mdc-button--raised filled-button--secondary" href="<?php echo $routes['amenitiesCreate']?>">
                                  ADD
                                </a>
                                &nbsp;
                                <a class="mdc-button mdc-button--raised filled-button--secondary" href="javascript:del();">
                                  DELETE
                                </a>
                              </th>
                            </tr>
                            <tr>
                              <th class="text-center" width="3%">
                                <input onclick="selectAll()" type="checkbox" name="xAll">
                              </th>
                              <th class="text-left" width="32%">Name</th>
                              <th class="text-left" width="12%">Contact Number</th>
                              <th class="text-left" width="53%">Address</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                              $showcatsql = "SELECT id, display_name, telephone, address FROM armenities";
                              if (isset($_GET['cat']) && $_GET['cat']!= ''){
                                $cat = $_GET['cat'];  
                                if($cat != '-1'){
                                  $showcatsql .= " WHERE category = '$cat'";
                                }
                              }
                              $showcatsql .= " ORDER BY display_name ASC";
                    
                              $catresult = mysqli_query($conn, $showcatsql);
                              $catresultamt = mysqli_num_rows($catresult);
                              if ($catresultamt == 0){
                                echo '
                                <tr>
                                  <td colspan="4" class="text-center">No amenities found under this category</td>
                                </tr> 
                                ';
                              }else{
                                while ($catrow = mysqli_fetch_array($catresult)){	
                                  echo '
                                  <tr align="left">
                                    <td class="text-center">
                                      <input type="checkbox" name="'.$catrow['id'].'">
                                    </td>
                                    <td class="text-left">
                                      <a href="'.$routes['amenitiesEdit'].'&code='.$catrow['id'].'">'.$catrow['display_name'].'</a>
                                    </td>
                                    <td class="text-left">'.$catrow['telephone'].'</td>
                                    <td class="text-left">'.$catrow['address'].'</td>
                                  </tr>
                                ';
                                }
                              }
                            ?>
                          </tbody>
                        </table>
                      </form>
                    </div>
                  <!-- END OF TABLE -->
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
