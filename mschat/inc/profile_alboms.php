<?php
//альбомы которые отображаются в профиле
session_start();
require_once("../common.php");
//достаем альбомы
$myid = $_SESSION['id'];
$dir_profile = "users/".floor($_SESSION['id']/1000).'/'.$_SESSION['id']."/";
$alboms_text = "SELECT title,id,text,date,img FROM alboms WHERE id_user='$myid' ORDER BY id DESC";
$albom_arr = mysql_query($alboms_text);
if($albom_arr)
	$albom = mysql_fetch_array($albom_arr);
do{
	if($albom['title']){
		//количество фоток в альбоме
		$result00 = mysql_query("SELECT COUNT(*) FROM photos WHERE albom='".$albom['date']."'");
		$temp = mysql_fetch_array($result00);
		$count = $temp[0];
		//
		echo "<div class='albom_div_all'><div id='alb".$albom['id']."' class='min'>";
		echo "<div class='delete_albom' onclick='deleteAlbom(".$albom['id'].");' title='Удалить'></div>"; 
		echo "<div class='border_albom_photo' onclick=\"location.href='profile.php?p=4&alb=".$albom['id']."'\">";
		$title = mb_substr($albom['title'], 0, 20, "utf-8");
		if($albom['img'] && is_file("../".$dir_profile."photos/".$albom['date']."/mini".$albom['img'].".jpg"))
			echo "<img src='".$dir_profile."photos/".$albom['date']."/mini".$albom['img'].".jpg' class='albom_img'>";
		else
			echo "<img src='templaces/default/images/albom.png' class='albom_img'>";
		echo "</div>";
		echo "<div class='title_albom_block'  onclick=\"location.href='profile.php?p=4&alb=".$albom['id']."'\">".$title."<br><span class='countPhoto'>".$count." фото</span></div>";
		echo "</div></div>";
	}
}while($albom = mysql_fetch_array($albom_arr));
?>