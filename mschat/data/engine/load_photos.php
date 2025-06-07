<?php
if (isset($_FILES['photos']['name']) && isset($_GET["alb"])){
	if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['photos']['name'])){
		$filename = $_FILES['photos']['name'];
		$source = $_FILES['photos']['tmp_name'];	
		$myid = $_SESSION['id'];
		//проверяем пользователя ли альбом
		$albom_id = intval($_GET["alb"]);
		$alboms_txt = "SELECT date FROM alboms WHERE id_user='$myid' AND id='$albom_id' LIMIT 1";
			$alboms_arr = mysql_query($alboms_txt);
			if($alboms_arr)
				$alboms = mysql_fetch_array($alboms_arr);	
		if(!$alboms['date'])
			exit("Критическая ошибка");
		//путь к папке
		$albom = $alboms['date'];
		$dir_profile = $dir_profile."photos/".$albom."/";
		$target = $dir_profile . $filename;
		move_uploaded_file($source, $target);

		if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
			$im = imagecreatefromgif($dir_profile.$filename);}
				
		if(preg_match('/[.](PNG)|(png)$/', $filename)) {
			$im = imagecreatefrompng($dir_profile.$filename);}
		
		if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
			$im = @imagecreatefromjpeg($dir_profile.$filename);}
		
		$yes_w = 99;
		$w_src = @imagesx($im);
		$h_src = @imagesy($im);
		if($w_src > $yes_w and $h_src > $yes_w){			
			$date = time();			
			
			loadPhoto($im,$dir_profile,$date,$conf['photobigsize']);
			
			loadPhoto($im,$dir_profile,"mini".$date,$conf['photominisize'],1);
			
			$photo = $date;			
			$delfull = $dir_profile.$filename; 
			unlink ($delfull);
			$res = mysql_query ("INSERT INTO photos (id_user,albom,date,photo) VALUES('$myid', '$albom', '$date', '$photo')");
				if(!$res)
					echo "Произошла ошибка при загрузке :( <br> Попробуйте снова";
				else{
					//обновляем аву
					mysql_query("UPDATE alboms SET img='$photo' WHERE id_user='$myid' AND date='$albom'");
					go("profile.php?p=4&alb=".$albom_id);
				}
		}else{
			echo "<script>alert('Фотография не подходит размером (слишком маленькая или слишком большая. Измените размер фотографии и попробуйте загрузить ее снова)'); location.href='profile.php?p=4&alb=".$albom_id."';</script>";
			exit;
		}
	}else{
		echo "<script>alert('Неверный формат изображения!'); location.href='profile.php?p=4&alb=".$albom_id."';</script>";
	}
}
?>