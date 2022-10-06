<?php
//reference https://www.simplilearn.com/tutorials/php-tutorial/php-login-form 
session_start();
session_unset();
session_destroy();
header("Location: index.php");
?>