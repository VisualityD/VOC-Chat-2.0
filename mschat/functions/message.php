<?php
function addMess($author,$text,$komu=0,$privat=0){
//отправка сообщения
	$dt = time();
	if($privat == 1 and $komu>0)
		mysql_query ("INSERT INTO mess (author,date,text,polychatel,privat) VALUES('$author','$dt','$text','$komu','1')");
	else
		mysql_query ("INSERT INTO mess (author,date,text) VALUES('$author','$dt','$text')");
}
?>