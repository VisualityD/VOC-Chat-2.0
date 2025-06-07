<?
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
//Статус где пользователь
$profS = getFile($_SESSION['id']);
$profS['on'] = 3;
setFile($_SESSION['id'],$profS);
$myid = $_SESSION['id'];
$id_user = intval($_GET['id']);
if(!$id_user && $_SESSION['id'])
	go("id".$_SESSION['id']);
if(!$id_user && !$_SESSION['id'])
	go("index.php");
//достаем данные с файла
$prof = getFile($id_user);
//с базы
$profile_sql = "SELECT id,mail,bday,sex,admin,photo,land,city,login,online,onlinetime,sp,name,fname FROM users WHERE id='$id_user'";
$profile_mysql = mysql_query($profile_sql);
$profile = mysql_fetch_array($profile_mysql);
$bday = explode(".",$profile['bday']);
//пути
$dir_profile = "users/".floor($id_user/1000).'/'.$id_user."/";
$my_dir_profile = "users/".floor($_SESSION['id']/1000).'/'.$_SESSION['id']."/";

//получаем размеры авы
if(strlen($profile['photo'])>3 && is_file($dir_profile."photos/1/ava".$profile['photo'])){
	$ava = $dir_profile."photos/1/ava".$profile['photo'];
	$avaSize = @getimagesize ($ava);
	if($avaSize[0] > $avaSize[1])
		$ava = $dir_profile."photos/1/mini".$profile['photo'];
	$avaSize = @getimagesize ($ava);
	$margin_top = $conf['photoava']+3 - $avaSize[1];
	$margin_left = ($conf['photoava'] - $avaSize[0])/2-18;
}
//день рождения
if($bday[0] and $monath[$bday[1]])
	$btday = $bday[0]." ".$monath[$bday[1]];
if($bday[2])
	$btday .= " ".$bday[2];
$proc = 0;
?>
<!DOCTYPE html>
<html>
  <head>
	<script type="text/javascript" src="js/xmlhttprequest.js"></script>
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>user.css" type="text/css" />
	<title><?=$profile['login'];?> | <?=$profile['name'];?> <?=$profile['fname'];?> --- Профиль пользователя</title>
	<? include("copy_image.php");?>
	<? if(strlen($prof['fon'])>0){?>
	<style>
		html{
			background-image:url('fon/<?=$prof['fon'];?>');
		}
	</style>
	<?}?>
</head>
<body>
<div id="body2">
<? include("top.php");?>
<div id="white_main3" class="white_main1">
	<div id="main">
		<div id="m_left">
			<div class="m_top">Навигация</div>
				<?php include("menu.php");?>
			<div id="mini_alboms">

			</div>
			<!--<div id="div_big_bottom">
				<button class="butt big_bottom">Добавить в друзья</button>
				<button class="butt big_bottom">Отправить письмо</button>
			</div>-->
		</div>		
		<div id="m_right">
			<div class="m_top m_top_right">
				<div class='online' ><? if($id_user == $_SESSION['id']) echo "Это вы"; else if($profile['online']) echo "Online"; else echo date("Последний визит: d.m в H:i",$profile['onlinetime']);?></div>
			</div>
			<!--Фотографии вверху + ава-->
			<div class="top_pictures" style="background-image:url(oboi/<? if($prof['obl']) echo $prof['obl']; else echo 1; ?>.jpg);">
				<style>
				<? 
				if($avaSize[0] > 200){
					$wd = $conf['photoava']-50;
					?>
					#ava{
						margin-left:7px;
						width:<?=$conf['photoava'];?>px;
						height:<?=$conf['photoava'];?>px;
						margin-top:3px;
					}
					#ava img{
						width:<?=$conf['photoava']-50;?>px;
						position:absolute;
						bottom:0;
					}
				<?}else if($avaSize[0] <= $conf['photoava'] || $avaSize[1] <= $conf['photoava']){?>
					#ava{
						width:<?=$avaSize[0];?>px;
						height:<?=$avaSize[1];?>px;
						margin-top:<?=$margin_top;?>px;
						margin-left:<?=$margin_left;?>px;
					}
				<?}else{?>
					#ava{
						width:<?=$conf['photoava'];?>px;
						height:<?=$conf['photoava'];?>px;
						margin-top:3px;
					}
					#ava img{
						width:<?=$conf['photoava'];?>px;
						height:<?=$conf['photoava'];?>px;
					}
				<?}
				?>
				</style>			
				<div class="pictures_left">
					<div class="fon_ava">
						<? if(strlen($ava)>3){
							$proc += 15;?>
							<div class="border_ava" id="ava" onclick="viewOn(1,'<?=$profile['photo'];?>',1);">			
							<img src="<?=$ava;?>">
							</div>
						<?}else{?>
							<img src="<?=$image_url;?>nophoto.jpg" style="margin:60px 30px;" <? if($_SESSION['id'] == $id_user){?>onclick="location.href='profile.php'"<?}?>>
						<?}?>
					</div>
				</div>		
				<div class="pictures_right">
					<div class="pictures_right_top"><?=$profile['login'];?></div>				
					<div class="pictures_right_bottom">
						<?
						$photo = str_replace(".jpg","",$profile['photo']);
						$miniphoto_text = "SELECT id,photo,albom FROM photos WHERE id_user='$id_user' AND photo != '$photo' ORDER BY id DESC LIMIT 4";
						$miniphoto_arr = mysql_query($miniphoto_text);
						if($miniphoto_arr)
							$miniphoto = mysql_fetch_array($miniphoto_arr);
						do{
							if($miniphoto['id'] > 0 && is_file($dir_profile."photos/".$miniphoto['albom']."/mini".$miniphoto['photo'].".jpg")){
								echo "<div class='mini_albom_new' onclick=\"viewOn(".$miniphoto['albom'].",'".$miniphoto['id']."');\"><img src='".$dir_profile."photos/".$miniphoto['albom']."/mini".$miniphoto['photo'].".jpg' class='mini_img_photo_new'></div>";
								$proc += 3;
							}
						}while($miniphoto = mysql_fetch_array($miniphoto_arr));
						?>				
					</div>
					<div id="free_butt">
						<!--<button class="cancel free_butt">Добавить в друзья</button>	-->
						<? if($id_user != $_SESSION['id']){?><button class="cancel free_butt" onclick="newMes()"><i class="icon-envelope"></i> Cообщение</button><?}?>
					</div>					
				</div>
			</div>
			<!--Статус-->
			<? if(strlen($prof['statustext']) > 0){?>
			<div class="status">
				<div id="status_v"></div>
				<? if($prof['imgstatus']){$proc += 3;?><div id="statusimg"><img src='status/<?=$prof['imgstatus'];?>'></div><?}?>
				<div id="statustext"><?=$prof['statustext'];?></div>
			</div>
			<?}?>
			<!--Данные-->
			<div class="block_information">
					
				<? if($profile['name'] || $profile['fname']){
						if(strlen($profile['name'])>2)
							$proc += 10;
						if(strlen($profile['fname'])>2)
							$proc += 10;
					?>
					<div class="cat">
						<div class='inf_left'>Имя и фамилия:</div>
						<div class='inf_right'><b><?=$profile['name'];?>&nbsp;<?=$profile['fname'];?></b></div>
					</div>
				<?} if($btday){
					$proc += 10;?>
					<div class="cat">
						<div class='inf_left'>День рождения:</div>
						<div class='inf_right'><?=$btday;?></div>
					</div>
				<?} if($prof['city'] || $profile['land']){
					$proc += 10;?>
				<div class="cat">
						<div class='inf_left'>Город:</div>
						<div class='inf_right'><?=$profile['city'];?> <? if($profile['land']){?><img src="land/<?=$profile['land'];?>.png"><?}?></div>
					</div>
				<?} if($prof['street']){
					$proc += 5;?>
					<div class="cat">
						<div class='inf_left'>Улица:</div>
						<div class='inf_right'><?=$prof['street'];?></div>
					</div>
				<?} if($profile['sp']){
					$proc += 10;?>
					<div class="cat">
						<div class='inf_left'>Семейное положение:</div>
						<div class='inf_right'>
							<?
							$prof['type_sp'] = 1;
							if($prof['type_sp'] == 1){
								if($profile['sex'] == 2) {						
									$spt[1] = "Влюблена";
									$spt[2] = "Есть парень";
									$spt[3] = "Не замужем";
									$spt[4] = "Разведена";
									$spt[5] = "Замужем";
								}else{						
									$spt[1] = "Влюблен";
									$spt[2] = "Есть девушка";
									$spt[3] = "Не женат";							
									$spt[4] = "Разведен";
									$spt[5] = "Женат";
								}
								$spt[6] = "Все сложно";
								$spt[7] = "Хочу отношений";
								echo $spt[$profile['sp']];
								if(($profile['sp'] == 2 || $profile['sp'] == 5) && $prof['type_sp'] == 1){
									//проверка на взаимность отношений
									$id_partner = getId($prof['partner']);
									$sql_text = "SELECT sp FROM users WHERE id='$id_partner' LIMIT 1";
									$sql = mysql_query($sql_text);
									if($sql){
											$mysql = mysql_fetch_array($sql);
										$prof_sp = getFile($id_partner);
										
										if($mysql['sp'] == $profile['sp'] && ($prof_sp["partner"] == $profile["login"]) /*&& $prof_sp['type_sp'] == $prof['type_sp']*/){
											if($profile['sp'] == 5 && $profile['sex'] == 2) echo " за";
											if($profile['sp'] == 5 && $profile['sex'] == 1) echo " на";
											echo " <a href='id$id_partner'>".$prof['partner']."</a>";
										}
									}
								}
							}?>
							
						</div>
					</div>
				<?} if($prof['icq']){
					$proc += 5;?>
					<div class="cat">
						<div class='inf_left'>ICQ:</div>
						<div class='inf_right'><?=$prof['icq'];?></div>
					</div>
				<?} if($prof['skype']){
					$proc += 5;?>
					<div class="cat">
						<div class='inf_left'>Skype:</div>
						<div class='inf_right'><?=$prof['skype'];?></div>
					</div>
				<?} if($prof['phone']){
					$proc += 5;?>
					<div class="cat">
						<div class='inf_left'>Моб. тел:</div>
						<div class='inf_right'><?=$prof['phone'];?></div>
					</div>
				<?} if($prof['vk']){
					$proc += 5;?>
					<div class="cat">
						<div class='inf_left'>Вконтакте:</div>
						<div class='inf_right'><?=$prof['vk'];?></div>
					</div>
				<?} if($prof['site']){
					$proc += 5;?>
					<div class="cat">
						<div class='inf_left'>Сайт:</div>
						<div class='inf_right'><? echo addurl("http://".$prof['site']);?></div>
					</div>
				<?}?>
				<div class='inf_left'>Страница заполнена:</div>
				<div class='inf_right'>
					<? progress($proc);?>
				</div>
			</div>
			<div id="information" onclick="oninform();">Посмотреть подробную информацию</div>
			<div id="hidden_information">
					<p>Чат</p>
					<? if($prof['countAll'] + $prof['countPrivate']){?>
						<div class="cat">
							<div class='inf_left'>Сообщений всего:</div>
							<div class='inf_right'><?=$prof['countAll'] + $prof['countPrivate'];?></div>
						</div>
					<?} if($prof['countAll']){?>
						<div class="cat">
							<div class='inf_left'>Общих сообщений:</div>
							<div class='inf_right'><?=$prof['countAll'];?></div>
						</div>
					<?} if($prof['countPrivate']){?>
						<div class="cat">
							<div class='inf_left'>Приватных сообщений:</div>
							<div class='inf_right'><?=$prof['countPrivate'];?></div>
						</div>
					<?}?>
				<div id="information_niz"></div>
			</div>
			
			<!--Меню-->
			<?
			//сколько всего комментов
			$all = mysql_query("SELECT COUNT(*) FROM comments WHERE komu='$id_user'");
			if($all > 0){$all = mysql_fetch_array($all);}
			$cout_com = intval($all[0]);
			//сколько всего альбомов
			$all = mysql_query("SELECT COUNT(*) FROM alboms WHERE id_user='$id_user'");
			if($all > 0){$all = mysql_fetch_array($all);}
			$cout_alb = intval($all[0]);
			?>
			<div id="navi_all">
				<div id="nav1" class='n_hover' onclick="navi(1);">Стена <span class="count" id="countCom"><?=$cout_com;?></span></div>
				<div id="nav2" class='navi' onclick="navi(2,1);">Альбомы <span class="count"><?=$cout_alb;?></span></div>
				<!--<div id="nav3" class='navi'>Видео <span class="count">100</span></div>
				<div id="nav4" class='navi'>Подарки <span class="count">134</span></div>
				<div id="nav5" class='navi'>Друзья <span class="count">100</span></div>
				<div id="nav6" class='navi'>Вопросы <span class="count">4002</span></div>-->
			</div>
			<!--Форма комментариев-->
			<div id="h_nav1">
				<?php if($_SESSION['login']){?>
					<div id="formadd">
						<div id="status"></div>
						<textarea name="text" id="formtext" class="formtext" onfocus="onForm();" onblur="offFormTime();">Комментировать...</textarea>					
						<div id="butt"></div>
					</div>
				<?}else{?>
					<div class="red">Что-бы оставить комментарий Вам необходимо <a href="index.php">авторизоваться</a> или <a href="regestration.php">зарегистрироваться</a> если Вы этого еще не сделали.</div>		
				<?}?>
			</div>
			<!--Форма комментариев end-->
			
			<div id="all_comments">
				<div class="u_load"></div>
			</div>
			
		</div>
	</div>
	<? include("copy.php");?>
</div>
<!--lightbox-->
<div id="colorbox" onClick="closeBox()" onmouseover="nextOn('');"></div>
<div id="photoview">
	<div id="closeBoxHidden"><img src="<?=$image_url;?>sw.png" onClick="showRightView()" class="pointer prozr view_top_butt" title="Развернуть комментарии"><img src="<?=$image_url;?>closeMini.png" onClick="closeBox()" class="pointer prozr view_top_butt" title="Закрыть"></div>
	<div id="viev_left" onmouseover="nextOn('1');">
		<div id='prev2' onclick="nextPhoto(1)"></div>
		<div id='next2' onclick="nextPhoto()"></div>
		<div id="photo_view" class="img-holder">
			<img src="" id="viewimg" class="pointer" onclick="nextPhoto()"><!--Фото-->
		</div>
		<div id="nave_view">
			<?if($_SESSION['id']){?><div id="like_photo_butt" onclick="likePhoto()">Нравится</div><?}?>
			<div id="clike_photo_butt" title="Кому понравилось" onclick="openLikesPhoto()">&nbsp;</div>
			
		</div>
	</div>		
	<div id="view_right" onmouseover="nextOn('');">
		<div id="closeBox"><img src="<?=$image_url;?>rw.png" onClick="closeRightView()" class="pointer prozr view_top_butt" title="Скрыть комментарии"><img src="<?=$image_url;?>closeMini.png" onClick="closeBox()" class="pointer prozr view_top_butt" title="Закрыть"></div>
		<div id="view_author_text">
			<div class="viev_author"><img src="<?=$dir_profile."photos/1/makro".$profile['photo'];?>" class="img_user" width="45"></div>
			<div class="viev_name comLogin"><a href="id<?=$id_user;?>"><?=$profile['login'];?></a> <? if($profile['name'] || $profile['fname']) echo "(";?><?=$profile['name'];?> <?=$profile['fname'];?><? if($profile['name'] || $profile['fname']) echo ")";?></div>
			<div class="viev_date" id="load_view_date"></div>
			<div class="viev_name viev_gotoalbom">
				Альбом:
				<a href="?alboms=1" id="gotoalbom" class="line_url" title="Перейти к аьбому"></a>
			</div>				
			<div class="viev_text" id="load_view_text"></div>
			<div class="viev_text_reserv" id="reserv" style="display:none;"></div>
			<a href="" id="edit_photo_butt"><? if($id_user == $_SESSION['id']){?>Редактировать<?}?></a>
		</div>
		<div id="reservOn" style="float:left;">				
			<div class="view_head" id="com_title">Комментарии:</div>
			
			
			<div id="comments_photo_bord">
				<div class="tenl"></div>				
				<div id="comments_photo"></div>			
			</div>
			<div id="view_form">
				<? if($_SESSION['id']){
						if($_SESSION['photo'] && is_file($my_dir_profile."photos/1/makro".$_SESSION['photo']))
							$myphot = $my_dir_profile."photos/1/makro".$_SESSION['photo'];
						else 
							$myphot = $image_url."nophoto.png";
					?>
					<div class="viev_form_author"><img src="<?=$myphot;?>" class="img_user" width="35"></div>
					<div class="view_form_textarea"><textarea id="view_textarea" onfocus="onFormPhoto();" onblur="setTimeout('offFormTimePhoto()', 100);">Написать комментарий</textarea></div>
					<div id="butt_viev"><button class="cancel" onclick='addKommPhoto();'>Отправить</button></div>
				<?}else{?>
				<div class="red">Чтобы оставлять комментарии зарегистрируйтесь или авторизуйтесь если уже зарегистрированы</div>
				<?}?>
			</div>
		</div>		
	</div>
</div>
<? if($id_user != $_SESSION['id']){?>
<!--//// Новое сообщение ////--->
<div id="new_mes">
	<h4>
		Сообщение для <?=$profile['login'];?>
		<div onclick="closeBox()" id="close_mes">X</div>
	</h4>
	<textarea id="new_mesTextarea"></textarea>
	<div class="but_mes"><button class="status_butt" onclick="sendMess()">Отправить</button></div>
</div>
<!--//// Контейнера ////--->
<?}?>
<input type="hidden" value="<?=$image_url;?>" id="image_url">
<input type="hidden" value="<?=$id_user;?>" id="id_user"  name="id_user">
<input type="hidden" value="0" id="off_comm_view">
<input type="hidden" value="0" id="page">
<input type="hidden" value="id<?=$id_user;?>" id="url">
</div>
</body>
<script type="text/javascript" src="js/nophp.js"></script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/all.js"></script>	
<script type="text/javascript" src="js/user.js"></script>
<script>
//отображаем фотографию по ссылке
if(getAtr('alb') > 0 && getAtr('photo') > 0){
	viewOn(getAtr('alb'),getAtr('photo'));
}
var idInterval;

if(getAtr('alboms') > 0){
	navi(2);
}else{
	navi(1);
}
</script>
</html>