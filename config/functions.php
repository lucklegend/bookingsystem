<?php
// MAKE ALL CUSTOM FUNCTION HERE
// Be as global as you can be.

// This function used for Getting the INFORMATION OF THE USER...
function getUser($conn, $crypted, $s_id, $routes){
	$query = "SELECT * FROM user_account  where crypted  = '".$crypted."' and id = '".$s_id."' limit 1";
	$result= mysqli_query($conn, $query) or die(mysqli_error($conn));
	$count = mysqli_num_rows($result);
	$data = array();
	if($count > 0){
		while($row = mysqli_fetch_array($result)){
			$data['id'] = $row['id'];
			$data['user_type'] = $row['user_type'];
			$data['name'] = $row['name'];
			$data['username'] = $row['username'];
            $data['user_type'] = $row['user_type'];
            $data['active'] = $row['active'];
		}
        return $data;
	}else{
        echo "<script type=text/javascript language=javascript> window.location.href = '".$routes['login']."'; </script> ";
    }
	
}
// CHECK if the USER is logged-in call this in every page.
function checkIfLogIn($id, $routes){
    if(time()-$_SESSION["last_activity"] >1200)  {
        session_unset();
        session_destroy();
        echo "<script type=text/javascript language=javascript> window.location.href ='".$routes['login']."'; </script> ";
    }else{
        $_SESSION["last_activity"] = time();
    }

	if($_SESSION['basic_is_logged_in'] != $id or $_SESSION['basic_is_logged_in'] ==''){
        echo "<script type=text/javascript language=javascript> window.location.href ='".$routes['login']."'; </script> ";
        exit();
	}
}

function checkIfAdmin($id, $userType, $routes){
    if($userType != 1){
        session_unset();
        session_destroy();
        echo "<script type=text/javascript language=javascript> window.location.href ='".$routes['login']."'; </script> ";
        exit();
    }
    if(time()-$_SESSION["last_activity"] >1200)  {
        session_unset();
        session_destroy();
        echo "<script type=text/javascript language=javascript> window.location.href ='".$routes['login']."'; </script> ";
    }else{
        $_SESSION["last_activity"] = time();
    }

	if($_SESSION['basic_is_logged_in'] != $id or $_SESSION['basic_is_logged_in'] ==''){
        echo "<script type=text/javascript language=javascript> window.location.href ='".$routes['login']."'; </script> ";
        exit();     
	}
}

function countActiveUsers($user_type, $conn){
    $query = "SELECT COUNT(*) AS countUsers FROM user_account WHERE active = '1' AND user_type = '".$user_type."'";
    $query2 = "SELECT COUNT(*) AS countAll FROM user_account WHERE active = '1 '";
    $row = mysqli_fetch_array(mysqli_query($conn, $query));
    $row2 = mysqli_fetch_array(mysqli_query($conn, $query2));
    $data = array();
    $countUsers = $row['countUsers'];
    $countAll = $row2['countAll'];
    $percent = ($countUsers / $countAll) * 100;
    $rounded = round($percent, 2);
    $data = [
        'countUsers' =>$countUsers,
        'percentage' =>$rounded
    ];
    return $data;
}

function findBooking($year, $conn){
    $query = "SELECT COUNT(*) AS `totalBook`, `month` 
            FROM my_booking 
            WHERE `year` = ".$year." AND `status` = 1 
            GROUP BY `month` ASC";
    $result = mysqli_query($conn, $query) or mysqli_error($conn);
    $count = mysqli_num_rows($result);
    $arrayFil = array();

    while($rows = mysqli_fetch_assoc($result)){
    $arrayFil[] = $rows['totalBook'];
    }
    $data = array();
    $arrayFil = array_filter($arrayFil);
    if(count($arrayFil)){
    $bookAve = array_sum($arrayFil) / count($arrayFil);
    }
    $bookingAve = round($bookAve);
    $data = [
        'rows' => $rows,
        'bookingAve' => $bookingAve
    ];
    if($count>0){
        return $data;
    }else{
        return false;
    }
}
//PAGINATION

function pageLinks ($totalpages, $currentpage, $pagesize, $sortLinks) {
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
                    <a class="page-link" href="'.$pageURL.'?page='.$pagePrev.'&crypted='.$_GET['crypted'].$sortLinks.'">Previous</a>
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
            <a class="page-link" href="'.$pageURL.'?page='.$page.'&crypted='.$_GET['crypted'].$sortLinks;
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
              <a class="page-link" href="'.$pageURL.'?page='.$page.'&crypted='.$_GET['crypted'].$sortLinks;
          $pageLinks .= '">'.$page.'</a></li>';
        }                
      }
      //Add ending numbers
      $pageLinks .='
              <li class="page-item"> <a class="page-link"> ... </a></li>
              <li class="page-item">
                <a class="page-link" href="'.$pageURL.'?page='.$secondLastPage.'&crypted='.$_GET['crypted'].$sortLinks.'">'.$secondLastPage.'</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="'.$pageURL.'?page='.$totalpages.'&crypted='.$_GET['crypted'].$sortLinks.'">'.$totalpages.'</a>
              </li>
      ';
    }
    elseif($currentpage > 4 && $currentpage < $totalpages - 4){
      //print page 1 and 2 and ...
      $pageLinks .= '<li class="page-item">
              <a class= "page-link" href="'.$pageURL.'?page=1&crypted='.$_GET['crypted'].$sortLinks.'">1</a>
            </li>
            <li class="page-item">
              <a class= "page-link" href="'.$pageURL.'?page=2&crypted='.$_GET['crypted'].$sortLinks.'">2</a>
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
              <a class="page-link" href="'.$pageURL.'?page='.$page.'&crypted='.$_GET['crypted'].$sortLinks;
          $pageLinks .= '">'.$page.'</a></li>';
        }                
      }
      //Add ending numbers
      $pageLinks .='
              <li class="page-item"> <a class="page-link"> ... </a></li>
              <li class="page-item">
                <a class="page-link" href="'.$pageURL.'?page='.$secondLastPage.'&crypted='.$_GET['crypted'].$sortLinks.'">'.$secondLastPage.'</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="'.$pageURL.'?page='.$totalpages.'&crypted='.$_GET['crypted'].$sortLinks.'">'.$totalpages.'</a>
              </li>
      ';      
    }
    else{
      $pageLinks .= '<li class="page-item">
          <a class= "page-link" href="'.$pageURL.'?page=1&crypted='.$_GET['crypted'].$sortLinks.'">1</a>
        </li>
        <li class="page-item">
          <a class= "page-link" href="'.$pageURL.'?page=2&crypted='.$_GET['crypted'].$sortLinks.'">2</a>
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
              <a class="page-link" href="'.$pageURL.'?page='.$page.'&crypted='.$_GET['crypted'].$sortLinks;
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
             <a class="page-link" href="'.$pageURL.'?page='.$pageNext.'&crypted='.$_GET['crypted'].$sortLinks.'">Next</a>
          </li>
          <li class="page-item '.$nextDisabled.'">
             <a class="page-link" href="'.$pageURL.'?page='.$totalpages.'&crypted='.$_GET['crypted'].$sortLinks.'">Last</a>
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
// END OF PAGINATION

?>