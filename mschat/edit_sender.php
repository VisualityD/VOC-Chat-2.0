<?php
//Файл отвечает за сохранение данных фрейма отправки сообщений
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
if(isset($_POST['color'])){//сохраняем цвет ообщений
	$color = strip_tags($_POST['color']);
	$prof = getFile($_SESSION['id']);
	$prof['color'] = $color;
	setFile($_SESSION['id'],$prof);
}
if(isset($_POST['color_grad'])){//сохраняем цвет градиента
	$color_grad = strip_tags($_POST['color_grad']);
	$prof = getFile($_SESSION['id']);
	$prof['color_grad'] = $color_grad;
	setFile($_SESSION['id'],$prof);
}
?>