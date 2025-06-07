<?php
//Файл отвечает за сохранение данных профиля
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
$myid = $_SESSION['id'];
//вытягиваем фотографию
if($_POST['veiwalb'] && $_POST['viewphoto']){
	$alb = intval($_POST['veiwalb']);
	$photo = intval($_POST['viewphoto']);
	$id_user = intval($_POST['userid']);
	
	//вынимаем изображение по id или id по изображению смотря как присланы данные
	if(isset($_POST['noid'])){
		$photos_text = "SELECT id FROM photos WHERE photo='$photo' AND id_user='$id_user' LIMIT 1";
		$photos_arr = mysql_query($photos_text);
		if($photos_arr)
			$photos = mysql_fetch_array($photos_arr);
		$id_photo = $photos['id'];
	}else{
		$id_photo = $photo;
		$photos_text = "SELECT photo FROM photos WHERE id='$photo' AND id_user='$id_user' ORDER BY id LIMIT 1";
		$photos_arr = mysql_query($photos_text);
		if($photos_arr)
			$photos = mysql_fetch_array($photos_arr);
		if($photos)
			$photo = $photos['photo'];
	}
	
	//вынимаем количество лайков
	$likes = mysql_query("SELECT COUNT(*) FROM likesPhoto WHERE id_photo='$id_photo'");
	if($likes > 0){$likes2 = mysql_fetch_array($likes);}
		$cout_likes = intval($likes2[0]);
	
	//проверяем лайкал ли ты
	$prov_sql = "SELECT id FROM likesPhoto WHERE kto='$myid' and id_photo='$id_photo' LIMIT 1";
	$prov_mysql = mysql_query($prov_sql);
	$prov = mysql_fetch_array($prov_mysql);
	if($prov['id'])
		$statusLike = 1;
	else
		$statusLike = 0;

	//вынимаем
	$photos_text = "SELECT text,date FROM photos WHERE albom='$alb' AND photo='$photo' AND id_user='$id_user' LIMIT 1";
	$photos_arr = mysql_query($photos_text);
	if($photos_arr){
		$photos = mysql_fetch_array($photos_arr);
		$dir_profile = "users/".floor($id_user/1000).'/'.$id_user."/photos/".$alb."/";
		$date = $photos['date'];
		if($date)
			$date = date("d.m.Y",$date);
		if($photos['id'])
			echo $id_photo."|".$dir_profile.$photo.".jpg|".$photos['text']."|".$date."|".$cout_likes."|".$statusLike;
		else{
			//не пойму почему но не всегда вынимается id поэтому повторно вынимаю
			//$photos_arr = mysql_query("SELECT id FROM photos WHERE photo='$photo' AND id_user='$id_user' AND ");
			echo $id_photo."|".$dir_profile.$photo.".jpg|".$photos['text']."|".$date."|".$cout_likes."|".$statusLike;
		}
	}
	//вынимаем название с альбома
	$albom_title_text = "SELECT title FROM alboms WHERE date='$alb' and id_user='$id_user' LIMIT 1";
	$albom_title = mysql_query($albom_title_text);
	$title = mysql_fetch_array($albom_title);
	if($title['title'])
		echo "|".$title['title'];
	else
		echo "|";
}


//листаем фотографию
if($_POST['next']){
	$id_photo = intval($_POST['next']);
	$id_user = intval($_POST['id']);
	$albom = intval($_POST['albom']);
	
	
	$dir_profile = "users/".floor($id/1000).'/'.$id_user."/";
	$sql = "id_user='$id_user' ";
	
	//если нужно только для одного альбома вынимать
	if($_POST['onlyAlbom'])
		$sql .= " AND albom='$albom' ";

	//прокрутка назад
	if($_POST['prev']){
		$photo_text = "SELECT id,albom,date,photo,text FROM photos WHERE $sql AND id > '$id_photo' ORDER BY id LIMIT 1";
		$photo_arr = mysql_query($photo_text);
		if($photo_arr)
			$photo = mysql_fetch_array($photo_arr);
		if($photo){
			$date = date("d.m.Y",$photo['date']);
			if(is_file($dir_profile."photos/".$photo['albom']."/".$photo['photo'].".jpg"))
					$phot = $dir_profile."photos/".$photo['albom']."/".$photo['photo'].".jpg";
				else
					$phot = $image_url."nophotobig.jpg";
				echo $photo['id']."|".$phot."|".$photo['text']."|".$date."|".$photo['albom'];
		}else{//возвращаемся к первой фотке
			$photo_text = "SELECT id,albom,date,photo,text FROM photos WHERE $sql AND id < '$id_photo' ORDER BY id LIMIT 1";
			$photo_arr = mysql_query($photo_text);
			if($photo_arr)
				$photo = mysql_fetch_array($photo_arr);
			if($photo){
				$date = date("d.m.Y",$photo['date']);
				if(is_file($dir_profile."photos/".$photo['albom']."/".$photo['photo'].".jpg"))
					$phot = $dir_profile."photos/".$photo['albom']."/".$photo['photo'].".jpg";
				else
					$phot = $image_url."nophotobig.jpg";
				echo $photo['id']."|".$phot."|".$photo['text']."|".$date."|".$photo['albom'];
			}
		}
	
	}else{
		//прокрутка вперед
		$photo_text = "SELECT id,albom,date,photo,text FROM photos WHERE $sql AND id < '$id_photo' ORDER BY id DESC LIMIT 1";
		$photo_arr = mysql_query($photo_text);
		if($photo_arr)
			$photo = mysql_fetch_array($photo_arr);
		if($photo){
			$date = date("d.m.Y",$photo['date']);
			if(is_file($dir_profile."photos/".$photo['albom']."/".$photo['photo'].".jpg"))
				$phot = $dir_profile."photos/".$photo['albom']."/".$photo['photo'].".jpg";
			else
				$phot = $image_url."nophotobig.jpg";
			echo $photo['id']."|".$phot."|".$photo['text']."|".$date."|".$photo['albom'];
		}else{//возвращаемся к первой фотке
			$photo_text = "SELECT id,albom,date,photo,text FROM photos WHERE $sql AND id > '$id_photo' ORDER BY id DESC LIMIT 1";
			$photo_arr = mysql_query($photo_text);
			if($photo_arr)
				$photo = mysql_fetch_array($photo_arr);
			if($photo){
				$date = date("d.m.Y",$photo['date']);
				if(is_file($dir_profile."photos/".$photo['albom']."/".$photo['photo'].".jpg"))
					$phot = $dir_profile."photos/".$photo['albom']."/".$photo['photo'].".jpg";
				else
					$phot = $image_url."nophotobig.jpg";
				echo $photo['id']."|".$phot."|".$photo['text']."|".$date."|".$photo['albom'];
			}
		}
	}
	
	$id_photo = $photo['id'];
	//вынимаем количество лайков
	$likes = mysql_query("SELECT COUNT(*) FROM likesPhoto WHERE id_photo='$id_photo'");
	if($likes > 0){$likes = mysql_fetch_array($likes);}
	if($likes[0] > 0) {$cout_likes = $likes[0];}else{$cout_likes = 0;}
	
	//проверяем лайкал ли ты
	$prov_sql = "SELECT id FROM likesPhoto WHERE kto='$myid' and id_photo='$id_photo' LIMIT 1";
	$prov_mysql = mysql_query($prov_sql);
	$prov = mysql_fetch_array($prov_mysql);
	if($prov['id'])
		$statusLike = 1;
	else
		$statusLike = 0;
	
	echo "|".$cout_likes."|".$statusLike;
	
	//вынимаем название с альбома
	$albom_title_text = "SELECT title FROM alboms WHERE date='".$photo['albom']."' and id_user='$id_user' LIMIT 1";
	$albom_title = mysql_query($albom_title_text);
	$title = mysql_fetch_array($albom_title);
	if($title['title'])
		echo "|".$title['title'];
	else
		echo "|";
}

//доббавляем коммент к фото
if(isset($_POST['commPhoto']) && $_SESSION['id']){
	if($myid < 1)
		exit("no avtorization");
	if($_SESSION['activ'] != 1)
		noActiv();
	$text = strip_tags(hts(commPhoto));
	$photoid = intval(hts(photoid));
	$text = str_replace("[pluse]","+",$text);	
	$text = substr($text, 0, 1000);
	$id_user = intval($_POST['id_user']);
	$my_id = $_SESSION['id'];
	if($id_user){
		$time = time();
		//проверяем не забанен ли пользователь
		$bann_sql = "SELECT ban FROM users WHERE login='$login' LIMIT 1";
		$bann_mysql = mysql_query($bann_sql);
		$bann = mysql_fetch_array($bann_mysql);
		if($bann['ban'] == 1)
			exit('Вы заBANены');
		//проверяем как давно он уже писал и на флуд
		$lim_sql = "SELECT time,text FROM  photocomments WHERE kto='$my_id' ORDER BY id DESC LIMIT 1";
		$lim_mysql = mysql_query($lim_sql);
		$lim = mysql_fetch_array($lim_mysql);

		if(($lim['time'] + $conf['poslcom']) > $time && !$_SESSION['admin'])
			exit('Не так быстро! ('.$conf['poslcom'].' сек.)');
		if($text == $lim['text'])
			exit('Флуд (многократное повторение) ');
		//
		$res = mysql_query ("INSERT INTO photocomments (kto,komu,text,time,id_photo) VALUES('$my_id','$id_user','$text','$time','$photoid')");
		if($res){
			echo 1;
			//начисляем рейтинг
			if(mb_strlen($text, "utf-8") > 3 && $_SESSION['time_point']+$conf['time_point'] < time()){
				$profS = getFile($id_user);
				$point = mb_strlen($text, "utf-8");
				$point = intval($point/2);
				if($point > 70)
					$point = 70;
				if($id_user == $_SESSION['id'])
					$point = intval($point/2);
				$profS['point'] = $profS['point']+$point;
				setFile($id_user,$profS);
				$_SESSION['time_point'] = time();
			}
		}else
			echo 'Ошибка! Перезайдите на сайт.';
	}else{
		echo 'Ошибка, не выбрано кому! Перезайдите на сайт.';
	}
	
}
//Удаляем коммент к фото
if(isset($_POST['delete_photo_comm']) && $_SESSION['id']){
    if($_SESSION['activ'] != 1)
		noActiv();
	if($myid < 1)
		exit("no avtorization");
	if(time() < $_SESSION['liketime']+$conf['like'])exit;
	//проверки =)
	$delete = intval($_POST['delete_photo_comm']);
	$prov_sql = "SELECT id FROM photocomments WHERE id = '$delete' AND (komu='$myid' OR kto='$myid') LIMIT 1";
	$prov_mysql = mysql_query($prov_sql);
	$prov = mysql_fetch_array($prov_mysql);
	
	if($_SESSION['admin'] || $prov['id'] > 0){
	//
		
		$res = mysql_query ("DELETE FROM photocomments WHERE id='$delete'");
		if($res){
			echo 1;
			$_SESSION['liketime'] = time();
		}else
			echo "Ошибка, не удалено! попробуйте снова";
	}else
		echo "Нету прав";
}
//Удаляем сообщение с чата
if(isset($_POST['deletemes']) && $_SESSION['id']){	
	if($myid < 1)
		exit("no avtorization");
    if($_SESSION['activ'] != 1)
		noActiv();
	$deletemes = intval($_POST['deletemes']);
	if($_SESSION['admin'] && $deletemes > 0){
		//вынимаем сообщение для создания логов
		$mesP = "SELECT text,author,polychatel FROM mess WHERE id='$deletemes' LIMIT 10";
		$resultP = mysql_query($mesP);
		if($resultP)
			$mesP = mysql_fetch_array($resultP);

		if($mesP['text'])
			$res = mysql_query ("DELETE FROM mess WHERE id='$deletemes'");
		if($res){
			echo 1;
			$text = $mesP['author'].">".$mesP['polychatel'].":".$mesP['text'];
			mysql_query ("INSERT INTO moderLog (id2,date,text,moder,type) VALUES('$deletemes','".time()."','$text','".$_SESSION['login']."','delmes')");
		}else
			echo "Ошибка, не удалено! попробуйте снова";
	}else
		echo "Нету прав";
}

//сообщение ЛС
if(isset($_POST['text']) && isset($_POST['id_user'])){
    if($_SESSION['activ'] != 1)
		noActiv();
	if($myid < 1)
		exit("no avtorization");
	if(time() < $_SESSION['liketime']+$conf['like'])exit("Не так быстро!");
	$text = hts('text');
	$id_us = intval($_POST['id_user']);
	if(mb_strlen($text, "utf-8") > 5000)
		exit("Слишком большое сообщение");
	if($id_us > 0 && mb_strlen($text, "utf-8") > 0){
		$res = mysql_query ("INSERT INTO ls (pol,otp,text,time) VALUES('$id_us','$myid','$text','".time()."')");
		if($res)
			echo "1";
		else
			echo "Ошибка! сообщение не отправлено.";
	}
	$_SESSION['liketime'] = time();
}
?>