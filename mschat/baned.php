<?php
//Файл отвечает за вывод информации забаненым
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
$login = $_SESSION['login'];
$pass = $_SESSION['pass'];

//проверка есть ли такой пользователь
$sql_text_prov = "SELECT id,ban FROM users WHERE login='$login' LIMIT 1";
$sql_prov = mysql_query($sql_text_prov);
if($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);
if($sql_prov_arr['ban'] == 1){
	//может пора разбанить))
	$sql_text_prov = "SELECT id,time,min FROM ban WHERE user='$login' AND type='1' LIMIT 1";
	$sql_prov = mysql_query($sql_text_prov);
	if($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);
	if($sql_prov_arr['time']+$sql_prov_arr['min'] < time()){
		//разбаним
		@mysql_query("UPDATE users SET ban='0' WHERE login='$login'");
		@mysql_query ("DELETE FROM ban WHERE id='".$sql_prov_arr['id']."'");
		header("Location: index.php");
		exit("Загрузка");
	}	
	//вынимаем время и причину бана
	$sql_text_prov = "SELECT time,min FROM ban WHERE user='$login' AND type='1' LIMIT 1";
	$sql_prov = mysql_query($sql_text_prov);
	if($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);
	$ost = $sql_prov_arr['time']+$sql_prov_arr['min'] - time();
	if($ost > 1440){
		$text = "Вы отключены до ".date("d.m.Y, H:i",$sql_prov_arr['time']+$sql_prov_arr['min']);
	}else if($ost > 60){
		$text = "Вы отключены до ".date("H:i",$sql_prov_arr['time']+$sql_prov_arr['min']);
	}else{
		$text = "Вы отключены на $ost секунд.";
	}
		//отключаем чтбы не писало таймаут
	if(isset($_SESSION['login'])){
		mysql_query("UPDATE users SET online='0',onchat='0' WHERE login='$login' AND pass='$pass'");
	}
}
?><!DOCTYPE html>
<html>
  <head>
	<title>Вы отключены</title>
	<style>
		.bord{display:none;}
		#l_linein{display:none;}
	</style>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<link rel="stylesheet" href="<?=$css_url;?>window.css" type="text/css" />
	<script>
		$('#users').animate({width: "100%"}, 200, function(){});
	</script>
  </head>
  <body>
	<br><br><center><?=$text;?><br><br>
	Если Вы считаете что произошла ошибка, обратитесь в тех поддержку <?=$conf['mail'];?>
	</center>
  </body>
</html>