<?php

// // configuration
// require("inc/config.php"); 

// // log out current user, if any
// logout();

// // redirect user
// redirect("/");

// // unset any session variables
// $_SESSION = [];

// // expire cookie
// if (!empty($_COOKIE[session_name()])) {
//     setcookie(session_name(), "", time() - 42000);
// }

// // destroy session
// session_unset();

// // header("inedx.php");
// redirect("/");


session_start(); // 开始会话

// 注销所有会话变量
session_unset();

// 销毁会话
session_destroy();

// 重定向到首页
header("Location: index.php");
exit;
?>