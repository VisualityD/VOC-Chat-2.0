<?php
//подгружаем товар в магазине
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../common.php");
//вынимаем данные пользователя
$inc = 1; //сколько раз назад к корню
$prof = getFile($_SESSION['id']);
if($_GET['c']){
	$c = intval($_GET['c']);
	$and = "";
	$type = intval($_GET['t']);
	if($type > 0)
		$and = " AND type=".$type;
	$shop_text = "SELECT id,title,text,img,count,price,function FROM shop WHERE cat='$c' AND hidden = '0' $and  ORDER BY price,count"; 
	$shop_sql = mysql_query($shop_text);
	$shop = mysql_fetch_array($shop_sql);
	if($shop)
	do{
		$butt = "Купить";
			
		$arr = explode(".",$shop['function']);
		
		if(($shop['function'] == "gradient" && $prof['gradient'] > time()) || ($arr[0] == "class" && $prof['class_time'] > time() && $prof['class'] == $arr[1])){
			$shop['price'] = intval($shop['price']/2);
			$butt = "Продлить";
		}
			
		if($shop['price'] > $prof['money']){
			$style1 = "shop_butt_no";
			$style2 = "s_prise_no";
		}else{
			$style1 = "shop_butt";
			$style2 = "s_prise_n";
		}
		//////////////
		// Для чата
		//////////////
		if($c == 1){
			
			//количество
			if($shop['count'] == (-1))
				$count = "";
			else if($shop['count'] == 0){
				$count = "Количество: <b style='color:red;'>Нету</b>";
				$style1 = "shop_butt_no";
			}else
				$count = "Количество: <b>".$shop['count']."</b>";
			?>				
			<div class='shop_item'>
				<div class="shop_left"><img src="shop/<?=$shop['img'];?>" width="80"></div>
				<div class="shop_vertical"></div>
				<h4><?=$shop['title'];?></h4>
				<div class="shop_text">
					<?=$shop['text'];?>
				</div>
				<div class="shop_bottom">					
					<button class="<?=$style1;?>" onclick="by(<?=$shop['id'];?>)"><?=$butt;?></button>
					<div class="shop_prise">Цена: <span class="<?=$style2;?>"><?=$shop['price'].$lang['shop_money'];?></span></div>
					<div class="shop_prise color_count"><?=$count;?></div>
				</div>
			</div>
			<?
		}
		//////////////
		// профиль.обложки
		//////////////
		if($c == 2 && $type == 1){
			
			//количество
			if($shop['count'] == (-1))
				$count = "";
			else if($shop['count'] == 0){
				$count = "Количество: <b style='color:red;'>Нету</b>";
				$style1 = "shop_butt_no";
			}else
				$count = "Количество: <b>".$shop['count']."</b>";
			?>				
				<div class='shop_item'>
					<div class="shop_left_obl"><img src="shop/obl/<?=$shop['img'];?>.jpg" width="300"></div>
					<h4><?=$shop['title'];?></h4>
					<div class="shop_text_obl">
						<?=$shop['text'];?>
					</div>
					<div class="shop_col"><?=$count;?></div>
					<button class="<?=$style1;?>" onclick="by(<?=$shop['id'];?>)">Установить | <?=$shop['price'].$lang['shop_money'];?></button>
				</div>
			<?
		}
		
		//////////////
		// профиль.обои
		//////////////
		if($c == 2 && $type == 2){
			
			//количество
			if($shop['count'] == (-1))
				$count = "";
			else if($shop['count'] == 0){
				$count = "Количество: <b style='color:red;'>Нету</b>";
				$style1 = "shop_butt_no";
			}else
				$count = "Количество: <b>".$shop['count']."</b>";
			?>				
				<!--<div class='shop_item_fon'>
					<div class="shop_left_fon"><img src="shop/fon/<?=$shop['img'];?>"></div>
					<h4><?=$shop['title'];?></h4>
					<div class="shop_text_fon">
						<?=$shop['text'];?>
					</div>
					<div class="shop_col"><?=$count;?></div>
					<button class="<?=$style1;?>" onclick="by(<?=$shop['id'];?>)">Установить | <?=$shop['price'].$lang['shop_money'];?></button>
				</div>-->
				<div class='shop_item_fon'>
					<div class="shop_img_fon" style="background-image:url(fon/<?=$shop['img'];?>)">
						<br>
						<h4><?=$shop['title'];?></h4>
						<div class="shop_col_fon"><?=$count;?></div>
					</div>
					<button class="<?=$style1;?>" style="margin-top:5px; padding-left:10px; padding-right:10px; background-image:none; float:none" onclick="by(<?=$shop['id'];?>)">Установить <?=$shop['price'].$lang['shop_money'];?></button>
				</div>
			<?
		}
	}while($shop = mysql_fetch_array($shop_sql));
}
?>