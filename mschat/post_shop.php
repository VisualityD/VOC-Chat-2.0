<?php
//Файл отвечает за сохранение данных профиля
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
$prof = getFile($_SESSION['id']);//Вынимаем данные пользователя
//начальное окно
if(isset($_POST['item'])){
	$id = intval($_POST['item']);
	$shop_text = "SELECT cat,function,count,price FROM shop WHERE id='$id' LIMIT 1"; 
	$shop_sql = mysql_query($shop_text);
	$shop = mysql_fetch_array($shop_sql);
	//проверяем количество
	if($shop['count'] == 0){
		echo "0|0|Товара нет на складе, попробуйте в другой раз.";
		echo "<div class='center' onclick='closeStatus()'><button>Ок</button></div>";
		exit;
	}
	//разбиваем по точке название функции и ее действие
	$arr = explode(".",$shop['function']);
	
	//Скидка 50%
	if(($shop['function'] == "gradient" && $prof['gradient'] > time()) || ($arr[0] == "class" && $prof['class_time'] > time() && $prof['class'] == $arr[1]))
		$shop['price'] = $shop['price']/2;
		
	//проверяем цену
	if($prof['money'] >= $shop['price']){	
		
		if($shop['function'] == "b"){//жирный шрифт			
			$prof['money'] -= $shop['price'];
			setFile($_SESSION['id'],$prof);
			addStyleMes($_SESSION['id'],"<b>","</b>",1);
			echo $shop['price']."|";
			echo $shop['count']."|";
			echo "Жирный стиль успешно установлен. Спасибо за поупку.";
			echo "<div class='center' onclick='closeStatus()'><button>Закрыть</button></div>";
		}else if($shop['function'] == "color21" || $shop['function'] == "color42"){//палитры цветов
			$prof['money'] -= $shop['price'];
			if($shop['function'] == "color21") $prof['colors'] = "normal";
			if($shop['function'] == "color42") $prof['colors'] = "mega";
			setFile($_SESSION['id'],$prof);			
			echo $shop['price']."|";
			echo $shop['count']."|";
			echo "Палитра цветов успешно установлена. Спасибо за покупку.";
			echo "<div class='center' onclick='closeStatus()'><button>Закрыть</button></div>";
		
		}else if($shop['function'] == "gradient"){//градиент					
			echo $shop['price']."|";
			echo $shop['count']."|";
			if($prof['gradient'] > time()){
				$prof['gradient'] += 60*60*24*30;
				echo "Градиент продлен на 30 дней (до ".date("j.m.Y",$prof['gradient']).").";
			}else{
				$prof['gradient'] = time() + 60*60*24*30;
				echo "Градиент куплен на 30 дней (до ".date("j.m.Y",$prof['gradient'])."). При продлении до окончания действия градиента, вы получаете скидку: 50%";
			}
			echo "<div class='center' onclick='closeStatus()'><button>Закрыть</button></div>";
			$prof['money'] -= $shop['price'];
			setFile($_SESSION['id'],$prof);	
		}else if($arr[0] == "font"){//Шрифты
			echo $shop['price']."|";
			echo $shop['count']."|";
			$prof['money'] -= $shop['price'];
			$prof['font-family'] = $arr[1];
			setFile($_SESSION['id'],$prof);	
			echo "Шрифт ".$arr[1]." удачно установлен.";
			echo "<div class='center' onclick='closeStatus()'><button>Закрыть</button></div>";
		}else if($arr[0] == "class"){//Ефекты
			echo $shop['price']."|";
			echo $shop['count']."|";
			if($prof['class_time'] > time()){
				$prof['class_time'] += 60*60*24*30;
				echo "Эффект продлен на 30 дней (до ".date("j.m.Y",$prof['class_time']).").";
			}else{
				$prof['class_time'] = time() + 60*60*24*30;
				echo "Эффект куплен на 30 дней (до ".date("j.m.Y",$prof['class_time'])."). При продлении до окончания действия эффекта, вы получаете скидку: 50%";
			}
			$prof['money'] -= $shop['price'];
			$prof['class'] = $arr[1];
			setFile($_SESSION['id'],$prof);
			echo "<div class='center' onclick='closeStatus()'><button>Закрыть</button></div>";
		}else if($arr[0] == "obl"){//обложки
			echo $shop['price']."|";
			echo $shop['count']."|";
			$prof['money'] -= $shop['price'];
			$prof['obl'] = $arr[1];
			setFile($_SESSION['id'],$prof);	
			echo "Обложка удачно установлен.";
			echo "<div class='center' onclick='closeStatus()'><button>Закрыть</button></div>";
		}else if($arr[0] == "fon"){//обложки
			echo $shop['price']."|";
			echo $shop['count']."|";
			$prof['money'] -= $shop['price'];
			$arr[1] = str_replace(" ", ".", $arr[1]);
			$prof['fon'] = $arr[1];
			setFile($_SESSION['id'],$prof);	
			echo "Обои удачно установлены.";
			echo "<div class='center' onclick='closeStatus()'><button>Закрыть</button></div>";
		}
		
		//отнимаем количество
		if($shop['count'] > 0){
			$count = $shop['count'] - 1;
			@mysql_query("UPDATE shop SET count='$count' WHERE id='$id' LIMIT 1");
		}
	}else{
		echo "0|0|У Вас недостаточно средств. Перейти в <a href=\"bank.php\"><b>БАНК</b></a> для обмена или покупки виртуальной валюты (бесплатно)";
		echo "<div class='center' onclick='closeStatus()'><button>Ок</button></div>";
	}
}
?>