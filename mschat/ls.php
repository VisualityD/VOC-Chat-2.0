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
$my_id = $_SESSION['id'];
//Статус где пользователь
$prof['on'] = 4;
setFile($_SESSION['id'],$prof);
?>
<!DOCTYPE html>
<html>
  <head>
	<script type="text/javascript" src="js/xmlhttprequest.js"></script>
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>ls.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	
	<title>Сообщения | <?=$conf['chatname'];?></title>
	<? include("copy_image.php");?>
</head>
<body>
<? include("top.php");?>	
	<div id="main">
		<div id="m_left">
			<div class="m_top">Собеседники</div>
				<?php
				$arr_ids = array();
				$sql_text = "SELECT pol,otp,time,id FROM ls WHERE (pol='$my_id' AND delpol='0') OR (otp='$my_id' AND delotp='0') ORDER BY view DESC,id DESC";
				$users_arr = mysql_query($sql_text);
				if($users_arr)
					$users = mysql_fetch_array($users_arr);
				if($users)
					do{
					
					//вынимаем данные пользователя
					if($users['pol'] != $my_id)
						$id_user = $users['pol'];
					else
						$id_user = $users['otp'];
						
					foreach($arr_ids as $val_id){
						if($val_id == $id_user)
							goto end;
					}
					
					
					$arr_ids[] = $id_user;
					
					$sql_text = "SELECT login,online,photo FROM users WHERE id='$id_user' LIMIT 1";
					$sql = mysql_query($sql_text);
					if($sql)
						$mysql = mysql_fetch_array($sql);
					
					if(strlen($mysql['photo']) > 1)
						$photo = "users/".floor($id_user/1000).'/'.$id_user."/photos/1/makro".$mysql['photo'];
					else
						$photo = $image_url."nophoto.png";
					if(!is_file($photo))
						$photo = $image_url."nophoto.png";
						
					//кол сообщений
					$count_mess = countSql("SELECT COUNT(*) FROM ls WHERE pol='$my_id' AND otp='$id_user' AND delpol='0' AND view='1'");
					?>
			<div class="user">
				<?php if($count_mess){?>
					<p class="count"><?=$count_mess;?></p>
				<?}else{?>
					<p class="no_count"></p>
				<?}?>
				<img src="<?=$photo;?>">
				<strong><?=$mysql['login'];?></strong>
				<span><?=date("d.m.Y в H:i",$users['time']);?></span>
			</div>
				<?
				end:
				}while($users = mysql_fetch_array($users_arr));
			else
				echo "<p class='no_users'>Здесь будут собеседники как только Вы или Вам напишут личное сообщение.</p>";
			?>				
		</div>		
		<div id="m_right">
			<div class="m_top">Диалоги</div>
			<!---->
				<div class="ls_top"></div>
				<div id="chat">

					<div class="mes_right view">
						<div>
						Привет как дела? Личные сообщения пока еще не работают на этом сайте, но мы уже занимаемся ими и скоро все заработает.
						<p class="qr"></p>						
						</div>
						<span>12.12.2004 в 13:33</span>
					</div>
					
					<div class="mes_left view">
						<div>
						Хорошо, спасибо!
						<p class="ql"></p>						
						</div>
						<span>12.12.2004 в 13:33</span>
					</div>
					
					<div class="mes_right">
						<div>
						Извините за неудобства
						<p class="qr"></p>						
						</div>
						<span>12.12.2004 в 13:33</span>
					</div>
					
					<div class="mes_left">
						<div>
						Все хорошо, классный сайт!						
						<p class="ql"></p>						
						</div>
						<span>12.12.2004 в 13:33</span>
					</div>

					
					<div class="mes_right">
						<div>
						Спасибо! Заходи каждый день!
						<p class="qr"></p>						
						</div>
						<span>12.12.2004 в 13:33</span>
					</div>
					
				</div>				
				<div class="ls_bottom">
					<div id="editor" contenteditable="true"></div>
					<button class="btn btn-info" id="butt">Отправить</button>
				</div>
			<!---->
			
		</div>		
	</div>
	
	<!--//// Контейнера ////--->
	<input type="hidden" value="<?=$image_url;?>" id="image_url">
	<script type="text/javascript" src="js/nophp.js"></script>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
	<script type="text/javascript" src="js/all.js"></script>
	<script>
		
	function reSkroll(){
		var height = (parseInt($('body').css('height')) - parseInt($('#l_line').css('height')) - parseInt($('.ls_top').css('height')) - parseInt($('.ls_bottom').css('height')) - 28);
		$("#chat").animate({height: height+"px"}, 0);
		setTimeout('$("#chat").animate({scrollTop: 2000}, "slow");', 1);
	};
	reSkroll();
	var resizeTimer = null;
	$(window).bind('resize', function() {
		if (resizeTimer) clearTimeout(resizeTimer);
		resizeTimer = setTimeout(reSkroll, 100);
	});
	</script>
</body>
</html>