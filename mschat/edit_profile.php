<?php
//Файл отвечает за сохранение данных профиля
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
$myid = $_SESSION['id'];
$date = time();

//Создаем новый альбом
if($_POST['newalbom']){
	$newalbom = hts("newalbom");
	$albomtext = hts("albomtext");	
	$newalbom = mb_substr($newalbom, 0, $conf['albomnamesizemax'], "utf-8");
	if(mb_strlen($newalbom, "utf-8") > $conf['albomnamesizemin'] && mb_strlen($newalbom, "utf-8") < $conf['albomnamesizemax'])
	{
		//сохраняем
		$date=time();
		$res = newAlbom($newalbom,$albomtext,$conf['albomtextsize'],$date,$conf['albomcount']);
		if($res == 1){
			unset($newalbom);
			unset($albomtext);
			echo 1;
		}else{
			echo $res;
		}
	}else{
		echo "Слишком длинное или короткое название (до ".$conf['albomnamesizemax'].")";
	}
}

// Удаляем альбом
if($_POST['deletealbom']){
	$id_albom = intval($_POST['deletealbom']);
	$alboms_text2 = "SELECT id_user,date FROM alboms WHERE id='$id_albom' LIMIT 1";
	$albom_arr2 = mysql_query($alboms_text2);
	if($albom_arr2)
		$albom2 = mysql_fetch_array($albom_arr2);
	if($albom2['id_user'] == $_SESSION['id']){
		$albom = $albom2['date'];
		if($albom == 1){
			//удаляем аву если это ава
			mysql_query("UPDATE users SET photo='' WHERE login='$login' AND pass='$pass'");
		}
		//удаляем папку альбома и все что в ней
		$num = floor($_SESSION['id']/1000);
		$dir_del = "users/".$num.'/'.$_SESSION['id']."/photos/".$albom2['date'];
		deleteDir($dir_del);
		//чистим базу
		$result = mysql_query ("DELETE FROM alboms WHERE id = '$id_albom' LIMIT 1");
		if($result)
			$result = mysql_query ("DELETE FROM photos WHERE albom = '$albom' AND id_user = '".$_SESSION['id']."'");
		else
			echo "Произошла критическая ошибка";
		if($result)
			echo 1;
		else
			echo "Произошла критическая ошибка";
	}else{
		echo "альбом не удален!";
	}
}

// Редактируем альбом
if($_POST['edit'] && $_POST['name_albom']){
	$id_albom = intval($_POST['edit']);
	$name_albom = hts("name_albom");
	$albom_text = hts("albom_text");
	$albom_text = substr($albom_text, 0, 5000);	
	$alboms_text2 = "SELECT id_user FROM alboms WHERE id='$id_albom' LIMIT 1";
	$albom_arr2 = mysql_query($alboms_text2);
	if($albom_arr2)
		$albom2 = mysql_fetch_array($albom_arr2);
	if($albom2['id_user'] == $_SESSION['id']){
		mysql_query("UPDATE alboms SET title='$name_albom',text='$albom_text' WHERE id='$id_albom' LIMIT 1");
		echo 1;
	}else{
		echo "Ошибка, альбом не найден!";
	}
}


#фотографии


// Удаляем фотографию
if($_POST['deletephoto']){
	$id_photo = intval($_POST['deletephoto']);
	$alboms_text2 = "SELECT id_user,photo,albom FROM photos WHERE id='$id_photo' LIMIT 1";
	$albom_arr2 = mysql_query($alboms_text2);
	if($albom_arr2)
		$albom2 = mysql_fetch_array($albom_arr2);
	if($albom2['id_user'] == $myid){
		$img = $albom2['photo'];
		$result = mysql_query ("DELETE FROM photos WHERE id = '$id_photo' LIMIT 1");
		$result = 1;
		if($result){
			$alboms = $albom2['albom'];			

			//удаляем файл
			$num = floor($_SESSION['id']/1000);
			$image = "users/".$num.'/'.$_SESSION['id']."/photos/".$alboms."/".$albom2['photo'].".jpg";
			$imagemini = "users/".$num.'/'.$_SESSION['id']."/photos/".$alboms."/mini".$albom2['photo'].".jpg";
			$imagemakro = "users/".$num.'/'.$_SESSION['id']."/photos/".$alboms."/makro".$albom2['photo'].".jpg";
			$imageava = "users/".$num.'/'.$_SESSION['id']."/photos/".$alboms."/ava".$albom2['photo'].".jpg";
			if(file_exists($image)) unlink($image);
			if(file_exists($imagemini)) unlink($imagemini);
			if(file_exists($imagemakro)) unlink($imagemakro);
			if(file_exists($imageava)) unlink($imageava);
			
			//обновляем обложку если была
			$alboms_texte = "SELECT img FROM alboms WHERE date='$alboms' AND id_user='$myid' LIMIT 1";
			$albom_arre = mysql_query($alboms_texte);
			if($albom_arre)
				$albome = mysql_fetch_array($albom_arre);
				
			if($albom2['photo'] == $albome['img']){//вынимаем новую обложку				
				$obl_text = "SELECT photo FROM photos WHERE albom='$alboms' AND id_user='$myid' ORDER BY id DESC LIMIT 1";
				$obl_arr = mysql_query($obl_text);
				if($obl_arr)
					$obl = mysql_fetch_array($obl_arr);
				if($obl['photo'])
					$new_obl = $obl['photo'];
				else
					$new_obl = "";
				
				mysql_query("UPDATE alboms SET img='$new_obl' WHERE id_user='$myid' AND date='$alboms' LIMIT 1");				
			}
			//проверяем может это ава
			$profile_sql = "SELECT photo FROM users WHERE login='$login' and pass='$pass' LIMIT 1";
			$profile_mysql = mysql_query($profile_sql);
			$profile = mysql_fetch_array($profile_mysql);			
			if($alboms == 1){
				if($profile['photo'] == $albom2['photo'].".jpg"){
					$obl_text_ava = "SELECT photo FROM photos WHERE albom='1' AND id_user='$myid' ORDER BY id DESC LIMIT 1";
					$obl_arr_ava = mysql_query($obl_text_ava);
					if($obl_arr_ava)
						$obl_ava = mysql_fetch_array($obl_arr_ava);
					if($obl_ava['photo'])
						$new_obl_ava = $obl_ava['photo'].".jpg";
					else{
						//здесь можно удалить фотоальбом ели раздражает то что остается пустой альбом после удалении все ав
						$new_obl_ava = "";
					}
					mysql_query("UPDATE users SET photo='$new_obl_ava' WHERE login='$login' and pass='$pass' LIMIT 1");
				}
			}
			//минусуем количество
			$count = $albome['count']-1;
			mysql_query("UPDATE alboms SET count='$count' WHERE id_user='$myid' AND date='$alboms' LIMIT 1");	
			echo 1;
		}
		
	}else{
		echo "Поврежденная фотография удалена!";
	}
	
}

//листаем фотографию
if($_POST['next']){
	$id_photo = intval($_POST['next']);
	$dir_profile = "users/".floor($_SESSION['id']/1000).'/'.$_SESSION['id']."/";
	//вынимаем альбом
	$albom_text = "SELECT albom FROM photos WHERE id_user='$myid' AND id='$id_photo' LIMIT 1";
	$albom_arr = mysql_query($albom_text);
	if($albom_arr)
		$albom = mysql_fetch_array($albom_arr);
	if($albom)
		$albom = $albom['albom'];
	else{//вытаскиваем альбом если фото не найдено (может быть просто удалена)
		$albom_id = intval($_POST['albom_id']);
		$albom_text2 = "SELECT date FROM alboms WHERE id='$albom_id' LIMIT 1";
		$albom_arr2 = mysql_query($albom_text2);
		if($albom_arr2)
			$albom2 = mysql_fetch_array($albom_arr2);
		if($albom2)
			$albom = $albom2['date'];
	}
	if($_POST['prev']){ #прокрутка назад
		//вытаскиваем перд. фото
		$photo_text = "SELECT id,albom,date,photo,text FROM photos WHERE id_user='$myid' AND albom='$albom' AND id > '$id_photo' ORDER BY id LIMIT 1";
		$photo_arr = mysql_query($photo_text);
		if($photo_arr)
			$photo = mysql_fetch_array($photo_arr);
		if($photo && is_file($dir_profile."photos/".$albom."/".$photo['photo'].".jpg"))
			echo $photo['id']."|".$dir_profile."photos/".$albom."/".$photo['photo'].".jpg|".$photo['text']."|".$photo['albom']."|".$photo['date'];
		else{//вытягиваем первую фотку
			$photo_text = "SELECT id,albom,date,photo,text FROM photos WHERE id_user='$myid' AND albom='$albom' AND id < '$id_photo' ORDER BY id LIMIT 1";
			$photo_arr = mysql_query($photo_text);
			if($photo_arr)
				$photo = mysql_fetch_array($photo_arr);
			if($photo && is_file($dir_profile."photos/".$albom."/".$photo['photo'].".jpg"))
				echo $photo['id']."|".$dir_profile."photos/".$albom."/".$photo['photo'].".jpg|".$photo['text']."|".$photo['albom']."|".$photo['date'];
		}
	}else{ #прокрутка вперед
		//вытаскиваем сл. фото
		$photo_text = "SELECT id,albom,date,photo,text FROM photos WHERE id_user='$myid' AND albom='$albom' AND id < '$id_photo' ORDER BY id DESC LIMIT 1";
		$photo_arr = mysql_query($photo_text);
		if($photo_arr)
			$photo = mysql_fetch_array($photo_arr);
		if($photo && is_file($dir_profile."photos/".$albom."/".$photo['photo'].".jpg"))
			echo $photo['id']."|".$dir_profile."photos/".$albom."/".$photo['photo'].".jpg|".$photo['text']."|".$photo['albom']."|".$photo['date'];
		else{//вытягиваем первую фотку
			$photo_text = "SELECT id,albom,date,photo,text FROM photos WHERE id_user='$myid' AND albom='$albom' AND id > '$id_photo' ORDER BY id DESC LIMIT 1";
			$photo_arr = mysql_query($photo_text);
			if($photo_arr)
				$photo = mysql_fetch_array($photo_arr);
			if($photo && is_file($dir_profile."photos/".$albom."/".$photo['photo'].".jpg"))
				$phot = $dir_profile."photos/".$albom."/".$photo['photo'].".jpg";
			else
				$phot = $image_url."nophoto_err.png";
			echo $photo['id']."|".$phot."|".$photo['text']."|".$photo['albom']."|".$photo['date'];
		}
	}
}

// Редактируем текст фото
if($_POST['photo_id'] && $_POST['photo_text']){
	$photo_id = intval($_POST['photo_id']);
	$photo_text = hts("photo_text");
	$text = substr($photo_text, 0, 2000);
	
	$photo_text = "SELECT id_user FROM photos WHERE id='$photo_id' LIMIT 1";
	$photo_arr = mysql_query($photo_text);
	if($photo_arr)
		$photo = mysql_fetch_array($photo_arr);
	if($photo['id_user'] == $_SESSION['id']){
		$res = mysql_query("UPDATE photos SET text='$text' WHERE id='$photo_id' LIMIT 1");
		if($res)
			echo 1;
		else
			echo "Ошибка добавления данных!";
	}else{
		echo "Ошибка, фотография не найден!";
	}
}
?>