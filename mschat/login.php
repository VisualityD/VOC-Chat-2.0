<?
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
if($_POST['go'] == 1)
	go("user.php");
else go("chat.php");
?>