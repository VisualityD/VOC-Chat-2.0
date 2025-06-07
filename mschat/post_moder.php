<?php
//Файл отвечает за сохранение данных профиля
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
if($_SESSION['admin']){
	//Удаляем сообщение с чата
	if(isset($_POST['ban'])){
		switch ($_POST['ban']){
			case 1:
				//бан
				$login = hts('login');
				$text = hts('text');
				if(!intval($text))
					exit("время не может быть ".intval($text)."!");
				if(intval($text) > 525600)
					$min = 525600;
				else
					$min =intval($text)*60;
				$text = str_replace(intval($text)." ", "",$text);
				//проверка есть ли такой пользователь
				$sql_text_prov = "SELECT id,ban FROM users WHERE login='$login' LIMIT 1";
				$sql_prov = mysql_query($sql_text_prov);
				if($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);
				if(!$sql_prov_arr['id'])
					exit("Пользователя $login не найдено!");
				if($sql_prov_arr['ban'] == 1)
					exit("Пользователь уже забанен");
				//отключаем
				$res = mysql_query("UPDATE users SET ban='1' WHERE login='$login'");
				if($res){
					addMess($conf['bot_moder'],"Пользователь <b>$login</b> отключен!");
					mysql_query ("INSERT INTO ban (time,min,user,text,moder,type) VALUES('".time()."','$min','$login','$text','".$_SESSION['login']."','1')");
					echo 1;
				}
				break;
			case 2:
				//Заткнуть
				$login = hts('login');
				$text = hts('text');
				if(!intval($text))
					exit("время не может быть ".intval($text)."!");
				if(intval($text) > 525600)
					$min = 525600;
				else
					$min =intval($text)*60;
				$text = str_replace(intval($text)." ", "",$text);
				//проверка есть ли такой пользователь
				$sql_text_prov = "SELECT id FROM users WHERE login='$login' LIMIT 1";
				$sql_prov = mysql_query($sql_text_prov);
				if($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);
				if(!$sql_prov_arr['id'])
					exit("Пользователя $login не найдено!");
				$prof = getFile($sql_prov_arr['id']);
				if($prof['zatknyt'] > 0)
					exit("Пользователя уже заткнут! ");
				//затыкаем
				$minut = $min/60;
				$prof['zatknyt'] = $min+time();
				$prof['prichina_zatknyt'] = $text;
				setFile($sql_prov_arr['id'],$prof);//сохраняем данные
				addMess($conf['bot_moder'],"Пользователю <b>$login</b> запрещено говорить $minut минут! <img src=\'smiles\/time\/15.png\'>");
				echo 1;
				break;
			case 3:
				//пред
				$login = hts('login');
				$text = hts('text');
				if(strlen($login)>1 && strlen($text)>1){
					addMess($conf['bot_moder'],"Пользовател <b>$login</b> получает предупреждение, причина: <b>$text</b>");
					echo 1;
				}else{
					exit("Нету пользователя или причины");
				}
				break;
			case 4:
				//обьявление
				$text = hts('text');
				if(strlen($text)>1){
					addMess($conf['bot_obj'],$text);
					echo 1;
				}else
					exit("Нельзя выводить пустое обьявление");
				break;
			default:
			   echo "Типа бана не найдено";
		}
	}
}
?>