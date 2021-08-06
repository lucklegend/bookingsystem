<?php
// This is used for generating crypted code.. 

$min=10; // minimum length of password
$max=25; // maximum length of password
$pwd=""; // to store generated password

for($i=0;$i<rand($min,$max);$i++){
$num=rand(48,122);

  if(($num > 97 && $num < 122)) {
      $pwd.=chr($num);
  }

  else if(($num > 65 && $num < 90)) {
      $pwd.=chr($num);
  }

  else if(($num >48 && $num < 57)) {
      $pwd.=chr($num);
  }

  else if($num==95) {
      $pwd.=chr($num);
  }

  else {
      $i--;
  }
}
?>