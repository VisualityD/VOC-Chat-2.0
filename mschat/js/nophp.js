/*
Функции без замен php
*/

//получаем по id быстро (типа как в jQuery)
function $id(elemid)
{
	return document.getElementById(elemid); 
}
//добавляем время сообщения
function addTime(time)
{
	var text = $id('text').value;
	$id('text').value = text + ' см.' + time + ' ';
	$id('text').focus();
}
//добавляем смайлы
function addSmile(smile)
{
	var text = $id('text').value;
	$id('text').value = text + " " + smile + " ";
	$id('text').focus();
}
//добавляем ВСЕМ, ... и тд		
function addGlobal(user)
{ 
	$id('from').value = user;
	$id('text').focus();
}
//очищаем приват
function clearPrivate(){
	if(confirm("Вы уверенны что хотите очистить приват?")){
		$id('privat').innerHTML = "";
		$id('text').focus();
	}
}
//очищаем общаг
function clearAll(){
	if(confirm("Вы уверенны что хотите очистить общий канал?")){
		$id('all').innerHTML = "";
		$id('text').focus();
	}
}
//очистка поле ввода
function clearForm(){
	$id('text').value = "";
	$id('text').focus();
}
/*/отправка энтером
document.onkeyup = function(e)
{
	
	e = e || window.event;
	
	var ctrl = event.ctrlKey;
	/*if (e.keyCode === 13 && ctrl)
		addMes(1);
	if (e.keyCode == 13)
		addMes();
	return false;
}*/
//очистка поле кому
function clearFrom(){
	$id('from').value = "";
}
function msg_submit() {
         document.forms[0].submit();
         if(parent.nNav == 1) parent.ret_sub();
         document.forms[0].mesg.focus();
}
//отсылаем сообщение
function addMes(privat)
{
	var text = $id("text").value;
	var from = $id("from").value;
	var color = $id("colors").value;
	text = hts(text);
	var searchString = "text=" + text + "&" + "from=" + from;
	if(privat)
		searchString = searchString + "&" + "privat=1";
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
	{
		if (req.readyState != 4) { //return;
			if (req.status == 200){
				var status = req.responseText;
				if(status) alert(status);
				}
		}
	}
	req.open("POST", "sender.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-Length", searchString.length);
	req.send(searchString);
	//очищаем если выбрано "очищать"
	/*if ($id('onClear').checked == true)
		$id('from').value = '';*/
	if($('#clear').hasClass("ch2"))
		$id('from').value = '';
		
	$id('text').value = '';
	$id('all').scrollTop = 9999;
	$id('privat').scrollTop = 9999;
	$id('text').focus();
	showMess();
}
//Фильтр списка пользователей
function filterUser(){	
	$id('c_filterUser').value = $id('selFilter').value;
	get_users();
}
//checkbox
function onClear(){
	$('#clear').toggleClass("ch");
	$('#clear').toggleClass("ch2");
}