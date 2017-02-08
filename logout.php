<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: DBConnection/loginPage.php");
   }
?>