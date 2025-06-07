<?php
require_once("../common.php");
	
if(isset($_GET['online'])){//сколько людей в чате
	$all = mysql_query("SELECT COUNT(*) FROM users WHERE online='1' or sex='0'");
	if($all > 0){$all = mysql_fetch_array($all);}
	if($all[0] > 0) {$cout_users = $all[0];}
	
	$st = date("H")."|".$cout_users."\n";
	
	//file
	$update= $data_dir."statistic/online/".date("d-m-Y").".dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $st);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
}else if(isset($_GET['day'])){ //каждый день
#сообщения
	$all = intval(file_get($data_dir."statistic/msgs/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM mess");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/msgs/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/msgs/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
#комменты
	$all = intval(file_get($data_dir."statistic/comments/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM comments");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/comments/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/comments/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
#комменты к  фото
	$all = intval(file_get($data_dir."statistic/photocomments/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM photocomments");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/photocomments/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/photocomments/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);

#лайки к коментам
	$all = intval(file_get($data_dir."statistic/likesCom/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM likesCom");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/likesCom/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/likesCom/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);

#лайки к фото
	$all = intval(file_get($data_dir."statistic/likesPhoto/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM likesPhoto");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/likesPhoto/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/likesPhoto/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
#загрузки фоток
	$all = intval(file_get($data_dir."statistic/photos/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM photos");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/photos/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/photos/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);	
	
#альбомов
	$all = intval(file_get($data_dir."statistic/alboms/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM alboms");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/alboms/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/alboms/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);	
#альбомов
	$all = intval(file_get($data_dir."statistic/users/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM users");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/users/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/users/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
#ЛС
	$all = intval(file_get($data_dir."statistic/ls/all.dat")); //сколько сообщений всего
	
	$arr = mysql_query("SELECT COUNT(*) FROM ls");
	if($arr > 0){$arr = mysql_fetch_array($arr);}
	if($arr[0] > 0) {$cout_mes = $arr[0];}
	
	//сохраняем сколько сейчас всего сообщений
	$fp = fopen($data_dir."statistic/ls/all.dat", "w");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, $cout_mes);
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
	
	//расчитываем и сохранияеи
	$new_count = $cout_mes - $all;
	//file
	$update = $data_dir."statistic/ls/array.dat";
	$fp = fopen($update, "a");
	flock($fp, LOCK_EX);
	$fw = fwrite($fp, date("d")."|".$new_count."\n");
	flock($fp, LOCK_UN);
	$fc = fclose($fp);
}
?>