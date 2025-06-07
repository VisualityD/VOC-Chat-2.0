<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../common.php");
require_once("../connect.php");
require_once("function.php");
if(!$_SESSION['admin'])exit("no-admin");
?>
<!DOCTYPE html>
<html>
  <head>
	<link rel="stylesheet" href="css/all.css" type="text/css" />
	<title>Супер админка</title>
</head>
<body>
	<div id="top">Добро пожаловать в супер админку</div>
	<div id="left">
		<ul>
			<li><a href="index.php?a=1">Файлы пользователей</a></li>
			<li><a href="index.php?a=2">База пользователей</a></li>
		</ul>
	</div>
	<div id="main">
	<?php
	switch ($_GET['a']) {
		case 1:
			include("file_users.php");
			break;
		case 2:
			include("sql_users.php");
			break;
		default:
			echo "Ничего не выбрано";
	}
	?>
	</div>
</body>
</html>