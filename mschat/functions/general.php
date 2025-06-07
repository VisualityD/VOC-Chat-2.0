<?php
function go($url){ //перенаправление
	header("Location: $url");
	exit;
}

//получаем id по нику
function getId($login){
	$sql_text = "SELECT id FROM users WHERE login='$login' LIMIT 1";
	$sql = mysql_query($sql_text);
	if($sql)
		$mysql = mysql_fetch_array($sql);
	return $mysql['id'];
}

//получаем id по нику
function getLogin($id){
	$sql_text = "SELECT login FROM users WHERE id='$id' LIMIT 1";
	$sql = mysql_query($sql_text);
	if($sql)
		$mysql = mysql_fetch_array($sql);
	return $mysql['login'];
}

//определ€ем количество записей в базе
function countSql($sql){
	$sql_q = mysql_query($sql);
	$temp = mysql_fetch_array($sql_q);
	return $temp[0];
}

//вынимаем данные пользовател€
function getFile($id){
	global $inc;
	if($inc)
		for($i=0; $i<$inc; $i++)
			$inc_text .= "../";
	else
		$inc_text = "";
	
	$dir_profile = $inc_text."users/".floor($id/1000).'/'.$id."/";
	$file_profile = "user.dat";
	if(is_file($dir_profile.$file_profile)){
		$file = File($dir_profile.$file_profile);
		return unserialize($file[0]);
	}
}

//записываем в файл данные пользовател€
function setFile($id,$data){
	$dir_profile = "users/".floor($id/1000).'/'.$id."/";
	$file_profile = "user.dat";
	
	$fp = fopen($dir_profile.$file_profile, "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, serialize($data));
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	return $fw;
}
//переводим с tpl шаблона переменные
function tpl($name){
	global $css_url;
	$name = str_replace("{css}",$css_url, $name);
	return $name;
}
function deleteDir( $path ) {
	// если путь существует и это папка
	if ( file_exists( $path ) AND is_dir( $path ) ) {
		// открываем папку
		$dir = opendir($path);
		while ( false !== ( $element = readdir( $dir ) ) ) {
			// удал€ем только содержимое папки
			if ( $element != '.' AND $element != '..' )  {
				$tmp = $path . '/' . $element;
				chmod( $tmp, 0777 );
				// если елемент €вл€етс€ папкой, то удал€ем его использу€ нашу функцию deleteDir
				if ( is_dir( $tmp ) ) {
					deleteDir( $tmp );
				// если елемент €вл€етс€ файлом, то удал€ем файл
			   	} elseif( file_exists( $tmp ) ) {
						unlink( $tmp );
					}
			}
		}
		// закрываем папку
		closedir($dir);
		// удал€ем саму папку
		if ( file_exists( $path ) ) {
			rmdir( $path );
		}
	}
}
//добавл€ем стили к сообщению
function addStyleMes($id,$start,$end,$one=0,$clear=0){
	$prof = getFile($id);
	if($clear == 0){
		if($one == 1){
			$prof['style_start'] = str_replace($start,"",$prof['style_start']);
			$prof['style_end'] = str_replace($end,"",$prof['style_end']);
		}
		//устанавливаем
		$prof['style_start'] = $prof['style_start'].$start;
		$prof['style_end'] = $end.$prof['style_end'];
	}else{
		$prof['style_start'] = $start;
		$prof['style_end'] = $end;
	}
	if(setFile($id,$prof))
		return true;
}

function progress($proc,$text="",$height=16){
	if($proc > 100)
		$proc = 100;
	if($text == "")
		$text = $proc."%";
	$style_shadow_30 = "text-shadow:1px 1px 0 #24335d,
								-1px -1px 0 #24335d,
								-1px 1px 0 #24335d,
								1px -1px 0 #24335d,
								-1px -1px 1px #24335d,
								-1px -1px 1px #24335d,
								1px 1px 1px #24335d,
								1px 1px 1px #24335d;
					color:#fff;";
	$style_shadow_60 = "color:#fff;";
	echo "<style>
			#progressbar div{
				width:".$proc."%;
				height:".$height."px;
			}
			#progressbar span{
				margin-top:-15px;
			";
	if($proc >= 39 && $proc < 61)
		echo $style_shadow_30;
	else if($proc > 60)
		echo $style_shadow_60;
	echo "	}
		</style>
		<div id=\"progressbar\">
			<div></div>
			<span>".$text."</span>
		</div>";
}
//определем возраст
function vozrast($bday){
	$dn = explode(".",$bday);  
	$m = $dn[1]; 
	$d = $dn[0]; 
	$y = $dn[2]; 
	if($y != 0 && $d != 0 && $m != 0){
		$r = mktime(0, 0, 0, $m, $d, $y);  
		$age = (time()-$r)/31536000; 
		list($a) = explode(".",$age);		
		$vozrast =  $a; 
	}else{$vozrast ='';}
	return $vozrast;
}
?>