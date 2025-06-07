<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
$id = intval($_GET["id"]);
$pid = intval($_GET["pid"]);
$me = $_SESSION['login'];
if(!$me)
	globalError("Вы не аторизованы","Перейдите на главную страницу и авторизуйтесь");
//вытаскиваем общаг
$mes = "SELECT text,id,author,date,polychatel
		FROM mess
		WHERE 
			(id > '$id') and 
			(
				(privat = '0')
			)
		ORDER BY id LIMIT 10";
$result = mysql_query($mes);
if($result)
{
	$mes = mysql_fetch_array($result);
	if($mes){
		do{
			$author = $mes['author'];
			$style_text = "SELECT ban FROM users WHERE login='$author'	LIMIT 1";
			$style = mysql_query($style_text);
			if($style_text)$style_arr = mysql_fetch_array($style);
			
			if($style_arr['ban'] != 1){
				$text = $mes['text'];
				$text = addurl($text);
				$text = str_replace("[plus]","+",$text);
				$text = str_replace("[and]","&",$text);
				//smiles
				$smile_url = $conf['url']."smiles/";
				$text = preg_replace( "#\{s\:(.+?)\|(.+?)\|(.+?)\:s\}#is" , " <img src='".$smile_url."\\1' border='0' onclick='addSmile(\"\\2\")' title='\\3' class='pointer'> " , $text);
				//
				//градиент и стили
				$prof = getFile(getId($author));
				if(strlen($prof['color_grad']) == 6 || strlen($prof['color_grad']) == 7)
					$text = gradient($text, $prof['color'], $prof['color_grad']);
				//
				echo $mes['id']."[^]";
				echo $author."[^]";
				echo date("H:i:s" ,$mes['date'])."[^]";
				echo $mes['polychatel']."[^]";
				echo $text."[^]";
				if(strlen($prof['color']) < 3)
					$prof['color'] = "#000";
				//шрифты
				if(strlen($prof['font-family']) > 0)
					$font = "font-family:".$prof['font-family'].";";
				else
					$font = "";
					
				//стили (class)				
				if(strlen($prof['class']) > 0)
					$class = 'class="'.$prof['class'].'"';
				else
					$class = "";
					
				echo '<span '.$class.' style="'.$font.' color:'.$prof['color'].';">'.$prof['style_start']."[^]";
				echo $prof['style_end'].'</span>'."[^]";
				echo $prof['htmlnik']."[^n]";
			}
		}while($mes = mysql_fetch_array($result));
	}
}
//вытаскиваем приват
if($_SESSION['admin'])
	$sql_plus = "or	polychatel='".$lang['in_moders']."'";
else
	$sql_plus = "";
$mesP = "SELECT text,id,author,date,polychatel
		FROM mess
		WHERE 
			(id > '$pid' and privat = '1') and 
			(
				(
					polychatel='$me' or
					polychatel='{$lang['alls_post']}' or
					polychatel='{$globale}' or
					author='$me'
					$sql_plus
				 )
			) 
		ORDER BY id LIMIT 20";
$resultP = mysql_query($mesP);
echo "[^pr]";
if($resultP)
{
	
	$mesP = mysql_fetch_array($resultP);
	if($mesP){
		do{
			$author = $mesP['author'];
			$style_text = "SELECT ban FROM users WHERE login='$author'	LIMIT 1";
			$style = mysql_query($style_text);
			if($style_text)$style_arr = mysql_fetch_array($style);
			
			if($style_arr['ban'] != 1){
				$text = $mesP['text'];
				$text = addurl($text);
				$text = str_replace("[plus]","+",$text);
				$text = str_replace("[and]","&",$text);
				//smiles
				$smile_url = $conf['url']."smiles/";
				$text = preg_replace( "#\{s\:(.+?)\|(.+?)\|(.+?)\:s\}#is" , "<img src='".$smile_url."\\1' border='0' onclick='addSmile(\"\\2\")' title='\\3' class='pointer'>" , $text);
				//градиент
				$prof = getFile(getId($author));
				if(strlen($prof['color_grad']) == 6 || strlen($prof['color_grad']) == 7)
					$text = gradient($text, $prof['color'], $prof['color_grad']);
				//
				echo $mesP['id']."[^]";
				echo $mesP['author']."[^]";
				echo date("H:i:s" ,$mesP['date'])."[^]";
				echo $mesP['polychatel']."[^]";
				echo $text."[^]";
				if(strlen($prof['color']) < 3)
					$prof['color'] = "#000";
					
				//шрифты
				if(strlen($prof['font-family']) > 0)
					$font = "font-family:".$prof['font-family'].";";
				else
					$font = "";
					
				//стили (class)				
				if(strlen($prof['class']) > 0)
					$class = 'class="'.$prof['class'].'"';
				else
					$class = "";
					
				echo '<span '.$class.' style="'.$font.' color:'.$prof['color'].';">'.$prof['style_start']."[^]";
				echo $prof['style_end'].'</span>'."[^]";
				echo $prof['htmlnik']."[^n]";
			}
		}while($mesP = mysql_fetch_array($resultP));
	}
}
//удаляем сообщения админом
echo "[^pr]";
$del_sql = "SELECT id2 FROM moderLog WHERE type='delmes' ORDER BY id DESC LIMIT 10";
$del_mysql = mysql_query($del_sql);
$del = mysql_fetch_array($del_mysql);
do{
	echo $del['id2']."[^]";
}while($del = mysql_fetch_array($del_mysql));
?>