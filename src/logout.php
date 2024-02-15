<?php
// logout.php
session_start(); 


session_unset();

// destroy the session 
session_destroy();

// redirect to home page
header("Location: index.php");
exit;
?>