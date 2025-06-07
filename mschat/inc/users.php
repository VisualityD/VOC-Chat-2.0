<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../common.php");
require_once("../connect.php");

$where = "activ='1' AND ban='0'";
$order = "online DESC, photo DESC";

//пол
if($_GET['sex'] == 1)
	$where .= " AND sex='1'";
else if($_GET['sex'] == 2)
	$where .= " AND sex='2'";

//Страна
if(isset($_GET['land']) && $_GET['land'] != "0"){
	$land = hts("land");
	$where .= " AND land='$land'";	
}
//город
if(isset($_GET['city']) && $_GET['city'] != ""){
	$city = hts("city");
	$where .= " AND city='$city'";	
}
//онлайн
if(isset($_GET['o']) && $_GET['o'] != 0){
	$where .= " AND online='1'";	
}

//С фото
if(isset($_GET['ph']) && $_GET['ph'] != 0){
	$where .= " AND photo > '0'";	
}
//семейное положение
if(isset($_GET['sp']) && $_GET['sp'] != 0){
	$sp = hts('sp');
	$where .= " AND sp='$sp'";	
}

	
//поиск по строке поиска
if(isset($_GET['name']) && $_GET['name'] != ""){
	$name = hts('name');
	$name = explode(" ", $name);
	
	if(count($name) > 5)
		$count = 5;
	else
		$count = count($name);
	
		
	//login
	$where .= " AND ((";
	for($i = 0; $i<$count; $i++){
		if($i>0) $where .= " OR ";
		$where .= "login='".$name[$i]."'";
	}
	$where .= ")";
	
	
	//fname
	$where .= " OR (";
	for($i = 0; $i<$count; $i++){
		if($i>0) $where .= " OR ";
		$where .= "fname='".$name[$i]."'";
	}
	$where .= ")";
	
	//name
	$where .= " OR (";
	for($i = 0; $i<$count; $i++){
		if($i>0) $where .= " OR ";
		$where .= "name='".$name[$i]."'";
		
		//похожие имена для умного поиска
		$names = File($data_dir."names.dat");
		for($j=0;$j<count($names);$j++){
			$nam = explode("|",$names[$j]);
			
			for($k=0;$k<count($nam);$k++){
				if(trim($nam[$k]) == mb_strtolower($name[$i], "utf-8")){
					$add_name_i = $j; 					
					break;
				}
			}
			
		}
		if($add_name_i>0){
			$names = explode("|",$names[$add_name_i]);
			for($l=0;$l<count($names);$l++){
				if($names[$l] != $name[$i] && $names[$l] != ""){
					$where .= " OR name='".$names[$l]."'";
				}
			}
		}
		/////
	}
	$where .= "))";
}
//echo $where;

//постраничная навигация
@$page = intval($_GET['p']);
$num = 20;
$result00 = mysql_query("SELECT COUNT(*) FROM users WHERE $where ORDER BY $order");
$temp = mysql_fetch_array($result00);
$posts = $temp[0];
$total = (($posts - 1) / $num) + 1;
$total =  intval($total);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;
if ($page != 1) 
	$pervpage = "<u onclick='page(".($page-1).");'><< Предыдущая</u>";

if ($page != $total) 
	$nextpage = "<u onclick='page(".($page+1).");'>Следующая >></u>";

////////////////////////////

$all_sql = "SELECT id,login,sex,land,city,photo,bday,online,name,fname FROM users WHERE $where ORDER BY $order LIMIT $start, $num";
$all_mysql = mysql_query($all_sql);
if($all_mysql)$all = mysql_fetch_array($all_mysql);
if($all)
do{
	$id_user = $all['id'];
	//вынимаем с файла данные
	/*$inc = 1;
	$prof = getFile($id_user);*/
	
	$dir_profile = "users/".floor($id_user/1000).'/'.$id_user."/";
	if($all['photo'])
		$ava = $conf['url'].$dir_profile."photos/1/mini".$all['photo'];
	else
		$ava = $image_url."nophotomakro.jpg";
	//получаем возраст человека
	$vozrast = vozrast($all['bday']);
	if($all['city'])
		$vozrast = ", ".$vozrast;
?>
	<div class="user">
		<div class="photo" style="background-image: url('<?=$images_url."nophotomakro.jpg";?>');"><a href="id<?=$id_user;?>"><img src="<?=$ava;?>" border=0></a></div>
		<p><a href="id<?=$id_user;?>"><?=$all['login'];?></a> <span><? if($id_user == $_SESSION['id']) echo "Это вы"; else if($all['online']) echo "Online";;?></span></p>
		<p class="name"><?=$all['name'];?> <?=$all['fname'];?></p>
		<p class="other"><? if($all['land']){?><img src="land/<?=$all['land'];?>.png"><?}?> <font title="Возраст"><?=$all['city'].$vozrast;?></font></p>
	</div>
	<div class='hr'></div>
<?}while($all = mysql_fetch_array($all_mysql));
else{
	echo "<br><br><br><center>Ничего не найдено. <br><br>Проверте все критерии поиска и попробуйте снова. <br> (возможно вы забыли очистить ненужное поле)</center>";
	exit;
}
echo "<div class='pages'>".$pervpage;
echo $nextpage."</div>";
?>
