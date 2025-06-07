<?php
//Смайлы которые отображаются в плавающем окошке
session_start();
require_once("../common.php");
$id = hts('id');
$id = intval($id);
$like_sql = "SELECT kto FROM likesPhoto WHERE id_photo='$id' ORDER BY id DESC LIMIT 50";
$like_mysql = mysql_query($like_sql);
$likes = mysql_fetch_array($like_mysql);
do{
	$profile_sql = "SELECT photo,login,online,name,fname FROM users WHERE id='".$likes['kto']."'";
	$profile_mysql = mysql_query($profile_sql);
	$profile = mysql_fetch_array($profile_mysql);
	if($profile['login']){
		$dir_profile = "../users/".floor($likes['kto']/1000).'/'.$likes['kto']."/";
		
		if($profile['photo'] && is_file($dir_profile."photos/1/makro".$profile['photo']))
			$photo = $dir_profile."photos/1/makro".$profile['photo'];
		else 
			$photo = $image_url."nophoto.png";
		if(mb_strlen($profile['login'], "utf-8") > 7){
			$nik = mb_substr($profile['login'], 0, 7, "utf-8");
			$nik = $nik."...";
		}else{
			$nik = $profile['login'];
		}
		echo "<div class='user_komm_photo' title='".$profile['name']." ".$profile['fname']."'><a href='id".$likes['kto']."' target=_blank><img src='$photo' border='0' width='50'><br>".$nik."</a></div>";
	}
}while($likes = mysql_fetch_array($like_mysql));
?>