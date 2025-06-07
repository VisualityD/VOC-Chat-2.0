<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../../common.php");
require_once("../../connect.php");
@$id = intval($_GET['id']);
$myid = $_SESSION['id'];

$dir_profile = "users/".floor($id/1000).'/'.$id."/";
if(isset($_GET['alb'])){
	$id_albom = intval($_GET['alb']);
	//вынимаем date с альбома по id
	$alboms_text = "SELECT date,title,text FROM alboms WHERE id_user='$id' AND id='$id_albom' LIMIT 1";
	$albom_arr = mysql_query($alboms_text);
	if($albom_arr)
		$albom = mysql_fetch_array($albom_arr);			
	$title = $albom['title'];
	$text = $albom['text'];
	$albom = $albom['date'];
	echo '<div id="formadd"><b>'.$title.'</b><div class="formsmall">'.$text.'</div>';	
		echo "<a class='edit_alb_a_left' onclick='navi(2,1);'>Назад к фотоальбомам</a>";
	if($myid == $id)
		echo "<a class='edit_alb_a' href='profile.php?p=4&alb=".$id_albom."'>Редактировать альбом</a>";
	echo "</div>";
	//вынимаем фотографии
	$photos_text = "SELECT id,photo FROM photos WHERE id_user='$id' AND albom='$albom' ORDER BY id DESC";
	$photo_arr = mysql_query($photos_text);
	if($photo_arr)
		$photo = mysql_fetch_array($photo_arr);
	do{
		if($photo['photo']){?>
		<div class='photo_div_all'>
			<div id='photo<?=$photo['id'];?>' class='val'>
				<img src="<?=$dir_profile;?>photos/<?=$albom;?>/mini<?=$photo['photo'];?>.jpg" class='photo_img' onclick="viewOn(<?=$albom;?>,'<?=$photo['id'];?>',0,1);">
			</div>
		</div>
		<?}else{
			echo "<br><center>В данном альбоме фотографий нет!<br><br></center>";
			if($myid == $id)
				echo "<center><a  href='profile.php?p=4&alb=".$id_albom."'>Загрузить</a></center><br><br>";
		}
	}while($photo = mysql_fetch_array($photo_arr));
}else{
	//сколько всего фльбомов
	$all = mysql_query("SELECT COUNT(*) FROM photos WHERE id_user='$id'");
	if($all > 0){$all = mysql_fetch_array($all);}
	$cout_ph = intval($all[0]);
	echo '<div id="formadd"><b>Фотоальбомы</b><div class="formsmall">Всего фотографий: '.$cout_ph.'</div>';
	if($id == $_SESSION['id'])echo "<a class='edit_alb_a' href='profile.php?p=4'>Создать новый альбом</a>";
	echo "</div>";

	
	$alboms_text = "SELECT title,id,text,date,img FROM alboms WHERE id_user='$id' ORDER BY id DESC";
	$albom_arr = mysql_query($alboms_text);
	if($albom_arr)
		$albom = mysql_fetch_array($albom_arr);
	$i = 0;
	do{
		if($albom['title']){
			//количество фоток в альбоме
			$result00 = mysql_query("SELECT COUNT(*) FROM photos WHERE albom='".$albom['date']."' AND id_user='$id'");
			$temp = mysql_fetch_array($result00);
			$count = $temp[0];
			//
			echo "<div class='albom_div_all'><div id='alb".$albom['id']."' class='min'>";
			echo "<div class='border_albom_photo' onclick=\"all_albom(".$albom['id'].");\">";
			$title = mb_substr($albom['title'], 0, 20, "utf-8");
			if($albom['img'] && is_file("../../".$dir_profile."photos/".$albom['date']."/mini".$albom['img'].".jpg"))
				echo "<img src='".$dir_profile."photos/".$albom['date']."/mini".$albom['img'].".jpg' class='albom_img'>";
			else
				echo "<div class='albom_img'></div>";
			echo "</div>";
			echo "<div class='title_albom_block'  onclick=\"all_albom(".$albom['id'].");\">".$title."<br><span class='countPhoto'>".$count." фото</span></div>";
			echo "</div></div>";
		}
	$i++;
	}while($albom = mysql_fetch_array($albom_arr));
	//считаем сколько фоток еще надо подгрузить
	if($i <5)
		$limit = 16;
	else if($i < 10)
		$limit = 12;
	else if($i < 15)
		$limit = 12;
	else if($i < 20)
		$limit = 8;
	else if($i < 25)	
		$limit = 4;
	?>
	<h3 class='last_photo'>Последние загруженные фотографии</h3>
	<?
	if($limit > 0){
		//добавляем несколько фоток последних загруженных
		$miniphoto_text = "SELECT id,photo,albom FROM photos WHERE id_user='$id' ORDER BY id DESC LIMIT $limit";
		$miniphoto_arr = mysql_query($miniphoto_text);
		if($miniphoto_arr)
			$miniphoto = mysql_fetch_array($miniphoto_arr);
		do{
			if($miniphoto['id'] > 0 && is_file("../../".$dir_profile."photos/".$miniphoto['albom']."/mini".$miniphoto['photo'].".jpg")){
				echo "<div class='mini_albom_ph' onclick=\"viewOn(".$miniphoto['albom'].",'".$miniphoto['id']."');\"><img src='".$dir_profile."photos/".$miniphoto['albom']."/mini".$miniphoto['photo'].".jpg' class='mini_img_photo_ph'></div>";
			}
		}while($miniphoto = mysql_fetch_array($miniphoto_arr));
	}
}
?>