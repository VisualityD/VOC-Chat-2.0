<?
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
//Статус где пользователь
$profS = getFile($_SESSION['id']);
$profS['on'] = 3;
setFile($_SESSION['id'],$profS);

?>
<!DOCTYPE html>
<html>
  <head>
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all_users.css" type="text/css" />
	<title>Все пользователи | <?=$conf['chatname'];?></title>
	<? include("copy_image.php");?>
</head>
<body>
<? 
$top = 4;
include("top.php");?>
	<div id="main">
		<div id="m_left">
			<div class="m_top">Критерии поиска</div>
			<div class="str first">
				Пол: <select id="sex" onchange="searchSex()">
					<option value="0">Не выбрано</option>
					<option value="1" <?if($_GET['sex'] == 1)echo "selected";?>>Мужской</option>
					<option value="2" <?if($_GET['sex'] == 2)echo "selected";?>>Женский</option>
				<select>
			</div>	
			<div class="str">			
				Страна: <select id="land" onchange="searchLand()">
					<option value="0">Не выбрано</option>
					<?
					$land = "SELECT mini,land FROM land";
					$sql = mysql_query($land);
					$lands = mysql_fetch_array($sql);
					do{
						if($_GET['land'] == $lands['mini'])
							$sel = "selected";
						else
							$sel = "";
						echo "<option value=\"".$lands['mini']."\" $sel>".$lands['land']."</option>";
					}while($lands = mysql_fetch_array($sql));
					?>
				<select>
			</div>	
			<div class="str">
				Город: <input type="text" id="city" value="<?=$_GET['city'];?>">
			</div>	
			<div class="str">
				Статус: <select id="sp" onchange="searchSp()">
					<option value="0">Не выбрано</option>
					<?					
						$spt[1] = "Влюблен(а)";
						$spt[2] = "Есть партнер";
						$spt[3] = "Не в браке";
						$spt[4] = "В разводе";
						$spt[5] = "В браке";
						foreach($spt as $key => $value){
							if($_GET['sp'] == $key)
								$sel = " selected";
							else
								$sel = "";
							echo "<option value=\"$key\"$sel>$value</option>";
						}
					?>
				</select>
			</div>	
			<div class="str">
				<label><input type="checkbox" id="online" onchange="online()" <? if($_GET['o'] == 1) echo "checked";?>> Кто Online</label>
			</div>
			<div class="str">
				<label><input type="checkbox" id="photo" onchange="photo()" <? if($_GET['ph'] == 1) echo "checked";?>> C фотографией</label>
			</div>
			<div class="hr2"></div>
			<p class="sbros"><a href="all.php">Сбросить поиск</a></p>
		</div>		
		<div id="m_right">
			<div class="m_top">Результаты поиска</div>
			<div class="str2">
				<form class="search form-search" onSubmit="search(); return false;">
					Поиск: <input type="text" id="name" class="input-medium search-query" onkeyup="onchangeSearch();" value="<?=str_replace("+"," ",$_GET['name']);?>" placeholder="Введите ник или имя/фамиллия пользователя">
					<button class="btn btn-info">Поиск</button>
					<!--<input type="radio" value="1" name="type"> Имя фамилия
					<input type="radio" value="2" name="type"> Ник
					<input type="radio" value="3" name="type"> Все-->
				</form>
				
				
			  
				<div id="users"></div>
			
			</div>
		</div>		
	</div>
	<script type="text/javascript" src="js/xmlhttprequest.js"></script>
	<script type="text/javascript" src="js/nophp.js"></script>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
	<script type="text/javascript" src="js/all.js"></script>
	<script type="text/javascript" src="js/all_users.js"></script>
	<script>
		loadUsers('<?=$_SERVER['QUERY_STRING'];?>');
		$id('name').focus();
		var loadSearch = $id('name').value;
		var city = $id('city').value;
		setInterval("if($id('name').value.length > 2 && loadSearch != $id('name').value){ search(); loadSearch = $id('name').value;}", 3000);
		setInterval("if(city != $id('city').value){ searchCity(); city = $id('city').value;}", 1500);
	</script>
	<? include("copy.php");?>
</body>
</html>