<?php
if(isset($_POST['noload'])){
		mysql_query("UPDATE users SET photo='' WHERE login='$login' AND pass='$pass'");
		//удаляем миниатюры (для альбомов они ненужны)
		/*if(is_file($dir_ava."makro".$profile['photo']))
			unlink ($dir_ava."makro".$profile['photo']);
		if(is_file($dir_ava."ava".$profile['photo']))
			unlink($dir_ava."ava".$profile['photo']);*/
		go("profile.php");	
}elseif (isset($_FILES['photo']['name'])){
	if($_FILES['photo']['size'] != 0){
		if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['photo']['name'])){
			$date=time();
			if(!is_dir($dir_ava)){
				//создаем альбом
				newAlbom("Со страницы","Фотографии с моей страницы",$conf['albomtextsize'],"1",$conf['albomcount'],1,$date);
			}else{
				//добавляем в альбом
				$myid = $_SESSION['id'];
				$res = mysql_query ("INSERT INTO photos (id_user,albom,date,photo,text) VALUES('$myid', '1', '$date', '$date', 'Фотография со страницы')");
					if(!$res)
						echo "Произошла ошибка при загрузке :( <br> Попробуйте снова";
					else{
						//обновляем аву
						mysql_query("UPDATE alboms SET img='$date' WHERE id_user='$myid' AND date='1'");
					}
			}
			$filename = $_FILES['photo']['name'];
			$source = $_FILES['photo']['tmp_name'];	
			$target = $dir_ava . $filename;
			move_uploaded_file($source, $target);

			if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
				$im = imagecreatefromgif($dir_ava.$filename);}
					
			if(preg_match('/[.](PNG)|(png)$/', $filename)) {
				$im = imagecreatefrompng($dir_ava.$filename);}
			
			if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
				$im = @imagecreatefromjpeg($dir_ava.$filename);}
			//удаляем старые
				/*if(strlen($profile['photo']) > 3){
					//удаляем миниатюры (для альбомов они ненужны)
					if(is_file($dir_ava."makro".$profile['photo']))
						unlink ($dir_ava."makro".$profile['photo']);
					if(is_file($dir_ava."ava".$profile['photo']))
						unlink($dir_ava."ava".$profile['photo']);
				}*/
			//---Большое фото-------------------------------------------
			$yes_w = 99;
			$w_src = @imagesx($im);
			$h_src = @imagesy($im);
			if($w_src > $yes_w and $h_src > $yes_w){			
				loadPhoto($im,$dir_ava,$date,$conf['photobigsize']);
				loadPhoto($im,$dir_ava,"ava".$date,$conf['photoava']);
				loadPhoto($im,$dir_ava,"mini".$date,$conf['photominisize'],1);	
				loadPhoto($im,$dir_ava,"makro".$date,$conf['photomacrosize'],1);
				
				$photo = $date.".jpg";
				
				$delfull = $dir_ava.$filename; 
				unlink ($delfull);
				mysql_query("UPDATE users SET photo='$photo' WHERE login='$login' AND pass='$pass'");
				$_SESSION['photo'] = $photo;
				//добавляем в альбом
				go("profile.php?p=1");
			}else
				echo "<script>alert('Фотография не подходит размером (слишком маленькая или слишком большая. Измените размер фотографии и попробуйте загрузить ее снова)');</script>";
		}else
			echo "<script>alert('Неверный формат изображения!');</script>";
	}else
		echo "<script>alert('Фотография не подходит размером (слишком маленькая или слишком большая. Измените размер фотографии и попробуйте загрузить ее снова)');</script>";
}
?>