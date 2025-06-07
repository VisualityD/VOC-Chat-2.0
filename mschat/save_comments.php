<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
if(isset($_POST['text'])){
	$text = hts(text);
	$text = str_replace("[pluse]","+",$text);	
	$text = substr($text, 0, 2000);
	$id_user = intval($_POST['id_user']);
	$my_id = $_SESSION['id'];
	if($id_user){
		$time = time();
		if($_SESSION['activ'] != 1)
			noActiv();
		//проверяем не забанен ли пользователь
		$bann_sql = "SELECT ban FROM users WHERE login='$login' LIMIT 1";
		$bann_mysql = mysql_query($bann_sql);
		$bann = mysql_fetch_array($bann_mysql);
		if($bann['ban'] == 1)
			exit('<div class="no">Вы заBANены</div><div id="closeBox"><img src="'.$image_url.'closeMiniWhite.png" onClick="closeYN()" class="pointer prozr" title="Закрыть"></div>');
		//проверяем как давно он уже писал и на флуд
		$lim_sql = "SELECT time,text FROM comments WHERE kto='$my_id' ORDER BY id DESC LIMIT 1";
		$lim_mysql = mysql_query($lim_sql);
		$lim = mysql_fetch_array($lim_mysql);

		if(($lim['time'] + $conf['poslcom']) > $time && !$_SESSION['admin'])
			exit('<div class="no">Не так быстро! ('.$conf['poslcom'].' сек.)</div><div id="closeBox"><img src="'.$image_url.'closeMiniWhite.png" onClick="closeYN()" class="pointer prozr" title="Закрыть"></div>');
		if($text == $lim['text'])
			exit('<div class="no">Флуд (многократное повторение) </div><div id="closeBox"><img src="'.$image_url.'closeMiniWhite.png" onClick="closeYN()" class="pointer prozr" title="Закрыть"></div>');
		//
		$res = mysql_query ("INSERT INTO comments (kto,komu,text,time) VALUES('$my_id','$id_user','$text','$time')");
		if($res){
			echo 1;		
			
			//начисляем рейтинг
			if(mb_strlen($text, "utf-8") > 10 && $_SESSION['time_point']+$conf['time_point'] < time()){
				$profS = getFile($id_user);
				$point = mb_strlen($text, "utf-8");
				$point = intval($point/2);
				if($point > 100)
					$point = 100;
				if($id_user == $_SESSION['id'])
					$point = intval($point/2);
				$profS['point'] = $profS['point']+$point;
				setFile($id_user,$profS);
				$_SESSION['time_point'] = time();
			}
			
		}else
			echo '<div class="no">Ошибка! Перезайдите на сайт.</div><div id="closeBox"><img src="'.$image_url.'closeMiniWhite.png" onClick="closeYN()" class="pointer prozr" title="Закрыть"></div>';
	}else{
		echo '<div class="no">Ошибка, не выбрано кому! Перезайдите на сайт.</div><div id="closeBox"><img src="'.$image_url.'closeMiniWhite.png" onClick="closeYN()" class="pointer prozr" title="Закрыть"></div>';
	}
	
}else{
	echo '<div class="no">Нету данных</div><div id="closeBox"><img src="'.$image_url.'closeMiniWhite.png" onClick="closeYN()" class="pointer prozr" title="Закрыть"></div>';
}