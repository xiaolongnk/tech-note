<?php
session_start();
setcookie("hello",'xx');
var_dump($_SESSION);
var_dump($_COOKIE);
echo $HTTP_COOKIE_VARS["TestCookie"];

?>
