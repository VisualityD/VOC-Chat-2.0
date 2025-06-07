<?
header("Content-type: text/html;charset=utf-8");
$time = time();
//авторизация через session
if(isset($_SESSION['login']) and isset($_SESSION['pass'])){
	$login = strip_tags($_SESSION['login']);
	$pass = strip_tags($_SESSION['pass']);
	$sql_text_prov = "SELECT ban,id FROM users WHERE login='$login' AND pass='$pass'	LIMIT 1";
	$sql_prov = mysql_query($sql_text_prov);
	$sql_prov_arr = mysql_fetch_array($sql_prov);
	if(!$sql_prov_arr['id'])
		noReg();
	if($sql_prov_arr['ban'] == 1)
		banned();
	//авторизация прошла успешно
	$_SESSION['id'] = $sql_prov_arr['id'];

	$connect = true;
//авторизация через session
}else if(isset($_POST['login']) and isset($_POST['pass'])){
	//отправляем на регистрацию если нету пароля или логин не существует
	$login = hts('login');	
	$sql_text_regg = "SELECT id FROM users WHERE login='$login' LIMIT 1";
	$sql_text_regg = mysql_query($sql_text_regg);
	$sql_text_regg = mysql_fetch_array($sql_text_regg);
	if($sql_text_regg['id'] < 1)
		go('regestration.php?login='.$_POST['login']);
	//
	$login = trim(strip_tags($_POST['login']));
	$pass = md5(trim(strip_tags($_POST['pass'])));
	$sql_text_prov = "SELECT id,ban,mail,sex,admin,photo,activ FROM users WHERE login='$login' AND pass='$pass'	LIMIT 1";
	$sql_prov = mysql_query($sql_text_prov);
	$sql_prov_arr = mysql_fetch_array($sql_prov);
	if(!$sql_prov_arr['id'])
		noReg();
	if($sql_prov_arr['ban'] == 1)
		banned();
	//авторизация прошла успешно
	if(isset($_POST['add'])){
		//заносим куки
		setcookie ("login", $login,time()+$coocie_time);
		setcookie ("pass", $pass,time()+$coocie_time);
	}	
	$_SESSION['login'] = $login;
	$_SESSION['pass'] = $pass;
	$_SESSION['mail'] = $sql_prov_arr['mail'];
	$_SESSION['id'] = $sql_prov_arr['id'];
	$_SESSION['sex'] = $sql_prov_arr['sex'];
	$_SESSION['admin'] = $sql_prov_arr['admin'];
	$_SESSION['photo'] = $sql_prov_arr['photo'];
	$_SESSION['activ'] = $sql_prov_arr['activ'];
	$connect = true;
//авторизация через coockie
}else if(isset($_POST['coo'])){
	$login = strip_tags($_COOKIE['login']);
	$pass = strip_tags($_COOKIE['pass']);
	$_SESSION['login'] = $login;
	$_SESSION['pass'] = $pass;
	$sql_text_prov = "SELECT id,ban,mail,sex,admin,photo,activ FROM users WHERE login='$login' AND pass='$pass' LIMIT 1";
	$sql_prov = mysql_query($sql_text_prov);
	if($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);
	if(!$sql_prov_arr['id'])
		go("chat.php");
	if($sql_prov_arr['ban'] == 1)
		banned();
	//авторизация прошла успешно, продлеваем куки
	setcookie ("login", $login,time()+$coocie_time);
	setcookie ("pass", $pass,time()+$coocie_time);
	$_SESSION['mail'] = $sql_prov_arr['mail'];
	$_SESSION['id'] = $sql_prov_arr['id'];
	$_SESSION['sex'] = $sql_prov_arr['sex'];
	$_SESSION['admin'] = $sql_prov_arr['admin'];
	$_SESSION['photo'] = $sql_prov_arr['photo'];
	$_SESSION['activ'] = $sql_prov_arr['activ'];
	$connect = true;
	header("Location: chat.php");
	exit;
}



//проверяем ip
$ip = $_SERVER['REMOTE_ADDR'];
$result00c = mysql_query("SELECT COUNT(*) FROM users WHERE ip='$ip' AND online='1'");
	if($result00c > 0){$tempc = mysql_fetch_array($result00c);}
	if($tempc[0] > 0) {$ips = $tempc[0];}else{$ips = 0;}
	if($ips > $conf['ip'])
		erorLog("Слишко много пользователей с 1 ip аддреса");
//заносим онлайн
$online_scan = "SELECT online,onlinetime FROM users WHERE login='$login' AND pass='$pass'	LIMIT 1";
$online_scan = mysql_query($online_scan);
$online_scan = mysql_fetch_array($online_scan);
$online = $online_scan['online'];
$onlinetime = $online_scan['onlinetime'];
if($online == 0 && $connect){
	$res = mysql_query("UPDATE users SET online='1', onlinetime='$time', ip='$ip' WHERE login='$login' AND pass='$pass'");
	/*if($res) 
		addMess($conf['boot']," <b>$login</b> входит в чат, приветствуемс!");*/
}
$rand = rand(1,100);
if($rand > 40 && $connect)
	mysql_query("UPDATE users SET onlinetime='$time' WHERE login='$login' AND pass='$pass'");
if($_SESSION['sex'] == 1)
	$globale = $lang['boys_post'];
else
	$globale = $lang['girls_post'];

include("cron.php");
?>