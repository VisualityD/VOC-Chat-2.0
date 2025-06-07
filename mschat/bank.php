<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
$prof = getFile($_SESSION['id']);//Вынимаем данные пользователя
//из базы
$my = "SELECT photo FROM users WHERE id='".$_SESSION['id']."'"; 
$my_sql = mysql_query($my);
$my = mysql_fetch_array($my_sql);
//обновляем что пользователь в банке
$profS = getFile($_SESSION['id']);
$profS['on'] = 4;
setFile($_SESSION['id'],$profS);
if(isset($_POST['monet']) && $_POST['monet'] > 0){
	$money = intval($_POST['monet']);
	if($money*$tarif['obmen'] > $prof['point'])
		$st = "У Вас недостаточно поинтов.";
	else{
		$prof['point'] -= $money*$tarif['obmen'];
		$prof['money'] += $money;
		setFile($_SESSION['id'],$prof);
		$st = "Обмен удачно выполнен!";
		$profS = getFile($_SESSION['id']); //обновляем данные
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>bank.css" type="text/css" />
	<title>Банк | <?=$conf['chatname'];?></title>
	<? include("copy_image.php");?>
</head>
<body>
<? 
$top = 3;
include("top.php");?>
	<div id="main">
		<div id="m_left">
			<div class="m_top">Категории</div>
			<a class="p_menu" href="bank.php?n=1">Обмен валют</a>
			<!--<a class="p_menu" href="bank.php?n=1">Пополнить</a>
			<a class="p_menu" href="bank.php?n=1">Статистика</a>
			<a class="p_menu" href="bank.php?n=1">Кредит</a>-->
		</div>		
		<div id="m_right">
			<div class="m_top">Банк</div>
			<div class="str2">
				У Вас <b><?=$prof['point'];?></b> поинт, <?=intval($prof['money']);?> монет.<br><br>
				Курс обмена 1 монета = <?=$tarif['obmen'];?> поинтов.
				<br><br>
				<form action="bank.php?n=1" method="post">
					<?php
						//вычисляем максимальный обмен
						$val = intval($prof['point']/$tarif['obmen']);
					?>
					<div class="str">
						Получить монет: 
						<input type="text" value="<?=$val;?>" name="monet" class='obm'>
						<button class='btn btn-info'>Обменять</button>
						<br>
						<br>
						Вы можете получить: <strong><?=$val;?></strong> монет
					</div>
					<div class="st"><?=$st;?></div>
				</form>
			</div>
		</div>
		
	</div>
	<script type="text/javascript" src="js/xmlhttprequest.js"></script>
	<script type="text/javascript" src="js/nophp.js"></script>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
	<script type="text/javascript" src="js/all.js"></script>
	<? include("copy.php");?>
</body>
</html>