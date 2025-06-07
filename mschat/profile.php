<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
$myid = $_SESSION['id'];
//Статус где пользователь
$profS = getFile($myid);
$profS['on'] = 3;
setFile($myid,$profS);
if(isset($_SESSION['login']) and isset($_SESSION['pass'])){
    if($_SESSION['activ'] != 1)
		noActiv();
	$login = $_SESSION['login'];
	$pass = $_SESSION['pass'];
	//пути
	$dir_profile = "users/".floor($_SESSION['id']/1000).'/'.$_SESSION['id']."/";
	$dir_ava = "users/".floor($_SESSION['id']/1000).'/'.$_SESSION['id']."/photos/1/";
	$file_profile = "user.dat";

	//сохраняем данные
	if($_SERVER['REQUEST_METHOD'] == 'POST' and !isset($_FILES['photo']['name'])){
		$prof = getFile($_SESSION['id']);
		if(isset($_POST['name'])){
			$name = hts("name");
			$name = mb_substr($name, 0, 15, "utf-8");
			if($sqltext) 
					$sqltext .= ", ";
				$sqltext .= "name='$name'";
		}
		if(isset($_POST['fname'])){
			$fname = hts("fname");
			$fname = mb_substr($fname, 0, 20, "utf-8");
			if($sqltext) 
					$sqltext .= ", ";
				$sqltext .= "fname='$fname'";
		}
		
		//форматируем дату
		if(isset($_POST['day'])){
			$day = intval(hts("day"));
			if($day > 31 or $day < 1)
				$day = 0;
		}
		
		if(isset($_POST['mon'])){
			$mon = intval(hts("mon"));
			if($mon > 12 or $mon < 1) 
				$day = 0;
		}
		
		if(isset($_POST['year'])){
			$year = intval(hts("year")); 
			if($year > date("Y") or $year < 1950) 
				$year = 0;
		}
		
		if($day || $mon || $year){
			$bday = $day.".".$mon.".".$year;
			if($sqltext) 
					$sqltext .= ", ";
			$sqltext .= "bday='$bday'";
		}
		
		/*/mysql пол
		if(isset($_POST['sex'])){
			$sex = intval(hts("sex"));
			if($sex != 1) 
				$sex = 2;
				if($sqltext) 
					$sqltext .= ", ";
				$sqltext .= "sex='$sex'";
		}*/
		
		if(isset($_POST['land'])){
			$land = hts("land");
			$land = mb_substr($land, 0, 20, "utf-8");
			if($sqltext) 
					$sqltext .= ", ";
			$sqltext .= "land='$land'";
		}
		if(isset($_POST['city'])){
			$city = hts("city");
			$city = mb_substr($city, 0, 20, "utf-8");
			if($sqltext) 
					$sqltext .= ", ";
			$sqltext .= "city='$city'";
		}
		if(isset($_POST['sp'])){
			$sp = hts("sp");
			$sp = intval($sp);
			if($sqltext) 
					$sqltext .= ", ";
			$sqltext .= "sp='$sp'";
		}
		
		//записываем в mysql
		mysql_query("UPDATE users SET $sqltext WHERE login='$login' AND pass='$pass'");
		//категории созданые в админке
		$categories_sql = "SELECT value FROM categories";
		$categories_mysql = mysql_query($categories_sql);
		$categories = mysql_fetch_array($categories_mysql);
		do{
			$cat = $categories['value'];
			if(isset($_POST[$cat])){
				$prof[$cat] = hts($cat);
				$prof[$cat] = mb_substr($prof[$cat], 0, 50, "utf-8");
			}
		}while($categories = mysql_fetch_array($categories_mysql));
		//модер
		if($_SESSION['admin']){
			if(isset($_POST['hidden'])) $prof['hidden'] = 1; else $prof['hidden'] = 0;
			if(isset($_POST['show_moder'])) $prof['show_moder'] = 1; else $prof['show_moder'] = 0;
		}
		//коректируем данные С/П
		if(isset($_POST['partner']))
			$prof['partner'] = hts("partner");

		

		setFile($_SESSION['id'],$prof);
		$saved = true;
	}


	//достаем данные с файла
	$prof = getFile($_SESSION['id']);
	//с базы
	$profile_sql = "SELECT id,mail,bday,sex,admin,photo,land,city,sp,name,fname FROM users WHERE login='$login' and pass='$pass'";
	$profile_mysql = mysql_query($profile_sql);
	$profile = mysql_fetch_array($profile_mysql);
	$bday = explode(".",$profile['bday']);
	//загрузка фотографии (после всего чтобы получить данные о уже существующей фото)
	include_once($engine."load_photo.php");
	include_once($engine."load_photos.php");
}else
	go("index.php");
?>
<!DOCTYPE html>
<html>
  <head>
	<script type="text/javascript" src="js/xmlhttprequest.js"></script>
	<script type="text/javascript" src="js/nophp.js"></script>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
	<script type="text/javascript" src="js/all.js"></script>
	<script type="text/javascript" src="js/profile.js"></script>
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>profile.css" type="text/css" />
	<title>Настройки профиля | <?=$conf['chatname'];?></title>
	<? include("copy_image.php");?>
</head>
<body>
<? include("top.php");?>
	<div id="main">
		<div id="m_left">
			<div class="m_top">Навигация</div>
				<a class="p_menu" href="profile.php?p=1" <? if($_GET['p'] == 1 || $_GET['p'] == '') echo "style='background-color:#c5dbe7;'";?>>Фотография</a>
				<a class="p_menu" href="profile.php?p=2" <? if($_GET['p'] == 2) echo "style='background-color:#c5dbe7;'";?>>Личные данные</a>
				<a class="p_menu" href="profile.php?p=3" <? if($_GET['p'] == 3) echo "style='background-color:#c5dbe7;'";?>>Контактная информация</a>
				<a class="p_menu" href="profile.php?p=4" <? if($_GET['p'] == 4) echo "style='background-color:#c5dbe7;'";?>>Фотоальбомы</a>
				<a class="p_menu" href="profile.php?p=5" <? if($_GET['p'] == 5) echo "style='background-color:#c5dbe7;'";?>>Семья</a>
				<!--<a class="p_menu" href="profile.php?p=6" <? if($_GET['p'] == 6) echo "style='background-color:#c5dbe7;'";?>>Стили</a>-->
				<? if($_SESSION['admin']){?><a class="p_menu" href="profile.php?p=10" <? if($_GET['p'] == 10) echo "style='background-color:#c5dbe7;'";?>>Модер</a><?}?>
		</div>		
		<div id="m_right">
			
		<?if($_GET['p']==1 || $_GET['p'] == ''){?>
			<!-- фотография -->
			<div class="m_top">Фотография</div>
			<form action="profile.php?p=1" method="post" enctype='multipart/form-data'>
			<div class="center brBottom">
				<div class="br2"> 
					<? if(strlen($profile['photo'])>3){?>
						<img src="<?=$dir_ava.$profile['photo'];?>" class="photo">			
					<?}else{?>
						<img src="<?=$image_url;?>nophoto.jpg">
					<?}?>
					<? if($format) echo "<div class='red'>Неверный формат фотографии!</div>"; ?>
				</div>
				
				<div><input  type="FILE" name="photo" class="input br2 pointer"></div>
				<div><label class="pointer"><input type="checkbox" name="noload"> Удалить фотографию и не загружать новую</label></div>
				<div class="small">При загрузке фотографии Вы соглашаетесь с <a href="<?php echo $conf['url']; ?>pages/rules.php" target="_blank">правилами</a> сайта</div>
				<div><button class="btn btn-info">Загрузить</button></div>
			</div>
			</form>
		<?}else if($_GET['p']==2){?>
			<!-- Личные данные -->
			<div class="m_top">Личные данные</div>
			<form action="profile.php?p=2" method="post">
				<div id="ld" class="brBottom">
					
					<div class="str"><label><span class="left">Имя:</span> <input type="text" value="<?=$profile['name'];?>" name="name" class="input"></label></div>
					
					<div class="str"><label><span class="left">Фамилия:</span> <input type="text" class="input" value="<?=$profile['fname'];?>" name="fname" class="input"></label></div>
					
					<div class="str"><span class="left">День рождения:</span>
						
						
						<select name="day" class="input_min">
							<option value="0">---</option>
							<? for($i=1;$i<32;$i++){?>
								<option value="<?=$i;?>" <? if($bday[0] == $i) echo "selected";?>><?=$i;?></option>
							<?}?>
						</select>
						<select name="mon" class="input_min">
							<option value="0">не выбрано</option>
							<? for($i=1;$i<count($monath)+1;$i++){?>
								<option value="<?=$i;?>" <? if($bday[1] == $i) echo "selected";?>><?=$monath[$i];?></option>
							<?}?>
						</select>
						<select name="year" class="input_min">
							<option value="0">------</option>
							<? for($i=date("Y");$i>=1950;$i--){?>
								<option value="<?=$i;?>" <? if($bday[2] == $i) echo "selected";?>><?=$i;?></option>
							<?}?>
						</select>
						
					</div>
					
					<!--<div class="str">
						<span class="left">Пол: </span>
						<select name="sex" class="input">
							<option value='1'>Мужской</option>
							<option value='2' <? if($profile['sex'] == 2)echo "selected";?>>Женский</option>
						</select>
					</div>-->
					<div class="center"><button class="btn btn-info">Сохранить</button></div>
				</div>
			</form>
		<?}else if($_GET['p'] == 5){?>
			<!-- Семья -->
			<div class="m_top">Семья</div>
			<p></p>
			<form action="profile.php?p=5" method="post">
				<!--<div class="str">
					<span class="left">Тип отношений: </span>
					<select class="input" name="type_sp" onchange="changeSpType()" id="type_sp">
						<option value="0">Не выбрано</option>
						<option value="1" <? if($prof['type_sp'] == 1) echo "selected";?>>Реальные</option>
						<option value="2" <? if($prof['type_sp'] == 2) echo "selected";?>>Виртуальные</option>
					</select>
				</div>-->
				
				<div class="str" id="real" >
					<? //реальное ?>
					<span class="left">Семейное положение: </span>
					<?
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
					?>
					<select name="sp" class="input" onchange="addField()" id="new_sp">
						<option value='0'>Не выбрано</option>
						<option value='2' <? if($profile['sp'] == 2) echo "selected";?>><?=$spt[2];?></option>
						<option value='3' <? if($profile['sp'] == 3) echo "selected";?>><?=$spt[3];?></option>
						<option value='4' <? if($profile['sp'] == 4) echo "selected";?>><?=$spt[4];?></option>
						<option value='5' <? if($profile['sp'] == 5) echo "selected";?>><?=$spt[5];?></option>
						<option value='6' <? if($profile['sp'] == 6) echo "selected";?>><?=$spt[6];?></option>
						<option value='7' <? if($profile['sp'] == 7) echo "selected";?>><?=$spt[7];?></option>
					</select>
				</div>
					<div class="str" id="partner" <? if($profile['sp'] != 2 && $profile['sp'] != 5){?>style="display:none"<?}?>>
						<span class="left">Ник партнера: </span>
						<input type="text" name="partner" value="<?=$prof['partner'];?>" id="partner_imp">
					
					<? if($profile['sp'] == 2 || $profile['sp'] == 5){
						//проверка на отношения
						$id_partner = getId($prof['partner']);
						$sql_text = "SELECT sp FROM users WHERE id='$id_partner' LIMIT 1";
						$sql = mysql_query($sql_text);
						if($sql){
							$mysql = mysql_fetch_array($sql);
						$prof_sp = getFile($id_partner);
						
						if($mysql['sp'] == $profile['sp'] && $prof_sp["partner"] == $_SESSION['login'] && $prof_sp['type_sp'] == $prof['type_sp'])
							echo "<div style='text-align:right; padding:5px 130px;'>Взаимные отношения</div>";
						}
					}?>
				</div>
				<div class="str" id="virtyal" <? if($prof['type_sp']  != 2){?>style="display:none;"<?}?>>
					<? //виртуальные ?>
					В разработке
				</div>
				
				<div class="center brBottom"><button class="btn btn-info">Сохранить</button></div>

				<script>
					function changeSpType(){
						var value = $id('type_sp').value;
						if(value == 1){
							$('#real').fadeIn(100);
							$('#virtyal').fadeOut(100);
							if($id('new_sp').value == 2 || $id('new_sp').value == 5)
								$('#partner').fadeIn(100);
						}else if(value == 2){
							$('#real').fadeOut(100);
							$('#partner').fadeOut(100);
							$('#virtyal').fadeIn(100);
						}else{
							$('#real').fadeOut(100);
							$('#virtyal').fadeOut(100);
							$('#partner').fadeOut(100);
						}
					}
					function addField(){
						var value = $id('new_sp').value;
						if(value == 2 || value == 5){
							$('#partner').fadeIn(100);
							//$id('partner_imp').value = "";
						}else
							$('#partner').fadeOut(100);
					}
				</script>
			</form>
		<?}else if($_GET['p'] == 3){?>
			<!-- контакты и места -->
			<div class="m_top">Контактная информация</div>
			<form action="profile.php?p=3" method="post">
				<div id="mk" class="brBottom">
					<div class="str"><span class="left">Страна: </span>
						<select name="land" class="input">
						<?
						$land = "SELECT mini,land FROM land";
						$sql = mysql_query($land);
						$lands = mysql_fetch_array($sql);
						do{
							if($profile['land'] == $lands['mini'])
								$sel = "selected";
							else
								$sel = "";
							echo "<option value=\"".$lands['mini']."\" $sel>".$lands['land']."</option>";
						}while($lands = mysql_fetch_array($sql));
						?>
						</select>
					</div>
					<div class="str"><label><span class="left">Город:</span> <input type="text" value="<?=$profile['city'];?>" name="city" class="input"></label></div>
					<div class="str"><label><span class="left">Улица:</span> <input type="text" value="<?=$prof['street'];?>" name="street" class="input"></label></div>
					<div class="str"><label><span class="left">ICQ:</span> <input type="text" value="<?=$prof['icq'];?>" name="icq" class="input"></label></div>
					<div class="str"><label><span class="left">Skype:</span> <input type="text" value="<?=$prof['skype'];?>" name="skype" class="input"></label></div>
					<div class="str"><label><span class="left">Сайт: http://</span> <input type="text" value="<?=$prof['site'];?>" name="site" class="input"></label></div>
					<div class="center"><button class="btn btn-info">Сохранить</button></div>
				</div>
			</form>	
		<?}else if($_GET['p'] == 4){?>
			<!-- фотоальбомы -->
			<!-- сама фото -->
			<?if(isset($_GET['photo']) && isset($_GET['alb'])){
				$id_photo = intval($_GET['photo']);
				$id_albom = intval($_GET['alb']);
				//вынимаем date с альбома по id
				$photo_text = "SELECT albom,date,photo,text FROM photos WHERE id_user='$myid' AND id='$id_photo' LIMIT 1";
				$photo_arr = mysql_query($photo_text);
				if($photo_arr)
					$photo = mysql_fetch_array($photo_arr);
				if($photo){
				if($photo['text'])
					$text = $photo['text'];
				else
					$text = "Изменить описание фотографии...";
				?>
				<div class="photo_center">
					<div id='prev' onclick="nextPhoto(1)"></div>
					<div id='next' onclick="nextPhoto()"></div>
					
					<div id="border_photo_big" onmouseover="nextOn('1');">
						<img src="<?=$dir_profile;?>photos/<?=$photo['albom'];?>/<?=$photo['photo'];?>.jpg" class='photo_big' id="photo_big" onclick="nextPhoto()" style="cursor:pointer;" onmouseover="nextOn('1');">
					</div>

					<div class="edit_photo" onmouseout="nextOn('');">
						<div class='str2 red hidden' id="status"></div>
						<div class='str2' id="deletePhotoBig"><button  class="btn" onclick="deletePhotoBig()"><i class="icon-trash"></i> Удалить</button></div>
						<div class='str2' id="clear_form"><textarea id="photo_text" onfocus="onFormPhoto();" onblur="offFormPhoto();"><?=$text;?></textarea></div>
						<div class='str2' id="edit_form_photo"></div>
						<div class='str2' id="edit_form_photo"></div>
					</div>
					<button  class="btn" onclick="location.href='profile.php?p=4&alb=<?=$id_albom;?>'"><i class="icon-arrow-left"></i> Назад к фотоальбому</button>
				</div>
				<input type="hidden" id="photo_id" value="<?=$id_photo;?>">
				<input type="hidden" id="albom_id" value="<?=$id_albom;?>">
				<?}else{?>
				<div class="photo_center">
					<div class='str2 red' id="status">Произошла ошибка в поиске фотографии</div>
					<button  class="btn" onclick="location.href='profile.php?p=4&alb=<?=$id_albom;?>'"><i class="icon-arrow-left"></i> Назад к фотоальбому</button>
				</div>
				<?}?>
			<!-- внутри -->
			<?}elseif(isset($_GET['alb'])){
				$id_albom = intval($_GET['alb']);
				//вынимаем date с альбома по id
				$alboms_text = "SELECT date,title,text FROM alboms WHERE id_user='$myid' AND id='$id_albom' LIMIT 1";
				$albom_arr = mysql_query($alboms_text);
				if($albom_arr)
					$albom = mysql_fetch_array($albom_arr);			
				$title = $albom['title'];
				$text = $albom['text'];
				$albom = $albom['date'];
				//вынимаем фотографии
				$photos_text = "SELECT id,photo FROM photos WHERE id_user='$myid' AND albom='$albom' ORDER BY id DESC";
				$photo_arr = mysql_query($photos_text);
				if($photo_arr)
					$photo = mysql_fetch_array($photo_arr);	?>
			<div id="edit_form">
				<div class="m_top">Изменить данные</div>
				<div class='str2'>Название: <input type="text" id="name_albom" class='input' value="<?=$title;?>"></div>
				<div class='str2'>Описание: </div>
				<div class='str2'><textarea id="albom_text"><?=$text;?></textarea></div>
				<div class='str2'>
					<button  class="btn" onclick="cancel_save('<?=$id_albom;?>');"><i class="icon-arrow-left"></i> Отмена</button>
					<button  class="btn btn-info" id="butt_save_edit" onclick="save_alb_ed('<?=$id_albom;?>');"><i class="icon-ok  icon-white"></i>  Сохранить</button>
				</div>
			</div>
			
			<div id="edit_photoalbom" onclick="form_swich();">Изменить текст альбома</div>
			<div id="photos_edit">
				<?
				do{
					if($photo['photo']){?>
					<div class='photo_div_all'>
						<div id='photo<?=$photo['id'];?>' class='val' >
							<div class='delete_photo' onclick='deletePhoto(<?=$photo['id'];?>);' title='Удалить'></div>
							<? if(is_file($dir_profile."photos/".$albom."/mini".$photo['photo'].".jpg")){?>
								<img src="<?=$dir_profile;?>photos/<?=$albom;?>/mini<?=$photo['photo'];?>.jpg" class='photo_img' onclick="location.href='profile.php?p=4&alb=<?=$id_albom;?>&photo=<?=$photo['id'];?>'">
							<?}else{?>
								<img src="<?=$image_url;?>nophoto_err.png" class='photo_img' title="Поврежденная фотография">
							<?}?>
						</div>
					</div>
					<?}else
						echo "<br><center>Здеь будут Ваши фотографии</center>";
				}while($photo = mysql_fetch_array($photo_arr));
				?>
					
					<div class="center brBottom w500">
						<div class='red hidden' id='status'></div>
						<button  class="btn br2" onclick="location.href='profile.php?p=4'"><i class="icon-arrow-left"></i> Назад к фотоальбомам</button>
						
						<form action="profile.php?p=4&alb=<?=$id_albom;?>" method="post" enctype='multipart/form-data'>
							<h3>Загрузить новые фотографии:</h3>
							<div><input  type="FILE" name="photos" class="input br2 pointer" ></div>
							<div class="small">При загрузке фотографии Вы соглашаетесь с правилами проекта</div>
							<div><button class="btn btn-info">Загрузить</button></div>
						</form>
					</div>
					
			</div>
			<?}else{?>
				<div class="m_top">Мои фотоальбомы</div>
				<div id="mk" class="brBottom">
					
					<div id="prof_alboms"></div>
					
					<div style="float:left; width: 575px" id="albom_form">
						<div class='red hidden' id='status'></div>
						<h3 class="white-shadow">Создать новый альбом:</h3>
						<div style="margin-left:20px;">
						<? //считаем сколько создано альбомов
						$all = mysql_query("SELECT COUNT(*) FROM alboms WHERE id_user='$myid'");
						if($all > 0){$all = mysql_fetch_array($all);}
						if($all[0] > 0) {$alboms_c = $all[0];}
						if($alboms_c >= $conf['albomcount']){?>
							Создано максимальное количество альбомов. Удалите ненужные альбомы и обновите эту страницу чтобы создать новы. Либо Вы можете просто отредактировать уже существующие альбомы.
						<?}else{?>
							<div style="margin-left:-130px; margin-top:10px;"><label><span class="left">Название:</span> <input type="text" name="newalbom" id="newalbom" class="input" value="<?=$newalbom;?>"></label></div>
							<div style="margin-left:-130px; margin-top:10px;"><label><span class="left">Описание:</span> <textarea name='albomtext' id='albomtext' style="width: 300px; height:100px;"><?=$albomtext;?></textarea></label></div>
							<div class="center"><button class="btn btn-info" onclick="newAlbom();">Создать</button></div>					
						<?}?>
						</div>
					</div>
				</div>
				<script>
					get_alboms();
				</script>
			<?}?>			
		<?}else if($_GET['p']==10 && $_SESSION['admin']){?>
			<!-- Модерам -->
			<div class="m_top">Модер</div>
				<div id="mk" class="brBottom">
				<form action="profile.php?p=10" method="post">
					<input type="checkbox" name="hidden" <? if($prof['hidden'] == 1) echo "checked"; ?>> Скрыть меня<br>
					<input type="checkbox" name="show_moder" <? if($prof['show_moder'] == 1) echo "checked"; ?>> Показывать в списке как модера<br>
					<button class="btn btn-info" >Сохранить</button>
				</form>
				</div>
		<?}?>		
		</div>
		
		
		
		
		</form>
	</div>
	<? include("copy.php");?>
</body>
</html>