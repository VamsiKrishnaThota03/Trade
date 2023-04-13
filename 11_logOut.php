<?php 

session_start(); 
session_unset(); 
session_destroy(); 

header("location: 1_main_page.php"); 
exit();


?>