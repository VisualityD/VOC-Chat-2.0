<?
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
require_once("connect.php");
if(!$connect)
	go("index.php");
//входит в чат первый раз
$prof = getFile($_SESSION['id'],1);
if($prof['on_chat'] == 0 && $prof['hidden'] == 0){
	$prof['on_chat'] = 1;
	setFile($_SESSION['id'],$prof);
	addMess($conf['boot']," <b>$login</b> входит в чат, приветствуем!");
}
#получаем id последних сообщений!
//общий канал
$mes = "SELECT id FROM mess WHERE privat='0' ORDER BY id DESC LIMIT 1";
$result = mysql_query($mes);
if($result){
	$mesg = mysql_fetch_array($result);
	$old = $mesg['id'] - 10;
}
//приват
$mesP = "SELECT id 
		FROM mess 
		WHERE privat='1' 
				and (polychatel='$login' or
					polychatel='{$lang['alls']}' or 
					author='$login')
				ORDER BY id DESC LIMIT 1";
$resultP = mysql_query($mesP);
if($resultP){
	$mesgP = mysql_fetch_array($resultP);
	$oldP = $mesgP['id'] - 20;
}
//категории смайлов
$smile_cat = File($data_dir."smiles/cat.dat");
for ($smi=0; $smi<count($smile_cat); $smi++){
	$expl = explode("^", $smile_cat[$smi]);
	if($smi > 0)$catSmile .=",";
	$catSmile .= "[";
	$catSmile .= $expl[0].",\"".$expl[1]."\"";
	$catSmile .= "]";
}
$prof = getFile($_SESSION['id']);//Вынимаем данные пользователя для статистики и все такое
//цвет
if(!$default_color)
	$default_color = "#000000";
//статус
$status_id = "status/".$prof['imgstatus'];
if(!$prof['imgstatus'])
	$status_id = $image_url."status.png";
	
$all_height = 70;
$privat_height = 30;

?>
<!DOCTYPE html>
<html>
  <head>
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>general.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>chat.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>chatroom.css" type="text/css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
	<style>
	.main-col-holder .item70{
		height:<? if($prof['hght_privat'] > 0) echo (100 - $prof['hght_privat']); else echo $all_height;?>%;
		top:0;
	}
	.main-col-holder .item30{
		height:<? if($prof['hght_privat'] > 0) echo $prof['hght_privat']; else echo $privat_height;?>%;
		bottom:0;
	}
	</style>
	
<script type="text/javascript">
<? //определяем глобальные переменные ?>
var arrCatSm =[<?=$catSmile;?>]; //массив категорий смайлов
var admin = "<?=$_SESSION['admin'];?>";


<? //старт сообщений ?>
function chatGo(){
	$id('chatGo').value = 9999;
	$id('chatStatus').innerHTML = '<img src="<?=$image_url;?>stop.png" onclick="chatStop()" class="pointer img_menu" title="Остановить чат">';
}

<? //остановка сообщений ?>
function chatStop(){
	$id('chatGo').value = 0;
	$id('chatStatus').innerHTML = '<img src="<?=$image_url;?>go.png" onclick="chatGo()" class="pointer img_menu" title="Запустить чат">';
}

<?//выводим новые сообщения?>
function showMess()
{
	if($id('chatGo').value != 0 && parseInt($id('onLoad').value) == 0){
		$id('onLoad').value = 1;
		req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState == 4)
			{
				if (req.status == 200){
					var addText = req.responseText;
					var arr = new Array();
					var color = "";
					var newStyle = "";
					arr = addText.split('[^pr]'); <?//разделяем общаг и приват?>
					<?//общаг?>
					var allMsgs = new Array();
					allMsgs = arr[0].split('[^n]');<?//разделяем каждую строку?>
					for(var i = 0; i < allMsgs.length; i++)
					{
						var marr = new Array();
						marr = allMsgs[i].split('[^]');
						if(marr[0] > 0 && $id('did').value != marr[0])
						{
							var time = marr[2];
							<?//проверяем кому сообщение и выставляем подцветку сообщения?>
							var solite = new Array();
							var whois = marr[3];
							solite = whois.split(', ');
							var am;
							for(var im = 0; im < solite.length; im++)
							{
								if(solite[im] == "<?=$login;?>")
								{
									am = 1;
									break;
								}else
									am = 0;
							}
							if(whois == "<?=$login;?>" || am == 1 || whois == "<?=$globale;?>" || whois == "<?=$lang['alls_post'];?>")
							{<?//мне?>								
								color = "<?=$conf['colorIn'];?>";
								newStyle = "<?=$conf['styleIn'];?>";
							}else{
								color = "";
								newStyle = "";
							}
							if(marr[1] == "<?=$login;?>")
							{<?//я?>
								color = "<?=$conf['colorOut'];?>";
								newStyle = "<?=$conf['styleOut'];?>";
							}
							<?//другие цвета от модера и тд?>
							var search = marr[4].split('<?=$login;?>');
							if(search[1] || marr[4] == '<?=$login;?>'){
								if(marr[1] == "<?=$conf['bot_moder'];?>" || marr[1] == "<?=$conf['bot_admin'];?>")
								{<?//модер?>
									color = "<?=$conf['colorModer'];?>";
									newStyle = "<?=$conf['styleModer'];?>";
								}else{<?//поиск?>
									color = "<?=$conf['colorSearch'];?>";
									newStyle = "<?=$conf['styleSearch'];?>";
								}
							}
							if(marr[1] == "<?=$conf['bot_obj'];?>")
							{<?//обьявление?>
								color = "<?=$conf['colorObj'];?>";
								newStyle = "<?=$conf['styleObj'];?>";
							}
							<?//html ник?>
							var nik = marr[1];
							if(marr[7].length > 1)
								var nik = marr[7];
							$id('did').value = marr[0];
							var del = parseInt(arr[0])-200;
							$("#m"+del).remove();
							var delet = "";
							//модерам
							if(marr[1] == "<?=$conf['bot_moder'];?>")
								marr[1] = "<?=$lang['in_moders'];?>";
							var addT = "<div style='background-color:"+color+"; "+newStyle+" padding:1px;' id='m"+marr[0]+"' class='mes'><span class='delet' onclick='deletemes("+marr[0]+")' title='Удалить сообщение'></span>[<u onclick='addTime(\"" + time + "\")' class='pointer'>" + time + "</u>] " + marr[5] + "<u class='pointer' onclick=\"addUser('" + marr[1] + "')\">" + nik + "</u>>" + marr[3] + ": " + marr[4] + marr[6] + "</div>";
							$id('all').innerHTML = $id('all').innerHTML + addT;
							$id('all').scrollTop = 9999;
							//скрываем анимацию загрузки
							$(".loadChat").fadeOut(500);
							
							delete addT;
							delete nik;
							delete color;
							delete newStyle;
							delete search;
							delete am;
							delete marr;
						}
					}
					<?//приват ?>
					var allMsgsP = new Array();
					allMsgsP = arr[1].split('[^n]');<?//разделяем каждую строку?>
					for(var i = 0; i < allMsgsP.length; i++)
					{
						var marrP = new Array();
						marrP = allMsgsP[i].split('[^]');
						if(marrP[0] > 0 && $id('pid').value != marrP[0])
						{
							var timeP =  marrP[2];
							<?//html ник?>
							var nikP = marrP[1];
							if(marrP[7].length > 1)
								var nikP = marrP[7];
							$id('pid').value = marrP[0];
							var delP = parseInt(marrP[0])-200;
							$("#m"+delP).remove();
							<? if($_SESSION['admin']){?>
							if( marrP[3] == "<?=$lang['in_moders'];?>")
								marrP[3] = "<u class='pointer' onclick=\"addUser('<?=$lang['in_moders'];?>')\">"+marrP[3]+"</u>";
							<?}?>
							var addTP = "<div id='m"+marrP[0]+"' class='mes' style='margin-left:5px;'><div class='delet' onclick='deletemes("+marrP[0]+")' title='Удалить сообщение'></div>[<u onclick='addTime(\"" + timeP + "\")' class='pointer'>" + timeP + "</u>] " + marrP[5] + "<u class='pointer' onclick=\"addUser('" + marrP[1] + "')\">" + nikP + "</u>>" + marrP[3] + ": " + marrP[4] + marrP[6] + "</div>";
							$id('privat').innerHTML = $id('privat').innerHTML + addTP;
							$id('privat').scrollTop = 9999;
							
							//Добавляем новое сообщение если скрыт приват
							if ($id('closePrivateCont').value == 0 && marrP[1] != "<?=$login;?>"){
								$('#newMes').attr('class','pointer');
								$('#newMes').attr('onclick','openPrivat();');
								var newMes = parseInt($('#newMes').attr('align'))+1;
								$('#newMes').attr('align', newMes);
								$id('newMes').innerHTML = "Новых приватных cобщений: <b style='color:red'>"+newMes+"</b>";
								$("#mess_sound")[0].play();
								
								//
								delete addTP;
								delete nikP;
								delete marrP;
							} else if (marrP[1] != "<?=$login;?>"){
								if ($("#onwindow").val() == 0) {
									$("#mess_sound")[0].play();
								}
							}
						}
					}
					<?//Удаляем сообщения?>
					//
					var darr = new Array();
					darr = arr[2].split('[^]');
					for(var i = 0; i < darr.length; i++)
					{
						$('#m'+darr[i]).remove();
					}
					//
				}
				// else{<? //перезагружаем страницу ?>
					// setTimeout(function(){
						// if(confirm("Соединение прервано, перезагрузить страницу?"))
							// location.reload();
						// }, 5000
					// );
				// }
			}		
		}
		var did = $id('did').value;
		var pid = $id('pid').value;
		req.open("POST", "messanger.php?id=" + did +"&pid=" + pid, true);
		req.send(null);
		$id('onLoad').value = 0;
	}
}

<?//добавляем кому пишем ?>	
function addUser(user)
{ 
	var userOld = $id('from').value;
	if(userOld.length > 3 && userOld != "<?=$lang['alls_post'];?>" && userOld != "<?=$lang['girls_post'];?>" && userOld != "<?=$lang['boys_post'];?>" && userOld != "<?=$lang['robots_post'];?>")
	{
		var solit = new Array();
		solit = userOld.split(', ');
		for(var i = 0; i < solit.length; i++)
		{
			if(solit[i] == user)
			{
				var a = 1;
				break;
			}
		}
		if(a != 1)
		{
			$id('from').value = userOld+", "+user;	
		}	
	}else{
		$id('from').value = user;
	}
	$id('text').focus();
}

<?//кто онлайн подгружаем ?>
function get_users(){
	var filter = $id('c_filterUser').value;
	$("#users").load('users.php?f='+filter);
}
setInterval('get_users()','<?=$conf['loaduser'];?>');

<?//Всплывающее окно?>
function info(text){
   var infoobj=$id('infoobj');
   if(!text) {infoobj.style.display='none'; return false;}
   infoobj.innerHTML=text;
   $('#infoobj').fadeIn(200);
}
<?//Всплывающее окно цвет ->?>
function color(id){
	if(id == 1)
		$('#color_grad').fadeIn(100);
	else 
		$('#color').fadeIn(100);
}
function closeColor(){
	$('#color').fadeOut(200);
	$('#color_grad').fadeOut(200);
}
<?//Всплывающее окно статус ->?>
function status(){
	$('#status').fadeIn(100);
	$('#shadow').fadeIn(100);
}
function closeStatus(){
	$('#status').fadeOut(100);
	$('#shadow').fadeOut(100);
}
function addTextInStatus(text){
	if(text == "none")
		text = "";
	$id('textarea_status').value = text;
}
function saveStatus(img){
	if(img){
		if(img == "none")
			img = "";
		var statustext = "imgstatus="+img;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
				var status = req.responseText;
				if(status == 1){
					if(img){
						$id('mystatus').innerHTML="<img src=\"status/"+img+"\">";
						$('#id_status').attr('src', "status/"+img);
					}else{
						$('#id_status').attr('src', "<?=$image_url;?>status.png");
						$id('mystatus').innerHTML="";
					}
				}
			}
		}
		req.open("POST", "edit.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", statustext.length);
		req.send(statustext);
	}else{
		$id('loadclick').innerHTML="<img src='<?=$image_url;?>progress.gif'>";
		var text = $id('textarea_status').value;
		text = hts(text);
		var statustext = "statustext="+text;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
						closeStatus();
						get_users();
					}
			}
			
		}		
		req.open("POST", "edit.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", statustext.length);
		req.send(statustext);
		$id('loadclick').innerHTML="Сохранить";
	}
}
<?//Всплывающее окно смайлов ->?>
function smile(){
	$id('sCenter').innerHTML = arrCatSm[0][1];
	$('#smile').fadeIn(100);
	
}
function closeSmile(){
	$('#smile').fadeOut(100);
}

<?//Перетаскивание окна смайлов?>
function editSmileOn(on){
	if(on)$("#smile").draggable({ handle: "p",containment: "parent"});
	else $("#smile").disableSelection();
}
<?// Добавляем/удаляем столбец смайлов?>
function edSmile(add){
	var c = parseInt($id('cSmile').value);
	if(add){
		if(parseInt($id('cSmile').value) < 16) c++;
	}else{
		if(parseInt($id('cSmile').value) > 1) c--;
	}
	$id('cSmile').value = c;
	var cat = parseInt($id('catSmile').value);
	
	$("#allSmile").load('inc/smiles.php?c='+c+'&k='+cat);
	$('#smile').css('width','auto');
}
<? //Смалы по категориям ?>
function nextCatSmile(on){
	var cat = parseInt($id('catSmile').value);
	var c = parseInt($id('cSmile').value);
	if(on){
		cat++;
		
		if(cat < <?=count($smile_cat)?>){
			$("#allSmile").load('inc/smiles.php?c='+c+'&k='+cat);
			$id('catSmile').value = cat;
			$id('sCenter').innerHTML = arrCatSm[cat][1];
		}else{
			$("#allSmile").load('inc/smiles.php?c='+c+'&k=0');
			$id('catSmile').value = 0;
			$id('sCenter').innerHTML = arrCatSm[0][1];
		}
	}else{
		cat--;
		if(cat >= 0){
			$("#allSmile").load('inc/smiles.php?c='+c+'&k='+cat);
			$id('catSmile').value = cat;
			$id('sCenter').innerHTML = arrCatSm[cat][1];
		}else{
			$("#allSmile").load('inc/smiles.php?c='+c+'&k=<?=count($smile_cat)-1?>');
			$id('catSmile').value = <?=count($smile_cat)-1?>;
			$id('sCenter').innerHTML = arrCatSm[<?=count($smile_cat)-1?>][1];
			
		}
	}
}
<?//скрываем и раскрываем приват?>
function closePrivat(){	
	$id('closePrivateCont').value = 0; //в контейнер что закрыт
	$id('statusPrivate').value = 1; //в контейнер что збито соотношение
	
	$(".item70").animate({height: parseInt($('.item70').css('height'))+parseInt($('#privat').css('height'))+12}, 200 );
	$("#all").animate({height: parseInt($('#all').css('height'))+parseInt($('#privat').css('height'))+12}, 200 );
	
	$('#closePrivat').attr('onclick','openPrivat();');
	$id('closePrivat').innerHTML = "<img src='<?=$image_url;?>sU.png' border='0'>";
	$id('text').focus();
	
	setTimeout('$(".item30").animate({height: 24}, 600 );',200);
	setTimeout('$("#private").animate({height: 0}, 600 );',200);
}
<? //функция выравнивания окон; ?>
function openSizePrivat(time){
	
	var all = <? if($prof['hght_privat'] > 0) echo (100 - $prof['hght_privat']); else echo $all_height;?>;
	var privat = <? if($prof['hght_privat'] > 0) echo $prof['hght_privat']; else echo $privat_height;?>;
	var oneProcent = (parseInt($('body').css('height'))-198)/100;
		
	var one1 = oneProcent*all+42;
	var one2 = oneProcent*all+6;
	var two1 = oneProcent*privat+18;
	var two2 = oneProcent*privat-18;
	var time2 = time+50;
	$(".item70").animate({height: one1}, time2 );
	$("#all").animate({height: one2}, time2 );
	//
	$(".item30").animate({height: two1}, time );
	$("#privat").animate({height: two2}, time );
	//
	setTimeout("$id('privat').scrollTop = 9999;", time2);
	setTimeout("$id('all').scrollTop = 9999;", time2);
}
<?//скрываем и раскрываем приват ?>
function openPrivat(){
	$id('closePrivateCont').value = 1; //в контейнер что закрыт
	$('#newMes').attr('align',"0");
	openSizePrivat(500);
	$('#closePrivat').attr('onclick','closePrivat();');
	$id('closePrivat').innerHTML = "<img src='<?=$image_url;?>sD.png' border='0'>";
	$id('newMes').innerHTML = "";
	$id('text').focus();
}
<?
if($_SESSION['admin']){?>
	//удаляем сообщение с чата
	function deletemes(id){
		var deletemes = "deletemes="+id;
			var req = getXmlHttpRequest();
			req.onreadystatechange = function()
			{
				if (req.readyState != 4)return;
				if (req.status == 200){
						var status = req.responseText;
						if(status == 1){
							$('#m'+id).animate({height: "0px"}, 200, function(){$('#m'+id).remove();});
						}else{
							alert(status);
						}
				}
				
			}		
			req.open("POST", "post_ajax.php", true);
			req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			req.setRequestHeader("Content-Length", deletemes.length);
			req.send(deletemes);
	}
	function ban(id){
		var login = $id('from').value;
		var text = $id('text').value;
		var bane = "login="+login+"&ban="+id+"&text="+text;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
				var status = req.responseText;				
				if(status != "error" && status != "" && status != 1){
					alert(status);
				}
				if(status == 1){
					clearForm();
					clearFrom();
				}
			}
		}
		req.open("POST", "post_moder.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", bane.length);
		req.send(bane);
	}
<?}else{?>
	//удаляем сообщение с чата
	function deletemes(id){
		var deletemes = "deletemes="+id;		
		$('#m'+id).animate({height: "0px"}, 200, function(){$('#m'+id).remove();});
	}

<?}?>


</script>
    <title><?=$login;?> | <?=$conf['chatname'];?></title>
	<!--
	#######################################################
	рисунок Skriptoff chat на всех страницах через include;
	#######################################################
	-->
</head>
<body>
<!-- header -->
	<div class="header-holder">
		<? 
		$top = 1;
		include("top.php");?>
	</div>
	<div id="wrapper">
		<div class="w1">
			<!-- main-table -->
			<table class="main-table">
				<tr>
					<!-- main-col -->
					<td class="main-col">
						<div class="main-col-holder">
							<!-- item70 -->
							<div class="item70">
								<div class="item70-holder">
									<div class="item70-frame" id="all">
										<p><b><center>Добро пожаловать в чат!</center></b></p>
										<div class="loadChat" id="loadChat"></div>
										<!-- all 
										<div >
										</div>-->
									</div>
								</div>
								<!-- nav-bar -->
								<div class="nav-bar">
									<div id="menu_all">
									<!-- menu_all -->
										<div class="pointer left first" onclick="clearAll()"><img src="<?=$image_url;?>delete.png" class="pointer img_menu" title="Очистить общаг"></div>
										<div id="chatStatus" class='left'><img src="<?=$image_url;?>stop.png" onclick="chatStop()" class="pointer img_menu" title="Остановить чат"></div>
										<div class='left up_menu_pr'>Общий канал</div>
										
									</div>
								</div>
							</div>
							<!-- item30 -->
							<div class="item30">
								<div class="item30-holder">
									<div class="item30-frame" id="privat">
										<!-- privat 
										<div ></div>-->
										<? if($_SESSION['activ'] != 1){?>
											<p><center><b>
												Ограничено по доступу! Чтобы писать приватные сообщения 
												активируйте Ваш аккаунт (бесплатно!) пройдя по ссылке с e-mail письма которое было 
												выслано при регистрации.
											</b></center></p>
										<?}?>
									</div>
								</div>
								<!-- nav-bar -->
								<div class="nav-bar">
									<div id="menu_privat">
										<span class="pointer" onclick="clearPrivate()"><img src="<?=$image_url;?>delete.png" class="pointer img_menu" title="Очистить приват"></span>
										<div class="priveteMenu">Приват</div>
										<div id="closePrivat" class="pointer" title="Свернуть/развернуть приват" onclick="closePrivat();"><img src="<?=$image_url;?>sD.png" border="0"></div>
										<div id="newMes" class="" onclick="1" align="0"></div>
									</div>
								</div>
							</div>
						</div>
						<!-- sender -->
						<div id="sender">
							<? include('sender_visible.php');?>
						</div>
					</td>
					<!-- user-col -->
					<td class="user-col">
						<!-- users -->
						<div id="users">
						</div>
						<div id="rooms"><!--class="user-col-details"--> 
							<div id="filterUser" class="pointer up_filter_pr" title="Фильтр пользователей">
								Фильтр: 
								<select onchange="filterUser();" title="Фильтр списка пользователей" id="selFilter">
									<option value="0">Все</option>
									<option value="1" selected>Кто в чате</option>
									<option value="2">Кто в магазине</option>
									<option value="3">Кто в профиле</option>
									<option value="4">Кто в банке</option>
								</select>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<?
	//////////////////////////////////////////////////////////////////
	//Ниже Sender and container не подключаемые в tpl файлы дизайна =)
	//////////////////////////////////////////////////////////////////
	?>
	<div id="container">
		<input type="hidden" value="<?=$old;?>" id="did"><?//id последн сообщ общего ?>
		<input type="hidden" value="<?=$oldP;?>" id="pid"><?//id последн сообщ привата ?>
		<input type="hidden" value="0" id="onLoad"><?//id последн сообщ привата ?>
		<input type="hidden" value="1" id="chatGo"><?//вкл или выкл чат ?>
		<input type="hidden" value="0" id="onSmile"><?//вкл или выкл окно смайлов ?>
		<input type="hidden" value="1" id="closePrivateCont"><?//Открыт или закрыт приват ?>		
		<input type="hidden" value="0" id="statusPrivate"><?//Открывался или закрывался приват ?>		
		<input type="hidden" value="<?php if ($_COOKIE["smileW"]) echo $_COOKIE["smileW"]; else echo "5"; ?>" id="cSmile"><?//Количество столбцов в смайлах ?>
		<input type="hidden" value="0" id="catSmile"><?//категория смайлов ?>
		<input type="hidden" value="1" id="c_filterUser"><?//Фильтр списка ?>
		<input type="hidden" value="1" id="onwindow"><?//активное окно браузера или нет ?>
		
		<audio preload="auto" id="mess_sound" src="<?php echo $conf['url']; ?>sound/mess.mp3"></audio>
	</div>
	
<?//всплывающие окна ?>
<div id="shadow" onclick="closeStatus()"></div>
<?//статус + фотки?>
<div id="infoobj"></div>


<?//Смайлики ?>
<div id="smile">
	<p id="editSmile" onmouseover='editSmileOn(1);' onmouseout='editSmileOn();'><img src="<?=$image_url;?>dbb.png"> &nbsp; Смайлики</p>
	<div class="closeWin"><img src="<?=$image_url;?>closeBoxAvaWhite.png" onClick="closeSmile()" class="pointer" title="Закрыть"></div>
	<div id="catSmile" style="background-image: url('<?=$image_url;?>sg.png');">
		<div id="sLeft" class="pointer" onclick="nextCatSmile();"><img src="<?=$image_url;?>lb.png"></div>
		<div id="sCenter"></div>
		<div id="sRight" class="pointer" onclick="nextCatSmile(1);"><img src="<?=$image_url;?>rb.png"></div>
	</div>
	<div id="allSmile"></div>
	<span id="naviSmile">
		<img src="<?=$image_url;?>sM.png" onclick="edSmile()" class="pointer sMenu" title="Увеличить">
		<img src="<?=$image_url;?>sP.png" onclick="edSmile(1)" class="pointer sMenu" title="Уменьшить">
	</span>
</div>


<?//Статус ?>
<div id="status">
	<p id="titlestatus">&nbsp; Статус</p>
	<div class="closeStatus"><img src="<?=$image_url;?>closeBoxAvaWhite.png" onClick="closeStatus()" class="pointer" title="Закрыть"></div>
		<div id="allStatus">
			<? include("inc/status.php");?>
		</div>
	<textarea id="textarea_status"><?=$prof['statustext'];?></textarea>	
	<button class="status_butt" id="loadclick" onclick="saveStatus()">Сохранить</button>
	<div id="mystatus"><? if($prof['imgstatus']) echo "<img src='status/".$prof['imgstatus']."'>";?></div> 
</div>
<script type="text/javascript" src="<?php echo $conf['url']; ?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo $conf['url']; ?>js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $conf['url']; ?>js/xmlhttprequest.js"></script>
<script type="text/javascript" src="<?php echo $conf['url']; ?>js/nophp.js"></script>
<script type="text/javascript" src="<?php echo $conf['url']; ?>js/jquery.sameheight.js"></script>
<script type="text/javascript" src="<?php echo $conf['url']; ?>js/all.js"></script>
<script>
<?//для нормальной загрузки оперы?>
	<?//сохраняем цвет сообщения в профиль пользователя?>
	function saveColor(color){
		var postcolor = "color=" + color;
		var reqst = getXmlHttpRequest();
		reqst.onreadystatechange = function()
		{
			if (reqst.readyState != 4) return;
		}
		reqst.open("POST", "edit_sender.php", true);
		reqst.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		reqst.setRequestHeader("Content-Length", postcolor.length);
		reqst.send(postcolor);
		$("#id_color").css("background", color);
		if(color == "#ffffff") color = "#000000";
		$("#text").css("color", color);
		closeColor();
	}
	//растягиваем смайлы
	$(function() {
			$("#smile").resizable({
				minHeight: 100,
				maxHeight: 700,
				resize: function(event, ui) {
					ui.size.width = ui.originalSize.width;
					var hg = ui.size.height;
					hg = hg - 68;
					$('#allSmile').css('height',hg+'px');
				}			
			});
		});
	<?//сохраняем первый цвет градиента?>
	function saveColorGrad(color){
		var postcolor = "color_grad=" + color;
		var reqst = getXmlHttpRequest();
		reqst.onreadystatechange = function()
		{
			if (reqst.readyState != 4) return;
		}
		reqst.open("POST", "edit_sender.php", true);
		reqst.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		reqst.setRequestHeader("Content-Length", postcolor.length);
		reqst.send(postcolor);
		$("#id_color1").css("background", color);
		closeColor();
	}
	
	setInterval("showMess()", <?=$conf['loadmes'];?>);
	get_users();
	<?//загружаем смайлы?>
	var c = parseInt($id('cSmile').value);
	$("#allSmile").load('inc/smiles.php?k=0&c='+c);	
	
	function doSomething() {
		if($id('closePrivateCont').value == 0){//если свернут приват
			var hg = parseInt($('body').css('height')) - 198;
			
			$(".item70").animate({height: hg+34}, 50);
			$("#all").animate({height: hg}, 50);
			setTimeout("$id('all').scrollTop = 9999;", 50);
		}else if($id('statusPrivate').value == 1){
			openSizePrivat(10);
		}
	};
	var resizeTimer = null;
	$(window).bind('resize', function() {
		if (resizeTimer) clearTimeout(resizeTimer);
		resizeTimer = setTimeout(doSomething, 100);
	});
	showMess();
	
	setTimeout('$("#privat").animate({scrollTop: 200}, "slow");', 1000);
	setTimeout('$("#all").animate({scrollTop: 200}, "slow");', 1000);
	//долгая загрузка
	function loadMessLong(){
		$('#loadChat').attr('class', 'loadChat2');
		$id('loadChat').innerHTML = "Если загрузка идет слишком долго попробуйте обновить окно в браузере.";
	}
	setTimeout('loadMessLong()',5000);
	//onwindow
	$(document).ready(function(){
		$('html').mouseout(function() {
		  $("#onwindow").val(0);
		});
		$('html').mouseover(function() {
		  $("#onwindow").val(1);
		});
	});
</script>
<?
//Сохраняем статус что пользователь в чате
$prof['on'] = 1;
if(!$prof['rang']){
	echo "<script>alert('Добро пожаловать в чат. Чтобы написать приватное сообщение нажмите на ник кому хотите написать, введите сообщение и нажмите кнопку \"Приват\", но помните, при общении через общий канал Вам начисляются бонусы! Поздравляем, Ваш подарок сегодня: 1-й уровень. Приходи в чат каждый день за подарками!');</script>";
	$prof['rang'] = 1;
}
setFile($_SESSION['id'],$prof);
?>
</body>
</html>
