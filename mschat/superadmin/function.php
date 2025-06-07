<?php
if(!$_SESSION['admin'])exit("no-admin");

//вынимаем данные пользователей
function getFileAdmin($id){
	$dir_profile = "../users/".floor($id/1000).'/'.$id."/";
	$file_profile = "user.dat";
	if(is_file($dir_profile.$file_profile)){
		$file = File($dir_profile.$file_profile);
		return unserialize($file[0]);
	}
}
//записываем в файл данные пользователя
function setFileAdmin($id,$data){
	$dir_profile = "../users/".floor($id/1000).'/'.$id."/";
	$file_profile = "user.dat";
	
	$fp = fopen($dir_profile.$file_profile, "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, serialize($data));
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	return fw;
}
?>