<?php
session_start();
header("Content-type: text/html;charset=utf-8");
if (!defined("_COMMON_"))
	require_once("common.php");
//вынимаем всех кто онлайн
$online_scaner = "SELECT id,onlinetime,login FROM users WHERE online='1'";
$online_scaner = mysql_query($online_scaner);
$online_scanen = mysql_fetch_array($online_scaner);
do{
	//если нету конекта выводим по таймауту
	if($online_scanen['onlinetime'] + $conf['zaderjka'] < time())
	{
		$id_on = $online_scanen['id'];
		mysql_query("UPDATE users SET online='0' WHERE id='$id_on'");
		
		$prof = getFile($id_on);
		if($prof['on_chat'] == 1){
			//сбрасываем вход в чат			
			$prof['on_chat'] = 0;
			setFile($id_on,$prof);
			
			addMess($conf['boot']," <b>".$online_scanen['login']."</b> уходит по-английски (таймаут).");
		}
	}
}while($online_scanen = mysql_fetch_array($online_scaner));
?>