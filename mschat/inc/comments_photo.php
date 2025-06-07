<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../common.php");
$my_id = $_SESSION['id'];
// постраничная навигация
$num = 10;
// Форма отправки комментов 

// Извлекаем из URL текущую страницу
$photo = intval($_GET['photo']);
@$id = intval($_GET['id']);
@$page = intval($_GET['page']);

$result00 = mysql_query("SELECT COUNT(*) FROM photocomments WHERE komu='$id' AND id_photo='$photo'");
$temp = mysql_fetch_array($result00);
$posts = $temp[0];
$total = (($posts - 1) / $num) + 1;
$total =  intval($total);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;

// Выбираем $num сообщений начиная с номера $start
$comm = mysql_query("SELECT id,kto,komu,time,text FROM photocomments WHERE komu='$id' AND id_photo='$photo' ORDER BY id DESC LIMIT $start, $num");

if($comm)$com = mysql_fetch_array($comm);
else
	exit;
?>
<? if($page != $total){?>
<div class='navi_comm_photo_verh' onclick='goPhotoComm("<?=($page+1);?>");'>
	<div class='pointer'>Предыдущая комментарии</div>
</div>
<?}
$i = 0;
do{
	$user_id = $com['kto'];
	//достаем данные
	$prof = getFile($user_id); //с файла
	//с базы
	$profile_sql = "SELECT id,sex,admin,photo,login,online FROM users WHERE id='$user_id'";
	$profile_mysql = mysql_query($profile_sql);
	$profile = mysql_fetch_array($profile_mysql);
	$del_id = $com['id'];
	//
	$dir_profile = "users/".floor($user_id/1000).'/'.$user_id."/";
	if($profile['photo'])
		$photo = $dir_profile."/photos/1/makro".$profile['photo'];
	else
		$photo = $image_url."nophotomakro.jpg";
	$data = date("d.m.Y в H:i", $com['time']);
	
	$text = $com['text'];
	$text = nl2br($text);
	$text = addurl($text);
	
	$profile_sql2 = "SELECT login FROM users WHERE id='$id'";
	$profile_mysql2 = mysql_query($profile_sql2);
	$profile2 = mysql_fetch_array($profile_mysql2);
	$vivod[$i] = " 
		<div class='";
		if(($profile['login'] == $_SESSION['login'] || $profile2['login'] == $_SESSION['login'] || $_SESSION['admin']) && $_SESSION['id'])
			$vivod[$i] .= "comPhotoDel";
		$vivod[$i] .= "' id='delp".$del_id."'>
			<div class='comAvaPhoto'>
				<a href='id".$user_id."'><img src='".$photo."' border='0' alt='".$profile['login']." ".$prof['name']." ".$prof['fname']."' class='avamincommPhoto'></a>
				<div class='comOnlinePhoto'>";
		if($profile['online']) $vivod[$i] .= "Online";
		$vivod[$i] .= "</div>
			</div>
			<div class='comEntPhoto'>
				<div class='comComPhoto'>
					<div class='comLoginPhoto'>
						<a href='id".$user_id."' class='bold_url'>".$profile['login']."</a> <span class='comDatePhoto'>".$data."</span>
						<span class='comName'>";
		if($prof['name'] || $prof['fname']) $vivod[$i] .= "(";
		$vivod[$i] .= $prof['name']." ".$prof['fname'];
		if($prof['name'] || $prof['fname']) $vivod[$i] .= ")";
		$vivod[$i] .= "</span>";
		if(($profile['login'] == $_SESSION['login'] || $profile2['login'] == $_SESSION['login'] || $_SESSION['admin']) && $_SESSION['id'])
			$vivod[$i] .= "<div class='comDeletePhoto pointer' onClick=\"deletePhotoComm('".$del_id."')\" title='Удалить'></div>";
		$vivod[$i] .= "</div>
					<div class='comTextPhoto'>".$text."</div>
				</div>
			</div>
		</div>
	<div class=\"hrphoto\"></div>";
	$i++;
}while($com = mysql_fetch_array($comm));

for(;$i>=0; $i--)
	echo $vivod[$i];
if($page != 1){?>
	<div class='navi_comm_photo_niz' onclick='goPhotoComm("<?=($page-1);?>");'>
		<div class='pointer'>Следующие комментарии</div>
	</div>
<?}
?>

<script>
$id('comments_photo').scrollTop = 9999;
</script>



