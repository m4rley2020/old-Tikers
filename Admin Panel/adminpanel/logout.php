<?php
  session_start();
  setcookie("UsErOfAdMiN","");
  $UsErOfAdMiN="";
//  session_destroy();
  unset($_SESSION["ADMIN_SESS_USERID"]);
  unset($_SESSION["ADMIN_SESS_USERTYPE"]);
   unset($_SESSION['query']);
  header("Location:index.php");
?>
