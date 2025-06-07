<?php
if(!$_SESSION['admin'])exit("no-admin");
include("info_field.php");
?>
<form method="post">
	id пользователя:<input type="text" name='id' value="<?=intval($_POST['id']);?>">
	<button>Показать</button>
</form>
<hr>
<?php
//сохраняем
if(isset($_POST['save'])){
	foreach($_POST as $key => $value){
		if($key != 'id' && $value != ""){
			$prof[$key] = $value;
		}
	}
	setFileAdmin($_POST['id'],$prof);
	echo "<b>Сохранено</b><hr>";
}
//выводим
if(intval($_POST['id'])){	
	$prof = getFileAdmin(intval($_POST['id']));
	if(count($prof)){
		echo "Логин: <b>".getLogin(intval($_POST['id']))."</b>";
		echo "<form action='index.php?a=1' method='post'>";
		echo "<input type='hidden' name='id' value='".intval($_POST['id'])."'>";
		echo "<input type='hidden' name='save' value='1'>"; //чтоб начало записывать
		echo "<table id='table'>";
		foreach($prof as $key => $value){
			if($key != 'save'){
				//title
				$title = "";
				for($i = 0; $i<count($field); $i++){
					if($field[$i]['name'] == $key){
						$title = $field[$i]['value'];
						break;
					}
				}
				echo "<tr><td>$key: &nbsp;</td><td> <input type='text' name='$key' value='$value' title='$title'></td></tr>";
			}
		}
		echo "</table>";
		echo "<p>+<a href='javascript:addField()'>Добавить поле</a></p>";
		echo "<button>Сохранить</button>";
		echo "</form>";
		$st = true;
	}else
		echo "<p>Пользователя не существует</p>";
}
?>
<script>
function addField(){
	var newField = prompt("название на англ.", "");
	if(newField){
		var table = document.getElementById('table');
		var tr = document.createElement("tr");
		var td1 = document.createElement("td");
		var td2 = document.createElement("td");
		var inp = document.createElement("input");
		inp.setAttribute("type","text");
		inp.setAttribute("name",newField);
		td2.appendChild(inp);
		tr.appendChild(td1);
		tr.appendChild(td2);
		table.appendChild(tr);		
		var text = document.createTextNode(newField+":");
		td1.appendChild(text);
	}

}
	
</script>
<? if($st == true){?>
	<hr>
	<h3>Все поля:</h3>
	<ul>
		<?php
		sort($field);

		for($i = 0; $i<count($field); $i++){
			echo "<li><b>".$field[$i]['name']."</b> = ".$field[$i]['value'].";</li>";
		}?>
	</ul>
<?}?>