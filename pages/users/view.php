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

//PAGINATION
$pagesize = 20;
if(isset($_GET['page'])){$currentpage = $_GET['page'];}else{$currentpage = 1;}
$recordstart = ($currentpage-1) * $pagesize;
$sr = $recordstart + 1;

function pageLinks ($totalpages, $currentpage, $pagesize) {
	$page = 1;
	$pageLinks = "";
  $pageURL = str_replace(".php","",$_SERVER['PHP_SELF']);
  $adjacents = "2"; 
  $secondLastPage = $totalpages-1;

  if($_GET['page'] <= 1){ 
    $disabled = 'disabled';
  }else{
    $disabled = '';
    $pagePrev = $_GET['page']-1; 
  }
  // Declaration of Bootstrap Pagination
  $pageLinks .= '
              <nav aria-label="...">
                <ul class="pagination">
                  <li class="page-item '.$disabled.'">
                    <a class="page-link" href="'.$pageURL.'?page='.$pagePrev.'&crypted='.$_GET['crypted'].'">Previous</a>
                  </li>
  ';
  // Proceed on printing the page numbers
  //  check if totalpages <=10
  if($totalpages <= 10){
    
    for($page; $page <= $totalpages; $page++){
      if($page == $currentpage){
        //declare the active page number
        $pageLinks .= '<li class="page-item active" aria-current="page">
                        <span class="page-link">
                          '.$page.'
                         </span>
                      </li> 
        ';
      }else{
        // print the other page numbers
        $pageLinks .= '<li class="page-item">
            <a class="page-link" href="'.$pageURL.'?page='.$page.'&crypted='.$_GET['crypted'];
        if ($_GET['sort'] != '')	{
          $pageLinks .= "&sort=" . $_GET['sort'];
        }
        if ($_GET['mode'] != ''){
          $pageLinks .= "&mode=" . $_GET['mode'];
        }

        $pageLinks .= '">'.$page.'</a></li>';
      }
    }
  }elseif ($totalpages > 10){
    if($currentpage <= 4){
      for ($page = 1; $page < 8; $page++){		 
				if($page == $currentpage){
          //declare the active page number
          $pageLinks .= '<li class="page-item active" aria-current="page">
                          <span class="page-link">
                            '.$page.'
                           </span>
                        </li> 
          ';
        }else{
          // print the other page numbers
          $pageLinks .= '<li class="page-item">
              <a class="page-link" href="'.$pageURL.'?page='.$page.'&crypted='.$_GET['crypted'];
          if ($_GET['sort'] != '')	{
            $pageLinks .= "&sort=" . $_GET['sort'];
          }
          if ($_GET['mode'] != ''){
            $pageLinks .= "&mode=" . $_GET['mode'];
          }
  
          $pageLinks .= '">'.$page.'</a></li>';
        }                
      }
      //Add ending numbers
      $pageLinks .='
              <li class="page-item"> <a class="page-link"> ... </a></li>
              <li class="page-item">
                <a class="page-link" href="'.$pageURL.'?page='.$secondLastPage.'&crypted='.$_GET['crypted'].'">'.$secondLastPage.'</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="'.$pageURL.'?page='.$totalpages.'&crypted='.$_GET['crypted'].'">'.$totalpages.'</a>
              </li>
      ';
    }
    elseif($currentpage > 4 && $currentpage < $totalpages - 4){
      //print page 1 and 2 and ...
      $pageLinks .= '<li class="page-item">
              <a class= "page-link" href="'.$pageURL.'?page=1&crypted='.$_GET['crypted'].'">1</a>
            </li>
            <li class="page-item">
              <a class= "page-link" href="'.$pageURL.'?page=2&crypted='.$_GET['crypted'].'">2</a>
            </li>
            <li class="page-item">
              <a class= "page-link">...</a>
            </li>
            ';
      //make a for loop
      for ($page = $currentpage - $adjacents; $page <= $currentpage + $adjacents; $page++) {			
        if($page == $currentpage){
          //declare the active page number
          $pageLinks .= '<li class="page-item active" aria-current="page">
                          <span class="page-link">
                            '.$page.'
                           </span>
                        </li> 
          ';
        }else{
          // print the other page numbers
          $pageLinks .= '<li class="page-item">
              <a class="page-link" href="'.$pageURL.'?page='.$page.'&crypted='.$_GET['crypted'];
          if ($_GET['sort'] != '')	{
            $pageLinks .= "&sort=" . $_GET['sort'];
          }
          if ($_GET['mode'] != ''){
            $pageLinks .= "&mode=" . $_GET['mode'];
          }
  
          $pageLinks .= '">'.$page.'</a></li>';
        }                
      }
      //Add ending numbers
      $pageLinks .='
              <li class="page-item"> <a class="page-link"> ... </a></li>
              <li class="page-item">
                <a class="page-link" href="'.$pageURL.'?page='.$secondLastPage.'&crypted='.$_GET['crypted'].'">'.$secondLastPage.'</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="'.$pageURL.'?page='.$totalpages.'&crypted='.$_GET['crypted'].'">'.$totalpages.'</a>
              </li>
      ';      
    }
    else{
      $pageLinks .= '<li class="page-item">
          <a class= "page-link" href="'.$pageURL.'?page=1&crypted='.$_GET['crypted'].'">1</a>
        </li>
        <li class="page-item">
          <a class= "page-link" href="'.$pageURL.'?page=2&crypted='.$_GET['crypted'].'">2</a>
        </li>
        <li class="page-item">
          <a class= "page-link">...</a>
        </li>
      ';
      //make a for loop
      for ($page = $totalpages - 6; $page <= $totalpages; $page++) {
        if($page == $currentpage){
          //declare the active page number
          $pageLinks .= '<li class="page-item active" aria-current="page">
                          <span class="page-link">
                            '.$page.'
                           </span>
                        </li> 
          ';
        }else{
          // print the other page numbers
          $pageLinks .= '<li class="page-item">
              <a class="page-link" href="'.$pageURL.'?page='.$page.'&crypted='.$_GET['crypted'];
          if ($_GET['sort'] != '')	{
            $pageLinks .= "&sort=" . $_GET['sort'];
          }
          if ($_GET['mode'] != ''){
            $pageLinks .= "&mode=" . $_GET['mode'];
          }
  
          $pageLinks .= '">'.$page.'</a></li>';
        }                
      }  
    }
  }
  
  // Ending the pagination with Next Button
  if($_GET['page'] >= $totalpages || $totalpages < 2){
    $nextDisabled = 'disabled';
  }else{
    $nextDisabled = '';
    $pageNext = $_GET['page']+1; 
  }

  $pageLinks .='
          <li class="page-item '.$nextDisabled.'">
             <a class="page-link" href="'.$pageURL.'?page='.$pageNext.'&crypted='.$_GET['crypted'].'">Next</a>
          </li>
          <li class="page-item '.$nextDisabled.'">
             <a class="page-link" href="'.$pageURL.'?page='.$totalpages.'&crypted='.$_GET['crypted'].'">Last</a>
          </li>
        </ul>
      </nav>
  ';
  //PRINTING OUT THE LAST BUTTON.
	if ($totalpages == 0) {
		return "Page 1";
	} else {
		return $pageLinks;
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
                    <div class="container-fluid">
                      <div class="form-group">
                        <div class="btn-toolbar" role="toolbar" aria-label="Basic example">
                          <a href="#" class="btn btn-success">Add New User</a> &nbsp;&nbsp;
                          <form method="get" action="<?php echo $routes['users'];?>" name="formsearch">
                            <div class="input-group mb-0 flex-nowrap">
                              <?php
                                if(isset($_GET['search'])){
                                  $search = $_GET['search']; 
                                  $search_option = "and (username like '%".$_GET['search']."%' or name like '%".$_GET['search']."%' or email like '%".$_GET['search']."%')";
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
                    <div class="table-responsive">
                      <form name="form1" method="post">
                        <table class="table table-hoverable" >
                          <thead>
                            <tr>
                              <th class="text-center" width="3%">
                                #
                              </th>
                              <th class="text-center" >User Type</th>
                              <th class="text-center" >Username</th>
                              <th class="text-center" >Name</th>
                              <th class="text-center" >Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                              $query = "SELECT * FROM user_account WHERE active ='1' $search_option $more";
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
                                          <td class='text-center'>".shoUserType($row['user_type'])."</td>
                                          <td class='text-center'>".$row['username']."</td>
                                          <td class='text-center'>".$row['name']."</td>
                                          <td class='text-center'> 
                                            <a href=facility.php?crypted=".$_GET['crypted']."&page=user&edit=".$row['id'].">Edit</a> | 
                                            <a href=facility.php?crypted=".$_GET['crypted']."&page=user&dele=".$row['id']." onClick=\"return confirm('This will delete the user from System, Are you sure ?');\">Delete</a> 
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
                                echo "<font color='black'>" . pageLinks($totalpages,$currentpage, $pagesize) . "</font>";
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
