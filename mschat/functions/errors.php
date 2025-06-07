<?php
function globalError($title,$text){
	echo "<div style='width:500px; border:1px solid black; color: white; background-color: red; font-family: tahoma,verdana,sans-serif; margin:auto; padding:5px 10px; margin-top:100px;'><b>",
		$title,
		"</b><div style='border:1px solid black; color: black; background-color: white; font-family: tahoma,verdana,sans-serif; font-size:15px; padding:5px; margin-top:10px;'>",
		$text,
		"</div></div>";
	exit;
}
function noReg(){
	exit('Не верный логин или пароль!');
}
function noActiv(){
	exit("Ошибка! Нет прав доступа! Активируйте аккаунт пройдя по ссылке и e-mail письма которое было выслано Вам при регистрации. Если возникли проблемы обратитесь к администрации сайта. Все контакты указаны на главной странице. Так же Вам не начисляются бонусы пока аккаунт не будет активирован.");	
}
function banned(){
	$login = $_SESSION['login'];
	//может пора разбанить))
	$sql_text_prov = "SELECT id,time,min FROM ban WHERE user='$login' AND type='1' LIMIT 1";
	$sql_prov = mysql_query($sql_text_prov);
	if($sql_prov)$sql_prov_arr = mysql_fetch_array($sql_prov);
	if($sql_prov_arr['time']+$sql_prov_arr['min'] > time()){
		header("Location: baned.php");
		exit('Вы отключены от чата!');
	}else{
		//разбаним
		@mysql_query("UPDATE users SET ban='0' WHERE login='$login'");
		@mysql_query ("DELETE FROM ban WHERE id='".$sql_prov_arr['id']."'");
	}
}
function erorReg($no_reg){
	echo "<div style='width:500px; border:1px solid black; color: white; background-color: red; font-family: tahoma,verdana,sans-serif; margin:auto; padding:5px 10px; margin-top:100px;'><b>
		 Ошибка
		 </b><div style='border:1px solid black; color: black; background-color: white; font-family: tahoma,verdana,sans-serif; font-size:15px; padding:5px; margin-top:10px;'>",
		 $no_reg,
		 "
		 <br><br><br>
		 <center><a href='regestration.php'>Назад</a></center>
		 </div></div>";
	exit;
}
function erorLog($no_reg){
	echo "<div style='width:500px; border:1px solid black; color: white; background-color: red; font-family: tahoma,verdana,sans-serif; margin:auto; padding:5px 10px; margin-top:100px;'><b>
		 Ошибка
		 </b><div style='border:1px solid black; color: black; background-color: white; font-family: tahoma,verdana,sans-serif; font-size:15px; padding:5px; margin-top:10px;'>",
		 $no_reg,
		 "
		 <br><br><br>
		 <center><a href='index.php'>Назад</a></center>
		 </div></div>";
	exit;
}
?>