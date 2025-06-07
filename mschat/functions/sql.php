<?php
if (!defined("_COMMON_")) exit("<h3>Файл настроек не найден. Доступ запрещен. перейдите на главную страницу и попробуйте еще раз</h3>");

$connection = new mysqli('127.0.0.1', $conf['myuser'], $conf['mypassword'], $conf['mydatabase'], $conf['myport']);
exit;
@mysqli_select_db($conf['mytable']) or die ('Нету данных с базы. Обратитесь к администрации');
$char = $conf['mycode'];
mysqli_query ("SET CHARACTER SET $char");
mysqli_query("SET NAMES $char");
mysqli_query( "set session character_set_server=$char;");
mysqli_query( "set session character_set_database=$char;");
mysqli_query( "set session character_set_connection=$char;");
mysqli_query( "set session character_set_results=$char;");
mysqli_query( "set session character_set_client=$char;");