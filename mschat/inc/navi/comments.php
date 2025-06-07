<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../../common.php");
require_once("../../connect.php");

$my_id = $_SESSION['id'];
// постраничная навигация
$num = 10;
// Форма отправки комментов 

// Извлекаем из URL текущую страницу
@$page = intval($_GET['p']);
@$id = intval($_GET['id']);
$result00 = mysql_query("SELECT COUNT(*) FROM comments WHERE komu='$id'");
$temp = mysql_fetch_array($result00);
$posts = $temp[0];
$total = (($posts - 1) / $num) + 1;
$total =  intval($total);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;

$pervpage = "";
$nextpage = "";

if ($page != 1) {
	$pervpage = "<li><a  onclick='goPage(\"".($page-1)."\");'>&laquo;</a></li>";
}

if ($page != $total) {
	$nextpage = "<li><a onclick='goPage(\"".($page+1)."\");'>&raquo;</a></li>";
}

if ($page - 3 > 0) {
	$page3left = "<li ><a onclick='goPage(\"".($page - 3)."\");'>".($page - 3)."</a></li>";
}
if ($page - 2 > 0) {
	$page2left = "<li ><a onclick='goPage(\"".($page - 2)."\");'>".($page - 2)."</a></li>";
}
if($page - 1 > 0) {
	$page1left = "<li ><a onclick='goPage(\"".($page - 1)."\");'>".($page - 1)."</a></li>";
}
if($page + 3 <= $total) {
	$page3right = "<li ><a onclick='goPage(\"".($page + 3)."\");'>".($page + 3)."</a></li>";
}
if($page + 2 <= $total) {
	$page2right = "<li ><a onclick='goPage(\"".($page + 2)."\");'>".($page + 2)."</a></li>";
}
if($page + 1 <= $total) {
	$page1right = "<li ><a onclick='goPage(\"".($page + 1)."\");'>".($page + 1)."</a></li>";
}

// Выбираем $num сообщений начиная с номера $start
$comm = mysql_query("SELECT id,kto,komu,time,text FROM comments WHERE komu='$id' ORDER BY id DESC LIMIT $start, $num");
echo "<div id='all_comments_new'>";
if($comm)$com = mysql_fetch_array($comm);
else
	exit("<div class='comNo'>Здесь еще никто ничего не писал</div>");
do{
	$user_id = $com['kto'];
	//достаем данные
	$prof = getFile($user_id); //с файла
	//с базы
	$profile_sql = "SELECT id,sex,admin,photo,login,online,name,fname FROM users WHERE id='$user_id'";
	$profile_mysql = mysql_query($profile_sql);
	$profile = mysql_fetch_array($profile_mysql);
	//
	$dir_profile = "users/".floor($user_id/1000).'/'.$user_id."/";
	if($profile['photo'])
		$photo = $dir_profile."/photos/1/makro".$profile['photo'];
	else
		$photo = $image_url."nophotomakro.jpg";
	$data = date("d.m.Y в H:i", $com['time']);
	
	$text = preg_replace("/(\n){2,}/", "<br/><br/>", $com['text']);
	$text = nl2br($text);
	$text = addurl($text);
	$text = str_replace("[plus]","+",$text);
	//сколько лайков
	$likecom = $com['id'];
	$likes = mysql_query("SELECT COUNT(*) FROM likesCom WHERE com='$likecom'");
	if($likes > 0){$likes = mysql_fetch_array($likes);}
	if($likes[0] > 0) {$cout_likes = $likes[0];}else{$cout_likes = '';}
	//есть ли мой лайк
	$prov_sql = "SELECT id FROM likesCom WHERE kto='$my_id' and com='$likecom' LIMIT 1";
	$prov_mysql = mysql_query($prov_sql);
	$prov = mysql_fetch_array($prov_mysql);
	if($prov['id'] > 0)
		$mylike = 1;
	else
		$mylike = 0;
	
	$profile_sql2 = "SELECT login FROM users WHERE id='$id'";
	$profile_mysql2 = mysql_query($profile_sql2);
	$profile2 = mysql_fetch_array($profile_mysql2);
	?>
	<div class='comAll' id="del<?=$likecom;?>">
		<div class='comAva'>
			<a href="id<?=$user_id;?>"><img src="<?=$photo;?>" border="0" alt="<?=$profile['login'];?> <?=$prof['name'];?> <?=$prof['fname'];?>" class="avamincomm"></a>
			<div class="comOnline"><? if($profile['online'])echo"Online"; ?></div>
		</div>
		<div class='comEnt'>
			<div class="comCom">
				<div class="comLogin">
					<a href="id<?=$user_id;?>"><?=$profile['login'];?></a> <span><? if($profile['name'] || $profile['fname']) echo "(";?><?=$profile['name'];?> <?=$profile['fname'];?><? if($profile['name'] || $profile['fname']) echo ")";?></span>
					<span class="comName"><? if($prof['name'] || $prof['fname']) echo "(";?><?=$prof['name'];?> <?=$prof['fname'];?><? if($prof['name'] || $prof['fname']) echo ")";?></span>
					<? if(($profile['login'] == $_SESSION['login'] || $profile2['login'] == $_SESSION['login'] || $_SESSION['admin'])&&$_SESSION['login']){?><div class="comDelete pointer"><img src="<?=$image_url;?>closeMini.png" onClick="deleteCom('<?=$likecom;?>')" title="Удалить"></div><?}?>
				</div>
				<div class='comText'><?=$text;?></div>
				<div class="comDate">
					Отправлено: <?=$data;?>
					<div class="like <?if($_SESSION['login']){?>pointer like2<?}?>" onclick="<? echo ($mylike)?"nolike" : "like";?>('<?=$likecom;?>')"><img src="<?=$image_url;?><? echo ($mylike)?"unlike" : "like";?>.png" border="0" alt="Нравится" title="<? echo ($mylike)?"Уже не нравится" : "Нравится";?>"></div>
					<div class='likes'><? if($mylike) echo "<b>".$cout_likes."</b>"; else echo $cout_likes;?> </div>
				</div>
			</div>
		</div>
	</div>
	<?
}while($com = mysql_fetch_array($comm));
if($admin) echo 1;
?>
<? if($total > 1){?>
	<div class="pagination" id="navComm">
	  <ul>
		<?=$pervpage;?>

		<?=$page3left;?>
		<?=$page2left;?>
		<?=$page1left;?>
		
		<?=$page1right;?>
		<?=$page2right;?>
		<?=$page3right;?>
		<?=$nextpage;?>
	  </ul>
	</div>
<?}?>
</div>


