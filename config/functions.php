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


?>