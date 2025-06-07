<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
//обновляем что пользователь в чате
$profS = getFile($_SESSION['id']);
$profS['on'] = 1;
setFile($_SESSION['id'],$profS);

if(isset($_POST['text']) && $_POST['text'] != ""){
	$me = $_SESSION['login'];
	$text = hts($_POST['text']);
	## Фильтры спама и флуда
	//проверка времени последней отправки
	$times_sql = "SELECT date,text FROM mess WHERE author='$me' ORDER BY id DESC LIMIT 1";
	$times_mysql = mysql_query($times_sql);
	if($times_mysql)
		$times_old = mysql_fetch_array($times_mysql);

	if(($times_old['date'] + 1) > time())
		exit("Не так быстро!");
	
	//смайлы вставляем до проверки чтобы проверить не был ли флуд смайлами		
	$smile_file = File($data_dir."smiles/all.dat");
	$cfd = count($smile_file);
	$text = substr($text, 0, 500);
	for ($smi=0; $smi<count($smile_file); $smi++){
		$expl = explode("^", $smile_file[$smi]);
		$text = str_replace($expl[1],"{s:".$expl[3]."|".$expl[1]."|".$expl[2].":s}", $text);
	}

	//проверка на одинаковые сообщения
	$texts_sql = "SELECT text FROM mess WHERE author='$me' ORDER BY id DESC LIMIT $spam";
	$texts_mysql = mysql_query($texts_sql);
	if($texts_mysql)
		$texts_old = mysql_fetch_array($texts_mysql);
	do{
		if($text == $texts_old['text'])
			exit("Флуд. Многократное повторение!");
	}while($texts_old = mysql_fetch_array($texts_mysql));
	/////////////////////////////
	
	//проверка количества смайлов (вынимаем массив смайлов, и проверяем существует ли енный элемент масива)
	preg_match_all("#\{s\:(.+?)\:s\}#is", $text, $res, PREG_PATTERN_ORDER);
	if($res[0][$conf['smileCount']])
		exit("Сообщение не отправлено! Слишком много смайлов в одном сообщении. Допустимо: не более ".$conf['smileCount']." смайлов");
	
	
	if($text != '' and strlen($me)>2){
		$dt = time();
		$from = strip_tags($_POST['from']);
		
		//проверяем не забанен ли пользователь
		$bann_sql = "SELECT ban FROM users WHERE login='$me' LIMIT 1";
		$bann_mysql = mysql_query($bann_sql);
		$bann = mysql_fetch_array($bann_mysql);
		if($bann['ban'] == 1)
			exit("Вы отключены от чата!");
		//проверяем заткнут ли
		$prof = getFile($_SESSION['id']);//Вынимаем данные пользователя
		if($prof['zatknyt'] > 0){
			if($prof['zatknyt'] > time()){
				$min = intval(($prof['zatknyt'] - time())/60);
				if($min == 0)$min = 0.5;
				exit("Вам запрещено говорить $min минут, причина: ".$prof['prichina_zatknyt']);
			}else{//обнуляем если вышло время
				$prof['zatknyt'] = 0;
				$prof['prichina_zatknyt'] = "";
			}
		}
		if(isset($_POST['privat'])){
			$privat = 1;
			if($_SESSION['activ'] != 1)
				noActiv();
			}
		if(($from == $lang['alls_post'] or $from == $lang['girls_post'] or $from == $lang['boys_post'] or $from == $lang['robots_post']) and $_SESSION['admin'] == 0)
			$privat = 0;
			
		if($privat and strlen($from)>2){
			//проверка на то кому сообщение
			$arr_from = explode(",",$from);
			if(count($arr_from)> 1){
				exit("Вы не можете отсылать одновременно нескольким пользователям приватное сообщение");
			}
			//поиск пользователя
			if($from != $lang['in_moders'] && $from != $lang['alls_post'] && $from != $lang['girls_post'] && $from != $lang['boys_post'] && $from != $lang['robots_post']){
				$is_sql = "SELECT id FROM users WHERE login='$from' LIMIT 1";
				$is_mysql = mysql_query($is_sql);
				$is = mysql_fetch_array($is_mysql);
				if(!$is['id'])
					exit("Пользователь $from не найден");
			}
			
			mysql_query ("INSERT INTO mess (author,date,text,polychatel,privat) VALUES('$me','$dt','$text','$from','1')");
			$prof['countPrivate']++;
		}else{
			mysql_query ("INSERT INTO mess (author,date,text,polychatel) VALUES('$me','$dt','$text','$from')");
			
			//начисляем поинты + статистика
			$text = preg_replace("#\{s\:(.+?)\:s\}#is", "",$text);
			$text = str_replace(" ", "", $text);
			if($_SESSION['oldmes']+10 < time() && $_SESSION['activ'] == 1){
				$point = mb_strlen($text, "utf-8");
				if($point > 20)
					$point = 20;
				if($point > 2)			
					$prof['point'] = $prof['point']+$point;
				$_SESSION['oldmes'] = time();
			}
			$prof['countAll']++;
		}
		$prof['zatknyt'] = 0;
		//проверяем действителен ли еще градиент
		if($prof['gradient'] < time()){
			$prof['gradient'] = "";
			$prof['color_grad'] = "";
		}
		setFile($_SESSION['id'],$prof);//сохраняем данные
	}
		
}
?>