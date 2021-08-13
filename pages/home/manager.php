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

// FOR PAGINATION CALL in functions.php
$pagesize = 20;
if(isset($_GET['page'])){$currentpage = $_GET['page'];}else{$currentpage = 1;}
$recordstart = ($currentpage-1) * $pagesize;
$sr = $recordstart + 1;


// Declare the header title.
$headerTitle = 'Managers Section';

//ADD HEADER HERE
include_once('../../layout/header.php'); 
?>
<script src="<?php echo $routes['URL'];?>assets/js/preloader.js"></script>
  <div class="body-wrapper">
    <!-- sidebar -->
    <?php
    $parentSub = 'home';

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
                    <h3 >Management Office</h3>
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
                      if(isset($_GET['msg']) && $_GET['msg'] == 'delete'){
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> User is deleted.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <?php
                      }
                    ?>
                    <div class="container-fluid">
                      <div class="form-group">
                        <div class="btn-toolbar" role="toolbar" aria-label="Basic example">
                          <a href="<?php echo $routes['usersCreate'];?>" class="btn btn-success">Add New User</a> &nbsp;&nbsp;
                          <form method="get" action="<?php echo $routes['users'];?>" name="formsearch">
                            <div class="input-group mb-0 flex-nowrap">
                              <?php
                                if(isset($_GET['search'])){
                                  $search = $_GET['search']; 
                                  $search_option = "AND (username like '%".$_GET['search']."%' or name like '%".$_GET['search']."%' or email like '%".$_GET['search']."%')";
                                }else{
                                  $search = '';
                                  $search_option = "";
                                }
                            
                              ?>
                              <input name="crypted" type="hidden" value="<?php echo $_GET['crypted']; ?>">
                              <input type="text" value="<?php echo $search;?>" name="search" class="form-control" placeholder="Username / Name" aria-label="Search (Username / E-mail / Name)" aria-describedby="btn-search">
                              <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit" id="btn-search" ><i class="glyphicon glyphicon-search"></i>Search</button>
                              </div>
                            </div>
                          </form>
                        </div>    
                      </div>
                    </div>
                    <div class="spacer"></div>
                    <!-- START OF TABLE -->
                    <?php
                    //for arrow settings
                    $sortUserType = '';
                    $sortUserName = '';
                    $sortName = '';

                    // mode of sorting
                    if(!isset($_GET['mode'])){
                      $mode = 'ASC';
                    }

                    // SET THE SORT URL(s)
                    $sortURL = $pageURL.'?crypted='.$_GET['crypted'];

                    // FOR PAGINATION
                    $sortLinks = '';
                    $more = '';

                    if(isset($_GET['sort'])){
                      $more = 'ORDER BY '.$_GET['sort'].' '.$_GET['mode'];
                      
                      if($_GET['sort'] == 'last_logged_in' AND $_GET['mode']=='ASC'){
                        $mode = 'DESC';
                        $sortUserType = '-up';
                        $sortUserName = '';
                        $sortName = '';
                      }else if($_GET['sort'] == 'last_logged_in' AND $_GET['mode']=='DESC'){
                        $mode = 'ASC';
                        $sortUserType = '-down';
                        $sortUserName = '';
                        $sortName = '';
                      }else if($_GET['sort'] == 'username' && $_GET['mode']=='ASC'){
                        $mode = 'DESC';
                        $sortUserName = '-up';
                        $sortUserType = '';
                        $sortName = '';
                      }else if($_GET['sort'] == 'username' && $_GET['mode']=='DESC'){
                        $mode = 'ASC';
                        $sortUserName = '-down';
                        $sortUserType = '';
                        $sortName = '';
                      }else if($_GET['sort'] == 'name' && $_GET['mode']=='ASC'){
                        $mode = 'DESC';
                        $sortName = '-up';
                        $sortUserType = '';
                        $sortUserName = '';
                      }elseif($_GET['sort'] == 'name' && $_GET['mode']=='DESC'){
                        $mode = 'ASC';
                        $sortName = '-down';
                        $sortUserType = '';
                        $sortUserName = '';
                      }else{
                       
                      }
                      $sortLinks = '&sort='.$_GET['sort'].'&mode='.$_GET['mode'];
                    }
                    
                    ?>
                    <div class="table-responsive">
                      <form name="form1" method="post">
                        <table class="table table-hoverable" >
                          <thead>
                            <tr>
                              <th class="text-center" width="3%">
                                #
                              </th>
                              <th class="text-center" >
                                <a href="<?php echo $sortURL.'&sort=last_logged_in&mode='.$mode;?>">
                                  Last Login <i class="fa fa-sort<?php echo $sortUserType;?>"></i> 
                                </a>
                              </th>
                              <th class="text-center" >
                                <a href="<?php echo $sortURL.'&sort=username&mode='.$mode;?>">
                                  Username <i class="fa fa-sort<?php echo $sortUserName;?>"></i>
                                </a>
                              </th>  
                              <th class="text-center" >
                                <a href="<?php echo $sortURL.'&sort=name&mode='.$mode;?>">
                                  Name <i class="fa fa-sort<?php echo $sortName;?>"></i>
                                </a>
                              </th>
                              <th class="text-center" >Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                              $query = "SELECT * FROM user_account WHERE active ='1' AND user_type = '1' $search_option $more";
                              $result = mysqli_query($conn, $query);
                              //for pagination
				                      $num_pagination = mysqli_num_rows($result);
                              $query .= " LIMIT $recordstart, $pagesize";
                              $result = mysqli_query($conn, $query);
				                      
                              function shoUserType($type){
                                $userShow ='';
                                if($type =='0') {
                                  $userShow = "Residents";
                                }elseif($type =='1') {
                                  $userShow = "Managers";
                                }elseif($type =='2') {
                                  $userShow = "Club";
                                }
                                return $userShow;
                              }
                              $countQuery = mysqli_num_rows($result);
                              if ( $countQuery == 0){
                                echo '
                                <tr>
                                  <td colspan="5" class="text-center">No Username / Name Found!</td>
                                </tr> 
                                ';
                              }else{
                                while($row = mysqli_fetch_array($result)) {
                                  echo "<tr class='text-center'>
                                          <td class='text-center'>".$sr."</td>
                                          <td class='text-center'>".$row['last_logged_in']."</td>
                                          <td class='text-center'>".$row['username']."</td>
                                          <td class='text-center'>".$row['name']."</td>
                                          <td class='text-center'> 
                                            <a class='btn btn-warning btn-sm' href=".$routes['usersEdit']."&id=".$row['id'].">Edit</a> | 
                                            <a class='btn btn-danger btn-sm' 
                                              href=".$routes['usersDelete']."&dele=".$row['id']." 
                                              onClick=\"return confirm('This will delete the user from System, Are you sure ?');\">
                                              Delete
                                            </a> 
                                            
                                          </td>
                                        </tr>
                                  ";
                                  $sr++;
                              
                                }
                              }
                            ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="5">
                              <?php
                                $totalpages = ceil($num_pagination / $pagesize);
                                if ($totalpages >= 1) {
                                  //Call Function Pagination.
                                  echo "<font color='black'>" . pageLinks($totalpages,$currentpage, $pagesize, $sortLinks) . "</font>";
                                }
                              ?>
                              </td>
                            </tr>
                          </tfoot>
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
