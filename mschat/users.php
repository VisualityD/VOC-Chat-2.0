<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
$filter = intval($_GET['f']);
//функция вывода категории и пользователей данной категории
function printUsersGlobal($sql,$click,$frase,$html_all,$html_user)
{
	global $image_url, $filter;
	//вынимаем пользователей
	$online_users = "SELECT id,login,photo,city,sex,admin,sp,name,fname,bday FROM users WHERE ".$sql." ORDER BY photo DESC";
	$online_users = mysql_query($online_users);
	$online_user = mysql_fetch_array($online_users);
	//сколько пользователей в чате
	$user = mysql_query("SELECT COUNT(*) FROM users WHERE ".$sql);
	if($user > 0){$user = mysql_fetch_array($user);}
	if($user[0] > 0) {$cout_users = $user[0];}
	if($cout_users > 0){
		$html_all = str_replace('[who]',$click,$html_all);
		$html_all = str_replace('[whois]',$frase,$html_all);
		$html_all = str_replace('[count]',$cout_users,$html_all);
		echo $html_all;
		do{
			$prof = getFile($online_user['id']); // функция достает данные с файла
			if((($filter == 0) || ($filter == 1 && $prof['on'] == 1 || $online_user['sex'] == 0) || ($filter == 2 && $prof['on'] == 2) || ($filter == 3 && $prof['on'] == 3) || ($filter == 4 && $prof['on'] == 4)) && $prof['hidden'] != 1){
				if($prof['htmlnik'])
					$nik = $prof['htmlnik'];
				else
					$nik = $online_user['login'];
					
				$print_users = str_replace("[login]",$online_user['login'],$html_user);
				$print_users = str_replace("[htmlnik]",$nik,$print_users);
				
				if(strlen($online_user['photo']) > 1){
					$photo = "users/".floor($online_user['id']/1000).'/'.$online_user['id']."/photos/1/makro".$online_user['photo'];
					//всплывающее окно
					$nam = "";
					if($online_user['name']) $nam = "<br><b>".$online_user['name']."</b>";
					if($online_user['city']){ 
						if($online_user['name']) $nam .= ","; 
						$nam .= "<br><small>".$online_user['city']."</small>"; 
					}
					///определяем возраст
					$vozrast = vozrast($online_user['bday']);
					if($vozrast){
						if($online_user['city']) $nam .= ", "; 
						$nam .= $vozrast;
					}
					//
					$window = "<img src=users/".floor($online_user['id']/1000).'/'.$online_user['id']."/photos/1/mini".$online_user['photo']." class=miniphoto>".$nam;
					//
				}else{
					$photo = $image_url."nophoto.png";
					$window = "";
				}
				//Vip, рейтинг,
				if($prof['on']){ //статус где пользователь
					switch($prof['on']){
					case 1:
						$title = "В чате";
						break;
					case 2:
						$title = "В магазине";
						break;
					case 3:
						$title = "В профиле";
						break;
					case 4:
						$title = "В банке";
						break;
					}
					$pic .= "<div class='usersPicno'><img src='".$image_url."status/".$prof['on'].".png' border='0' title='".$title."' alt='статус'></div>";
				}
				if($prof['rang']) //звание
					$pic .= "<div class='usersPic' title='Ранг'>".$prof['rang']."</div>";
				
				if($prof['show_moder'] && $online_user['admin']) //Модератор
					$pic .= " <img src='".$image_url."status/mod.png' border='0' title='Модератор чата'>";
				
				if($prof['vip']) //vip
					$pic .= "<div class='usersPicvip' title='VIP'>&nbsp;V&nbsp;</div>";
					
				//Семейное положение - женато в чате				
				if($online_user['sp'] == 1){
					if($online_user['sex'] == 2) $tit = "Замужем в чате"; else $tit = "Женат в чате";
					$pic .= " <img src='".$image_url."status/ring.png' border='0' title='С/П: $tit'>";
				}
				//статус
				if($prof['imgstatus']) 
					$status = " <img style='margin-bottom:-7px;' src='status/".$prof['imgstatus']."' height='18' onmouseover=\"info('<center><img src=status/".$prof['imgstatus']."></center><br>".$prof['statustext']."');\" onmouseout=\"info('');\" title='Статус пользователя'>";
				else
					$status = "";
				$print_users = str_replace("[img]",$photo,$print_users);
				$print_users = str_replace("[profile]",$conf['url']."id".$online_user['id'],$print_users);
				$print_users = str_replace("[window]",$window,$print_users);
				$print_users = str_replace("[pic]",$pic,$print_users);
				$print_users = str_replace("[status]",$status,$print_users);
				unset($pic);
				
				echo $print_users;
			}
		}while($online_user = mysql_fetch_array($online_users));
	}
}


$div_user_girls = "<div class='girls'><div class='usersLeft'><a href='[profile]'><img width='30' src=\"[img]\" border='0' align='middle' onmouseover=\"info('[window]');\" onmouseout=\"info('');\" class='userinlistphoto'></a></div><div class='usersRight'><u class='pointer users' onclick=\"addUser('[login]');\">[htmlnik]</u>[status]<div class='br'></div>[pic]</div></div>";
$div_user_boys = "<div class='boys'><div class='usersLeft'><a href='[profile]'><img width='30' src=\"[img]\" border='0' align='middle' onmouseover=\"info('[window]');\" onmouseout=\"info('');\" class='userinlistphoto'></a></div><div class='usersRight'><u class='pointer users' onclick=\"addUser('[login]');\">[htmlnik]</u>[status]<div class='br'></div>[pic]</div></div>";
$div_user_robots = "<div class='robots'><div class='usersLeft'><a href='[profile]'><img width='30' src=\"[img]\" border='0' align='middle' onmouseover=\"info('[window]');\" onmouseout=\"info('');\" class='userinlistphoto'></a></div><div class='usersRight'><u class='pointer users' onclick=\"addUser('[login]');\">[htmlnik]</u>[status]<div class='br'></div>[pic]</div></div>";

$div_global_girls = "<div id=\"u_girls\" onclick=\"addGlobal('[who]');\" class=\"pointer\">[whois] <span class=\"count\">[count]</span></div>";
$div_global_boys = "<div id=\"u_boys\" onclick=\"addGlobal('[who]');\" class=\"pointer\">[whois] <span class=\"count\">[count]</span></div>";
$div_global_robots = "<div id=\"u_robots\" onclick=\"addGlobal('[who]');\" class=\"pointer\">[whois] <span class=\"count\">[count]</span></div>";

//сколько людей в чате
$all = mysql_query("SELECT COUNT(*) FROM users WHERE online='1' or sex='0'");
if($all > 0){$all = mysql_fetch_array($all);}
if($all[0] > 0) {$cout_users = $all[0];}
?>
	<div id="u_all" onclick="addGlobal('ВСЕМ');" class="pointer">ВСЕ <span class="count"><?=$cout_users;?></span></div>
	<? if($_SESSION['admin']){?><div id="u_moder" onclick="addGlobal('<?=$lang['in_moders'];?>');" class="pointer">Модераторы</div><?}?>
<?

printUsersGlobal("online='1' and sex='2'",$lang['girls_post'],$lang['girls'],$div_global_girls,$div_user_girls);
printUsersGlobal("online='1' and sex='1'",$lang['boys_post'],$lang['boys'],$div_global_boys,$div_user_boys);
printUsersGlobal("sex='0'",$lang['robots_post'],$lang['robots'],$div_global_robots,$div_user_robots);
?>