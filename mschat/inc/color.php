<?php
//Смайлы которые отображаются в плавающем окошке
session_start();
require_once("common.php");
$prof = getFile($_SESSION['id']);
if(strlen($prof['colors'])>0)
	$file_colors = $prof['colors'];
else
	$file_colors = "mini";
if(!is_file($data_dir."colors/".$file_colors.".dat"))
	globalError("Не могу найти файл с настойками data", "Проверте что с файлом $data_conf");
$colors_fila = File($data_dir."colors/".$file_colors.".dat");
$colors_fila = explode("^",$colors_fila[0]);
?>
<style>
.colors_td{
	float:left;
	width:20px;
	height:20px;
	border: 1px solid black;
	margin:2px;
	cursor:pointer;
}
.colors_td:hover{
	border: 2px solid black;
	margin:1px;
}
</style>
<?
if($grad == 1){//градиент
	$func = "saveColorGrad";
	$colors_grad = "";	
	for ($c=0; $c<count($colors_fila); $c++)
	{
		$colors_grad .= "<div class='colors_td' style='background-color:".$colors_fila[$c].";' onclick=\"saveColorGrad('".$colors_fila[$c]."');\"></div>";

	}
	if($prof['class'] == "e3d" || $prof['class'] == "neon_pink" || $prof['class'] == "neon_blue")
		$colors_grad .= "<div class='colors_td' style='background-color:#ffffff;' onclick=\"saveColorGrad('#ffffff');\"></div>";
	echo $colors_grad;
}else{//основной цвет
	$colors = "";	
	for ($c=0; $c<count($colors_fila); $c++)
	{
		$colors .= "<div class='colors_td' style='background-color:".$colors_fila[$c].";' onclick=\"saveColor('".$colors_fila[$c]."');\"></div>";

	}
	if($prof['class'] == "e3d" || $prof['class'] == "neon_pink" || $prof['class'] == "neon_blue")
		$colors .= "<div class='colors_td' style='background-color:#ffffff;' onclick=\"saveColor('#ffffff');\"></div>";
	echo $colors;
}
?>
