<?php
//загружаем фото loadPhoto($im,$pach,"Название",720,100);
function loadPhoto($im,$pach,$name,$max_size = 120,$sqr = 0,$format_out = "jpg"){
	//проверяем размер
	$w = $max_size;
	$w_src = @imagesx($im);
	$h_src = @imagesy($im);
	//если нужно квадратное изображение
	if($sqr == 1){
		$dest = imagecreatetruecolor($w,$w);			
		// вырезаем квадратную серединку по x, если фото горизонтальное 
		if($w_src>$h_src) 
			imagecopyresampled($dest, $im, 0, 0,
							round((max($w_src,$h_src)-min($w_src,$h_src))/2),
							0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 
		// вырезаем квадратную верхушку по y, 
		// если фото вертикальное
		if($w_src<$h_src) 
			imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,
					  min($w_src,$h_src), min($w_src,$h_src)); 
		// квадратная картинка масштабируется без вырезок 
		if($w_src==$h_src) 
			imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src); 
	}else{
		if($w_src > $w || $h_src > $w){
			// горизонтальное фото
			if($w_src >$h_src){
				$kof = $w_src/$h_src;
				$dest = imagecreatetruecolor($w,$w/$kof); 
				imagecopyresampled($dest, $im, 0, 0,0,0, $w, $w, $w_src, $w_src); 
			}else if($w_src <$h_src){
			// вертикальное			
				$kof = $h_src/$w_src;
				$dest = imagecreatetruecolor($w/$kof,$w); 
				imagecopyresampled($dest, $im, 0, 0,0,0, $w, $w, $h_src, $h_src);
			}else if($w_src == $h_src){
			// квадратная картинка масштабируется без вырезок 				
					if($w_src < $w || $w_src > 100){
						$dest = imagecreatetruecolor($w_src,$w_src);
						imagecopyresampled($dest, $im, 0, 0, 0, 0, $w_src, $w_src, $w_src, $w_src);
					}else{
						$dest = imagecreatetruecolor($w,$w);
						imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);
					}
				}
		}else{
			$dest = imagecreatetruecolor($w_src,$h_src);
			imagecopyresampled($dest, $im, 0, 0, 0, 0, $w_src, $h_src, $w_src, $h_src);
		}
	}
	if($name == "time")	$name=time();
	imagejpeg($dest, $pach.$name.".".$format_out);
	return $name.".".$format_out;
}


//создаем фотоальбом
function newAlbom($name,$text,$size_text,$date,$count,$ava=0,$photo=""){
	$conf['albomcount'] = $count;
	$albomtext = mb_substr($text, 0, $size_text, "utf-8");
	$myid = $_SESSION['id'];
	// проверка на количество альбомов
	$all = mysql_query("SELECT COUNT(*) FROM alboms WHERE id_user='$myid'");
	if($all > 0){$all = mysql_fetch_array($all);}
	if($all[0] > 0) {$alboms_c = $all[0];}
	if($alboms_c >= $conf['albomcount'])
		return "Создано максимальное количество альбомов: ".$conf['albomcount'];
	else{
		$num = floor($_SESSION['id']/1000);
		$dir_save = "users/".$num.'/'.$_SESSION['id']."/photos/".$date;
		
		if(!is_dir($dir_save)){
			mkdir($dir_save, 0777);
			if($photo){//если с авы то догружаем в альбом
				$res = mysql_query ("INSERT INTO alboms (id_user,title,date,text,img) VALUES('$myid', '$name', '$date', '$albomtext',$photo)");
				mysql_query ("INSERT INTO photos (id_user,albom,date,photo,text) VALUES('$myid', '1', '$photo', '$photo','Фотография со страницы')");
			}else
				$res = mysql_query ("INSERT INTO alboms (id_user,title,date,text) VALUES('$myid', '$name', '$date', '$albomtext')");
			if(!$res)
				return "Произошла ошибка при создании альбома :( <br> Попробуйте снова";
			else{
				//удвляем переменные чтобы очистить форму
				return 1;
			}
		}else
			echo "Папка уже создана!";
	}
}
?>