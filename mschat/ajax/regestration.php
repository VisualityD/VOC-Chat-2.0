<?php
//Файл отвечает за сохранение данных профиля
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../common.php");

//проверка на одинаковые логины
if(isset($_POST['login'])){
	$login = hts('login');
	
	$sql_text_prov = "SELECT id FROM users WHERE login='$login' LIMIT 1";
	$sql_prov = mysql_query($sql_text_prov);	
	if ($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);

	if ($sql_prov_arr)
		echo 1;
	else
		echo 0;
}

//проверка на одинаковые mail
if(isset($_POST['mail'])){
	$mail = hts('mail');
	
	$sql_text_prov = "SELECT id FROM users WHERE mail='$mail' LIMIT 1";
	$sql_prov = mysql_query($sql_text_prov);	
	if ($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);

	if ($sql_prov_arr)
		echo 1;
	else
		echo 0;
}
?>