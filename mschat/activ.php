<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");

$login = hts('l');
$hash = hts('h');

$sql = "SELECT id FROM users WHERE login='$login' AND activ='$hash'";
$sql = mysql_query($sql);
$sql = mysql_fetch_array($sql);
echo "<p>";
if($sql['id'] > 0){
$res = mysql_query("UPDATE users SET activ='1' WHERE login='$login' AND activ='$hash'");
if($res)
	echo "Ваш аккаунт активировано! Теперь Вы можете пользоватся сайтом без ограничений! Спасибо! <br><b>Внимание!</b> Если Вы в данный момент находитесь в чате, необходимо перезайти чтобы изменения вступили в силлу!";
else
	echo "Произошла ошибка при активации аккаунта";
}else
	echo "Аккаунт не найдет либо ссылка повреждена.";
echo "</p><p><a href='index.php'>Перейти на главную страницу</a></p>";
?>