<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
if(!$connect)
	go("index.php");
$my_id = $_SESSION['id'];
//проверяем на бан
$bann_sql = "SELECT ban FROM users WHERE login='$login' LIMIT 1";
$bann_mysql = mysql_query($bann_sql);
$bann = mysql_fetch_array($bann_mysql);
if($bann['ban'] == 1)
	exit('Вы забанены!');
if($_SESSION['activ'] != 1)
		noActiv();
//добавляем лайк
if(isset($_POST['like'])){
	if(time() < $_SESSION['liketime']+$conf['like'])exit;
	$like = intval($_POST['like']);
	//проверяем был ли уже лайк
	$prov_sql = "SELECT id FROM likesCom WHERE kto='$my_id' and com='$like' LIMIT 1";
	$prov_mysql = mysql_query($prov_sql);
	$prov = mysql_fetch_array($prov_mysql);
	if(!$prov['id']){
		$res = mysql_query ("INSERT INTO likesCom (kto,com) VALUES('$my_id','$like')");
		if($res){
			echo 1;
			$_SESSION['liketime'] = time();
		}
	}
}
//Удаляем лайк
if(isset($_POST['nolike'])){
	if(time() < $_SESSION['liketime']+$conf['like'])exit;
	$like = intval($_POST['nolike']);
	$res = mysql_query ("DELETE FROM likesCom WHERE kto='$my_id' and com='$like'");
	if($res){
		echo 1;
		$_SESSION['liketime'] = time();
	}
}
//добавляем лайк фото
if(isset($_POST['likePhoto'])){
	if(time() < $_SESSION['liketime']+$conf['like'])exit;
	$id_photo = intval($_POST['likePhoto']);
	
	//проверяем был ли уже лайк
	$prov_sql = "SELECT id FROM likesPhoto WHERE kto='$my_id' and id_photo='$id_photo' LIMIT 1";
	$prov_mysql = mysql_query($prov_sql);
	$prov = mysql_fetch_array($prov_mysql);
	if(!$prov['id']){
		$res = mysql_query ("INSERT INTO likesPhoto (kto,id_photo) VALUES('$my_id','$id_photo')");
		if($res){
			echo 1;
			$_SESSION['liketime'] = time();
		}
			//сколько лайков сохраняем для топов
			$result00 = mysql_query("SELECT COUNT(*) FROM likesPhoto WHERE id_photo='$id_photo'");
			$temp = mysql_fetch_array($result00);
			$likes = $temp[0];
			mysql_query("UPDATE photos SET likes='$likes' WHERE id='$id_photo'");
	}else{
		echo "Вы уже лайкали эту фотографию";
	}
}

//Удаляем лайк
if(isset($_POST['nolikePhoto'])){
	if(time() < $_SESSION['liketime']+$conf['like'])exit;
	$id_photo = intval($_POST['nolikePhoto']);
	$res = mysql_query ("DELETE FROM likesPhoto WHERE kto='$my_id' and id_photo='$id_photo'");
	if($res){
		echo 1;
		$_SESSION['liketime'] = time();
	}else{
		echo "Ошибка удаления лайка";
	}
}
//Удаляем коммент
if(isset($_POST['delete'])){
	if(time() < $_SESSION['liketime']+$conf['like'])exit;
	//проверки =)
	$delete = intval($_POST['delete']);
	$prov_sql = "SELECT id FROM comments WHERE id = '$delete' AND (komu='$my_id' OR kto='$my_id') LIMIT 1";
	$prov_mysql = mysql_query($prov_sql);
	$prov = mysql_fetch_array($prov_mysql);
	
	if($_SESSION['admin'] || $prov['id'] > 0){
	//
		
		$res = mysql_query ("DELETE FROM comments WHERE id='$delete'");
		if($res){
			echo 1;
			$_SESSION['liketime'] = time();
		}
	}
}

//добавляем статус текст
if(isset($_POST['statustext'])){
	if(time() < $_SESSION['liketime']+$conf['like'])exit;
	$statustext = hts('statustext');
	$statustext = substr($statustext, 0, 200);	
	$prof = getFile($_SESSION['id']);
	$prof['statustext'] = $statustext;
	setFile($_SESSION['id'],$prof);
	echo 1;
	$_SESSION['liketime'] = time();
}
//добавляем статус картинку
if(isset($_POST['imgstatus'])){
	if(time() < $_SESSION['liketime']+$conf['like'])exit;
	$imgstatus = strip_tags($_POST['imgstatus']);
	$prof = getFile($_SESSION['id']);
	$prof['imgstatus'] = $imgstatus;
	setFile($_SESSION['id'],$prof);
	echo 1;
	$_SESSION['liketime'] = time();
}