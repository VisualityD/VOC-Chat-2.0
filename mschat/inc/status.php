<?php
//Смайлы которые отображаются в плавающем окошке
session_start();
require_once("common.php");
//достаем
$status_file = File($data_dir."status/all.dat");
$br=2;
for ($st=0; $st<count($status_file); $st++){
	$expl = explode("^", $status_file[$st]);
	$Sttext .= "<td width=\"10%\" class=\"statuscat\" onclick=\"addTextInStatus('".$expl[1]."'), saveStatus('".$expl[0]."')\"><img src=\"status/".$expl[0]."\"></td>";
	if($br>=10){
		$Sttext .= "<td>&nbsp;</td></tr><tr>";
		$br=0;
	}
	$br++;
}
?>
<table width="100%">
	<tr>
		<td width="25" class="statuscat" onclick="addTextInStatus('none'), saveStatus('none')">Нет</td>
		<?  echo $Sttext; ?>
	</tr>
</table>