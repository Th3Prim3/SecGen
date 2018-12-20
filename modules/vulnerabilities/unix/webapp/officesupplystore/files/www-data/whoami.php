<?php

  // if we are logged in ...
  if($_SESSION and $_SESSION['user']) {
    // get the mysql database object
    require_once("mysql.php");
  }

?>