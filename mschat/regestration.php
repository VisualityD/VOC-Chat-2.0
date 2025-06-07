<?
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
if(isset($_POST['login']) and isset($_POST['pass']) and strlen($_POST['mail'])>5){
	$login = hts('login');
	$pass = hts('pass');
	$mail = hts('mail');
	
	if($_SESSION['code'] != hts('code'))
		erorReg("Вы ввели не верный код с картинки, попробуйте еще раз");
	
	if (!preg_match("/[0-9a-zA-Z_-]/i", $login))
		$no_reg = 'Не корректный логин';
		
	if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $mail))
		$no_reg = 'Не корректный e-mail';
	
	//проверяем длину пароля
	if(strlen($pass) < $conf['passmin'])
		$no_reg = "Пароль должен быть не менее ".$conf['passmin']." символов";
		
	//проверяем длину логина
	if((mb_strlen($login, "utf-8") < $conf['loginmin']) || (mb_strlen($login, "utf-8") > $conf['loginmax']))
		$no_reg = "Логин должен быть не менее ".$conf['loginmin']." и не более ".$conf['loginmax']."символов! Ваш логин содержит: ".mb_strlen($login, "utf-8");	

	//проверяем свободен ли логин
	$lodin_y = "SELECT id FROM users WHERE login='$login' LIMIT 1";
	$lodin_yes = mysql_query($lodin_y);
	$lodin_yes = mysql_fetch_array($lodin_yes);
	if($lodin_yes['id'] or $login == $conf['boot'])
		$no_reg = 'Пользователь с таким логином уже зарегистрирован';
		
	//проверяем свободен ли mail
	$mail_y = "SELECT id FROM users WHERE mail='$mail' LIMIT 1";
	$mail_yes = mysql_query($mail_y);
	$mail_yes = mysql_fetch_array($mail_yes);
	if($mail_yes and $mail_yes['id'])
		$no_reg = 'Пользователь с таким e-mail уже зарегистрирован, если вы забыли пароль, восстановите его через "Восстановление пароля"';
	
	if($no_reg)
		erorReg($no_reg);
		
	if($_POST['sex'] == 1)
		$sex = 1;
	else
		$sex = 2;
	$md_pass = md5($pass);
	$ip = $_SERVER['REMOTE_ADDR'];
	//регаем
	$data = time();
	
	$hash = md5($data."skiptoff");
	// $hash = substr($hash, 2, 12);
    $hash = 1;
	
	$res = mysql_query ("INSERT INTO users (login,pass,mail,data_reg,ip,sex,activ) VALUES('$login', '$md_pass', '$mail', '$data', '$ip','$sex','$hash')");
	
	//Создаем папку пользователя 
	$sql_id_regg = "SELECT id FROM users WHERE login='$login' LIMIT 1";
	$sql_id_regg = mysql_query($sql_id_regg);
	$sql_id_regg = mysql_fetch_array($sql_id_regg);
	
	if($sql_id_regg['id'] > 0){
		//создаем папки
		$num = floor($sql_id_regg['id']/1000);
		$dir_save = "users/".$num;
		if(!is_dir($dir_save))
			mkdir($dir_save, 0777);
		$dir_save = "users/".$num.'/'.$sql_id_regg['id'];
		if(!is_dir($dir_save))
			mkdir($dir_save, 0777);
		$dir_save = "users/".$num.'/'.$sql_id_regg['id']."/photos";
		if(!is_dir($dir_save))
			mkdir($dir_save, 0777);
		//записываем минимальное в файл настроек
		$prof['money'] = 0;
		$prof['point'] = 0;
		setFile($sql_id_regg['id'],$prof);	
	}else{
		$res = false;
	}
	//отправляем mail с данными
	if($res){
		$titl = $conf['namechat']." | Вы зарегистрированы";
		$titl = "Вы были успешно зарегисрированы в нашем чате ".$conf['namechat'].", Ваш логин: $login, пароль: $pass, ".$conf['url']." Для снятия всех ограничений перейдите по ссылке ".$conf['url']."activ.php?l=$login&h=$hash";
		
		/*if (!$hostvoc) {
			mail($mail, $titl, $text, "Content-type:text/plane; Charset=".$conf['mycode']."\r\n");
		}*/
		
		// echo "Вы успешно зарегистрированы, теперь можете войти в чат. На Вашу почту были высланы данные профиля чтобы вы их не забыли и ссылка активации для снятия ограничений в чате. Спасибо!<br>";
		echo "Вы успешно зарегистрированы, теперь можете войти в чат. Спасибо!<br>";
		//перенаправляем в чат
		$_SESSION['login'] = $login;		
		unset($_SESSION['pass']);
		
		
		exit;
	}else{
		echo "Извините, что то пошло не так, Вы не зарегистрированы, попробуйте снова или обратитесь к администрации чата!";
		exit;
	}
}
$login = $_GET['login']
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="<?=$css_url;?>regestration.css" type="text/css" />
	<title>Регистрация нового пользователя</title>
	<style>
	.code{		
		text-align:center;
		border:1px solid #e9afaf;
		width: 200px;
		padding:5px;
		margin:auto;
		margin-top: 10px;
		margin-bottom: 10px;
		background-color:#ffefef;
		color:#9c4949;
	}
	#code{
		cursor:pointer;
		height:30px;
		background-image: url('<?=$image_url;?>progress.gif');
		background-position:50% 50%;
		background-repeat: no-repeat;
	}
	</style>
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<script>
		function obn(){
			$id('code').innerHTML = "<img src=\"code/my_codegen.php?o="+Math.random()+"\" onclick=\"obn()\">";
		}
	</script>
</head>
<? include("top.php");?>	
	<div id="main">
		<div id="m_left">
			<div class="m_top">Меню</div>
			<a class="p_menu" href="<?php echo $conf['url']; ?>index.php"><i class="icon-home"></i> &nbsp; На главную</a>
			<a class="p_menu" href="<?php echo $conf['url']; ?>regestration.php"><i class="icon-plus-sign"></i> &nbsp; Регистрация</a>
			<a class="p_menu" href="<?php echo $conf['url']; ?>index.php"><i class="icon-ok"></i> &nbsp; Авторизация</a>
			<a class="p_menu" href="<?php echo $conf['url']; ?>all.php"><i class="icon-search"></i> &nbsp; Люди / поиск</a>
			<a class="p_menu" href="<?php echo $conf['url']; ?>pages/new.php"><i class="icon-list-alt"></i> &nbsp; Что нового?</a>
			<a class="p_menu" href="<?php echo $conf['url']; ?>pages/rules.php"><i class="icon-flag"></i> &nbsp; Правила</a>
			<a class="p_menu" href="<?php echo $conf['url']; ?>pages/statistic.php?msgs"><i class="icon-signal"></i> &nbsp; Статистика</a>
		</div>		
		<div id="m_right">
			<div class="m_top">Регистрация</div>
			<form action="regestration.php" method="post">
				<div class="reg">			
					<div class="str control-group" id="div-login">
						<div class="str">
							<label>
								<span class="left">
									<label class="control-label" for="inputError">Логин:</label>
								</span>
								<input type="text" name="login" class="input" value="<?=$login;?>">
							</label>
						</div>
					</div>
					
					<div class="str control-group" id="div-pass">
						<label>
							<span class="left">
								 <label class="control-label" for="inputError">Пароль:</label>
							</span>
							<input type="password" name="pass" class="input" value="<?=$pass;?>">
						</label>
					</div>
					
					<div class="str control-group" id="div-mail">
						<div class="str">
						<label>
							<span class="left">
								<label class="control-label" for="inputError">email:</label>
							</span>
							<input type="text" name="mail" class="input" value="<?=$mail;?>">
						</label>
						</div>
					</div>
					
					<div class="str"><label><span class="left">
					Пол
					</span>
						<select name="sex" class="input">
							<option value="1">Мужской</option>
							<option value="2">Женский</option>
						</select>
					</label></div>
					<div class="code">
						<label>
							<div id="code"><img src="code/my_codegen.php" onclick="obn()"></div>
							<br>Введите код с картинки:<br>
							<input type="text" name="code" class="input">
							<br><u onclick="obn()">Не видно картинку?</u>
						</label>
					</div>
					<div class="center rull">Регестрируясь на сайте Вы автоматически соглашаетесь с <a href="<?php echo $conf['url']; ?>pages/rules.php" target="_blank">правилами</a> сайта и обязуетесь их соблюдать.</div>
					<div class="center"><button class="btn btn-primary" id="reg">Регистрация</button></div>
					<div class="center" id="status"></div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/nophp.js"></script>
<script type="text/javascript" src="js/regestration.js"></script>
<?php include("copy.php");?>
</body>
</html>