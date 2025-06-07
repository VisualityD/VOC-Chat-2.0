<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
if(isset($_SESSION['login'])){
	$login = $_SESSION['login'];
	$pass = $_SESSION['pass'];
		
	$prof = getFile($_SESSION['id'],1);
	$prof['on_chat'] = 0;
	setFile($_SESSION['id'],$prof);
	
	unset($_SESSION['pass']);
	unset($_SESSION['login']);
	unset($_SESSION['id']);
	unset($_SESSION['mail']);
	unset($_SESSION['sex']);
	unset($_SESSION['photo']);

	
	addMess($conf['boot']," <b>$login</b> прощается со всеми и уходит.");
	mysql_query("UPDATE users SET online='0',onchat='0' WHERE login='$login' AND pass='$pass'");
}else{
	//go('index.php');
}
go('index.php');
?>
<!DOCTYPE html>
<html>
  <head>
	<title>Выход с чата</title>
	<link rel="stylesheet" href="<?=$css_url;?>window.css" type="text/css" />
  </head>
  <body>
	<br><br>
	<center>Спасибо за участие. Приходите каждый день для повышения рейтинга.</center>
	<br><br><center><a href="index.php">На главную</a></center>
  </body>
</html>