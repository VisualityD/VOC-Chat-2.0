<?php
//Смайлы которые отображаются в плавающем окошке
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../common.php");
//достаем смайлы
$smile_file = File($data_dir."smiles/all.dat");
//Количество столбцов
if($_GET['c']){
	$c = intval($_GET['c']);
	setcookie ("smileW", $c,time()+$coocie_time);
}else
	$c = 5;
//Категории
if($_GET['k']){
	$k = intval($_GET['k']);
}else
	$k = 0;
$br = 1;
$count = 0;
for ($smi=0; $smi<count($smile_file); $smi++){
	$expl = explode("^", $smile_file[$smi]);
	if($expl[0] == $k){
		$text .= "<td class='trsmile'><img align='middle' class='pointer' border='0' title='".$expl[2]."' onclick=\"addSmile('".$expl[1]."')\" src='smiles/".$expl[3]."'> </td>";
		if($br > $c){
			$br = 0; $text .= "<td>&nbsp;&nbsp;&nbsp;</td></tr><tr>";
		}
		$br++;
		$count++;
	}
}
?>
<table>
	<tr>
	<?  echo $text; ?>
	</tr>
</table>
<?
	//Сколько всего смайлов
	echo "<input type=\"hidden\" value=\"".$count."\" id=\"countSmile\">";
?>