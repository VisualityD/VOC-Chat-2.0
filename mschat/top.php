<?
if(!isset($prof_my)){
	$prof_my = getFile($_SESSION['id']);
}
//из базы
$my = "SELECT photo FROM users WHERE id='".$_SESSION['id']."'"; 
$my_sql = mysql_query($my);
$my = mysql_fetch_array($my_sql);

if(strlen($my['photo']) > 1) {
	$photo = "../users/".floor($_SESSION['id']/1000).'/'.$_SESSION['id']."/photos/1/makro".$my['photo'];
} else {
	$photo = $image_url."nophoto.png";
}
if(!is_file($photo)){
	if(!@is_file("../".$photo)){
		$photo = "../".$photo;
	}else{
		$photo = $image_url."nophoto.png";
	}
}
$photo = str_replace("../http","http", $photo);


$my_prof = getFile($_SESSION['id']);
//сколько людей в чате
$all = mysql_query("SELECT COUNT(*) FROM users WHERE online='1' or sex='0'");
if($all > 0){$all = mysql_fetch_array($all);}
if($all[0] > 0) {$cout_users = $all[0];}
?>
	<div id="l_line">
		<div id="l_linein">
			<?if($connect){?>
			<div id="l_myprofile">
				<div class="l_cat_min">
					<a href="<?php echo $conf['url']; ?>id<?=$_SESSION['id'];?>" class="l_a"><img src="<?=$photo;?>" alt="<?=$_SESSION['login'];?>" border="0" id="l_img"></a>
				</div>
				<div class="l_cat_min l_prof">
					<div class="br"></div>
					<a href="<?php echo $conf['url']; ?>id<?=$_SESSION['id'];?>" class="login"><?=$_SESSION['login'];?></a>
					<div class='l_min_menu'>
						<div class='l_min_cat l_min_sett' title="Настройки" onclick="location.href='profile.php'"></div>
						<div class='l_min_cat l_min_mes' title="Сообщения" onclick="location.href='ls.php'"></div>
						<div class='l_min_cat l_min_rss' title="Новости"></div>
					</div>					
				</div>
				<!-- категория 
				<div class="l_vert"></div>-->
				<div class="<? if($top == 1) echo "l_avtive"; else echo "l_cat";?>" onclick="location.href='<?php echo $conf['url']; ?>chat.php'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/chat.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Чат</span><br>
						<span class="l_a_min"><?=$cout_users;?> чел.</span>
					</div>
				</div>
				<!-- конец категории -->
							
				<!-- категория -->
				<div class="l_vert"></div>
				<div class="<? if($top == 2) echo "l_avtive"; else echo "l_cat";?>"  onclick="location.href='<?php echo $conf['url']; ?>shop.php'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/shop.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Магазин</span><br>
						<span class="l_a_min"><span id='mon1'><?=$my_prof['money'];?></span><?=$lang['shop_money'];?></span>
					</div>
				</div>
				<!-- конец категории -->
				
				<!-- категория -->
				<div class="l_vert"></div>
				<div class="<? if($top == 3) echo "l_avtive"; else echo "l_cat";?>"  onclick="location.href='<?php echo $conf['url']; ?>bank.php'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/bank.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Банк</span><br>
						<span class="l_a_min">1:<?=$tarif['obmen'];?></span>
					</div>
				</div>
				<!-- конец категории -->
				
				<!-- категория -->
				<div class="l_vert"></div>
				<div class="<? if($top == 4) echo "l_avtive l_cat"; else echo "l_cat";?>" onclick="location.href='<?php echo $conf['url']; ?>all.php'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/pep.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Люди</span><br>
						<span class="l_a_min">поиск</span>
					</div>
				</div>
				<!-- конец категории -->
				
				<!-- категория -->
				<div class="l_vert"></div>
				<div class="l_cat"  onclick="location.href='<?php echo $conf['url']; ?>exit.php'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/exit.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Выход</span><br>
						<span class="l_a_min"></span>
					</div>
				</div>
				<!-- конец категории -->
				
			</div>
		<?}else{?>	
				
				<!-- категория -->
				<div class="l_vert"></div>
				<div class="<? if($top == 1) echo "l_avtive"; else echo "l_cat";?>"  onclick="location.href='<?php echo $conf['url']; ?>index.php'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/login.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Авторизация</span><br>
						<span class="l_a_min">Вход</span>
					</div>
				</div>
				<!-- конец категории -->
				
				<!-- категория -->
				<div class="l_vert"></div>
				<div class="<? if($top == 2) echo "l_avtive"; else echo "l_cat";?>"  onclick="location.href='<?php echo $conf['url']; ?>regestration.php'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/reg.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Регистрация</span><br>
						<span class="l_a_min">Создать страницу</span>
					</div>
				</div>
				<!-- конец категории -->
				
				<!-- категория -->
				<div class="l_vert"></div>
				<div class="<? if($top == 2) echo "l_avtive"; else echo "l_cat";?>"  onclick="location.href='<?php echo $conf['url']; ?>pages/statistic.php?msgs'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/st.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Статистика</span><br>
						<span class="l_a_min">Логи</span>
					</div>
				</div>
				<!-- конец категории -->
				<!-- категория -->
				<div class="l_vert"></div>
				<div class="<? if($top == 4) echo "l_avtive l_cat"; else echo "l_cat";?>" onclick="location.href='<?php echo $conf['url']; ?>all.php'">
					<div class="l_cat_min"><img src='<?=$image_url?>tw/pep.png' class="l_img_cat"></div>
					<div class="l_cat_min">
						<div class="br"></div>
						<span class="l_a">Люди</span><br>
						<span class="l_a_min">поиск</span>
					</div>
				</div>
				<!-- конец категории -->
				
		<?}?>
		</div>
	</div>
	<!-- Конец черной линии -->