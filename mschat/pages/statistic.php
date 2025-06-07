<?php
//Файл отвечает за вывод информации забаненым
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../common.php");
$now = time();

if(isset($_GET['online'])){
	///статистика онлайна
	$yesreday = $now - (60*60*24);
	$yesreday = date("d-m-Y", $yesreday);

	$to_yesreday = $now - (60*60*24*2);
	$to_yesreday = date("d-m-Y", $to_yesreday);

	$today = file_get($data_dir."statistic/online/".date("d-m-Y").".dat"); //сегодня
	$yesreday = file_get($data_dir."statistic/online/".$yesreday.".dat"); //вчера
	$to_yesreday = file_get($data_dir."statistic/online/".$to_yesreday.".dat"); //позавчера

	$today = explode("\n",$today);
	$yesreday = explode("\n",$yesreday);
	$to_yesreday = explode("\n",$to_yesreday);
	//конец статистики онлайна
} else if (isset($_GET['msgs'])) {
	$msgs = file_get($data_dir."statistic/msgs/array.dat");
	$msgs = explode("\n",$msgs);

}
?>
<!DOCTYPE html>
<html>
  <head>
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>pages.css" type="text/css" />
	<style>
	#main{
		background-color:#fff;
		border:1px solid black;
		width:870px;
	}

	</style>
	<title>Статистика | <?=$conf['chatname'];?></title>
	<? include("../copy_image.php");?>
</head>
<body>
<? include("../top.php");?>	
	<div id="main">
		<div class="m_top">Статистика</div>
		
		<?php if(isset($_GET['online'])){?>
			<div id="chart_div" style="width: 870px; height: 400;"></div>
			<div class="center statistic-url">
				<a href="<?php echo $conf['url']; ?>pages/statistic.php?msgs"><u>Статистика сообщений</u></a>
			</div>
			<!--Load the AJAX API-->
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
			  google.load("visualization", "1", {packages:["corechart"]});
			  google.setOnLoadCallback(drawChart);
			  function drawChart() {
				var data = google.visualization.arrayToDataTable([
				  ['Время', 'Позавчера', 'Вчера', 'Сегодня'],
				  <?php 
				  foreach($yesreday as $key => $value){
				  
					$yesreday_arr = explode("|",$value);
					$today_arr = explode("|",$today[$key]);
					$to_yesreday_arr = explode("|",$to_yesreday[$key]);
					
					if(strlen($yesreday_arr[0]) > 0){
						if($key != 0) echo ",";
						echo "['".$yesreday_arr[0]."',".intval($to_yesreday_arr[1]).", ".intval($yesreday_arr[1]).", ".intval($today_arr[1])."]";
					}
					
				  }
				  ?>
				]);

				var options = {
				  title: 'Пользователей онлайн / время'
				};

				var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			  }
			  
			</script>
		<?php } else if (isset($_GET['msgs'])) { ?>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
			  google.load("visualization", "1", {packages:["corechart"]});
			  google.setOnLoadCallback(drawChart);
			  function drawChart() {
				var data = google.visualization.arrayToDataTable([
				  ['Дата', 'Сообщений']
				  <?php
				  //$msgs_arr
				  for($i = 17; $i>0;$i--){
					$arr = explode("|", $msgs[count($msgs) - $i]);
					if(strlen($arr[0]) > 0)
						echo ",['".$arr[0]."',".intval($arr[1])."]";
				  }
				  
				  ?>
				]);

				var options = {
				  title: 'Сообщений в день',
				  hAxis: {title: 'SocFriends.ru',  titleTextStyle: {color: 'blue'}}
				};

				var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			  }
			</script>
			<div id="chart_div" style="width: 870px; height: 500px;"></div>
			<div class="center statistic-url">
				<a href="<?php echo $conf['url']; ?>pages/statistic.php?online"><u>Статистика online пользователей</u></a>
			</div>
		<?php } ?>
	<? include("../copy.php");?>
</body>
</html>