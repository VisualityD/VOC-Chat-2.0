<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
$prof = getFile($_SESSION['id'],1);//Вынимаем данные пользователя
//из базы
$my = "SELECT photo FROM users WHERE id='".$_SESSION['id']."'"; 
$my_sql = mysql_query($my);
$my = mysql_fetch_array($my_sql);
//Статус где пользователь
$prof['on'] = 2;
setFile($_SESSION['id'],$prof);
?>
<!DOCTYPE html>
<html>
  <head>	
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>shop.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>chat.css" type="text/css" />
	
	<title>Магазин | <?=$conf['chatname'];?></title>
	<? include("copy_image.php");?>
</head>
<body>
<?
$top = 2;
 include("top.php");?>	
	<div id="main">
		<div id="m_left">
			<div class="m_top">Категории</div>
			<a class="p_menu" onclick="openMenu(1)">Для чата</a>
				<div id="menu_1" class="menu_in">
					<a class="pod_menu" onclick="loadMenu(1,1)">Палитры цветов</a>
					<a class="pod_menu" onclick="loadMenu(1,2)">Стили</a>
					<a class="pod_menu" onclick="loadMenu(1,3)">Шрифты</a>
					<a class="pod_menu" onclick="loadMenu(1,4)">Эффекты</a>
				</div>
			<a class="p_menu" onclick="openMenu(2)">Профиль</a>
				<div id="menu_2" class="menu_in">
					<a class="pod_menu" onclick="loadMenu(2,1)">Обложки</a>
					<a class="pod_menu" onclick="loadMenu(2,2)">Обои</a>
				</div>
		</div>		
		<div id="m_right">
			<div class="m_top">У Вас <span id='mon2'><?=$prof['money'];?></span> Монет</div>
			
			<div id="shop_load">
				<!--Оформление-->
				<div id="shop_title">
					<h1>
						Магазин
					</h1>
					<img src='<?=$image_url;?>shop/stak.png' alt='Магазин'>
					<p style="text-align:center;">Выбирите слева категорию для просмотра или приобретения товара.</p>
				</div>
			</div>
			
		</div>		
	</div>
	<div id="status"></div>
	<script type="text/javascript" src="js/xmlhttprequest.js"></script>
	<script type="text/javascript" src="js/nophp.js"></script>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
	<script type="text/javascript" src="js/all.js"></script>
	<script type="text/javascript" src="js/shop.js"></script>
	<script>
	//подгружаем
	//$("#shop_load").load('inc/shop.php?c='+1);
	</script>
	<!--//// Контейнера ////--->
	<input type="hidden" value="<?=$image_url;?>" id="image_url">
	<? include("copy.php");?>
</body>
</html>