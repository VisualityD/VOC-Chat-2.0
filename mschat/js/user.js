//типа JQ
function $id(elemid)
{
	return document.getElementById(elemid); 
}


//всплывающее окно
function viewOn(alb,photo,noid,only)
{
	//останавливаем прогрузку комментов на главной странице
	clearInterval(idInterval);
	
	var user_id = $id("id_user").value;
	//сохраняем ссылку перед тем ка ее сменить
	if(parseInt(getAtr("photo")) < 1)
		$id("url").value = location.href;
	
	//загружаем данные
	var post = "userid="+user_id+"&veiwalb="+alb+"&viewphoto="+photo;
	if(noid)
		post = post+"&noid=1";
	if(only)//если тока для одного альбома то в url добавляем атребут
		only = "&only=1";
	else
		only = '';
	if(parseInt(getAtr('c'))>1)
		only += '&c='+getAtr('c');
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
	{
		if (req.readyState != 4)return;
		if (req.status == 200){
			var status = req.responseText;
			if(status == "Ошибка"){
				//ошибка
				alert(status);
			}else{
				//обрабатываем данные
				arr = status.split('|');
				$("#viewimg").attr("src",arr[1]);
				//описание фотографии
				var text = arr[2];
				if(text.length > 70){
					$id('reserv').innerHTML = arr[2]+' <br><div class="allTextPhotoOff" onclick="allTextPhotoOff()">Свернуть</div>';
					text = text.slice(0,75);
					text = '<u onclick="allTextPhoto()" class="allTextPhoto" title="Посмотреть полное описание">'+text+'...</u>';
				}				
				$id('load_view_text').innerHTML = text;
				$id('load_view_date').innerHTML = arr[3];
				newloc("?alb="+alb+"&photo="+arr[0]+only);
				//кнопка редактировать
				$("#edit_photo_butt").attr("href","profile.php?p=4&alb="+alb+"&photo="+arr[0]);
				//лайки
				$id("clike_photo_butt").innerHTML = arr[4];
				if(parseInt(arr[5]) == 1){
					$id("like_photo_butt").innerHTML = "Не нравится";
					$("#like_photo_butt").attr("onclick","nolikePhoto();");
				}else{
					$id("like_photo_butt").innerHTML = "Нравится";
					$("#like_photo_butt").attr("onclick","likePhoto();");
				}
				//назание альбома
				$id("gotoalbom").innerHTML = arr[6];
				comments_photo();
			}
		}
	}
	req.open("POST", "post_ajax.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-Length", post.length);
	req.send(post);
	//отображаем
	$('#photoview').fadeIn(0);
	$('#colorbox').fadeIn(300);//фон
	$("#white_main3").removeClass("white_main1").addClass("white_main2");//убираем прокрутку основного блока
}
//закрываем лайт бокс
function closeBox()
{
	//запускаем прогрузку комментов на главной странице
	idInterval = setInterval('all_comments()',60000);
	
	$('#photoview').fadeOut(0);
	$('#new_mes').fadeOut(0);
	$('#colorbox').fadeOut(300);//фон
	$("#white_main3").removeClass("white_main2").addClass("white_main1");//возвращаем прокрутку

	newloc($id("url").value);
	$("#viewimg").attr("src","");
}

//открываем полное описание к фото
function allTextPhoto(){
	$("#reservOn").fadeOut(0);
	$("#load_view_text").fadeOut(0);
	$("#reserv").fadeIn(100);
}
//зкрываем  полное описание к фото
function allTextPhotoOff(){
	$("#reservOn").fadeIn(0);
	$("#load_view_text").fadeIn(0);
	$("#reserv").fadeOut(0);
}

//кто лайкал фотки
function openLikesPhoto(){
	id = getAtr("photo");
	$id('com_title').innerHTML = "Кому понравилось";
	$("#comments_photo").load('inc/likesPhoto.php?id='+id);
}

//прогружаем комменты
function all_comments()
{
	nowPage = getAtr('p');
	var id_user = $id('id_user').value;
	$("#all_comments").load('inc/navi/comments.php?p='+nowPage+'&id='+id_user);
}

//прогружаем комменты фотографий
function comments_photo()
{
	$id('comments_photo').innerHTML = "<div class=\"u_load\"></div>";
	page = getAtr('c');
	photo = getAtr('photo');
	var id_user = $id('id_user').value;
	$("#comments_photo").load('inc/comments_photo.php?photo='+photo+'&id='+id_user+'&page='+page);
	$id('comments_photo').scrollTop = 9999;
}

//прогружаем альбомы
function all_albom(alb)
{
	nowPage = getAtr('p');
	var id_user = $id('id_user').value;
	var ld = 'inc/navi/alboms.php?p='+nowPage+'&id='+id_user;
	if(alb){
		ld = ld+'&alb='+alb;
		newloc("?alboms=1&alb="+alb);
	}
	$("#all_comments").load(ld);
}

//навигация по нижнему подгрузу
function navi(id,newp){
	if(id == 1){//комментарии
		clearInterval(idInterval);
		all_comments();
		idInterval = setInterval('all_comments()',60000);
		newloc("?p=1");
		//правим форму
		$("#nav1").attr("class","n_hover");
		$("#nav2").attr("class","navi");
		$("#nav3").attr("class","navi");
		$("#nav4").attr("class","navi");
		$("#nav5").attr("class","navi");
		$("#nav6").attr("class","navi");
		$('#h_nav1').fadeIn(300);
	}else if(id == 2){//альбомы
		clearInterval(idInterval);
		if(getAtr("alb") > 0 && !newp){
			var alb = getAtr("alb");
			all_albom(alb);
			newloc("?alboms=1&alb="+alb);
			
		}else{
			all_albom();
			newloc("?alboms=1");
		}
		//правим форму
		$("#nav2").attr("class","n_hover");
		$("#nav1").attr("class","navi");
		$("#nav3").attr("class","navi");
		$("#nav4").attr("class","navi");
		$("#nav5").attr("class","navi");
		$("#nav6").attr("class","navi");
		$('#h_nav1').fadeOut(300);
	}
}
//добавляем коммент
function addKomm()
{
	var text = $id('formtext').value;
	text = hts(text);
	var id_user = $id('id_user').value;
	if(text.length > 1 && text != "Комментировать..."){
		//морозим
		$id('formtext').disabled = true;
		var image_url = $id('image_url').value;
		$id('butt').innerHTML = "<img src='"+image_url+"load.gif'>";
		//
		var addKomment = "text=" + text + "&" + "id_user=" + id_user;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					$id('status').innerHTML = status;
					if(status == 1){
						var image_url = $id('image_url').value;
						$id('status').innerHTML = '<div class="yes">Комментарий успешно отправлено!</div><div id="closeBox"><img src="'+image_url+'closeMiniWhite.png" onClick="closeYN()" class="pointer prozr" title="Закрыть"></div>';
						$id('formtext').value = "Комментировать...";
						$id('formtext').blur();
						$id('formtext').value = "Комментировать...";
						with ($id('formtext').style) {
						 height="20px";
						}
						$id('butt').innerHTML = "";
						$id('page').value = 1;
						setTimeout("all_comments()", 30);
						setTimeout("$id('status').innerHTML = ''", 5000);
						//+1 счетчик коментариев
						var countCom = $id('countCom').innerHTML;
						$id('countCom').innerHTML = (parseInt(countCom) + 1);
					}
				}
		}
		req.open("POST", "save_comments.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", addKomment.length);
		req.send(addKomment);
		//размораживаем
		$id('formtext').disabled = false;
	}
}
//удаляем коммент
function deleteCom(id){
	var addLike = "delete="+id;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
						$('#del'+id+' .comAva').fadeOut(200);
						$('#del'+id).animate({opacity: 0.1,height: "0px"}, 200, function(){$('#del'+id).fadeOut(200);all_comments();});  //плавное исчезание
						//-1 с счетчика
						var countCom = $id('countCom').innerHTML;
						$id('countCom').innerHTML = (parseInt(countCom) - 1);
					}
			}			
		}
		req.open("POST", "edit.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", addLike.length);
		req.send(addLike);
}
//удаляем коммент к фотке
function deletePhotoComm(id){
	var addLike = "delete_photo_comm="+id;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
						$('#delp'+id).animate({height: "0px",}, 500, function(){comments_photo();});  //плавное исчезание
						
					}else{
						alert(status);
					}
			}			
		}
		req.open("POST", "post_ajax.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", addLike.length);
		req.send(addLike);
}
//закрываем подсказку отправку комментов
function closeYN()
{
	$id('status').innerHTML = "";
}
//функция перехода на страницу (комменты)
function goPage(page)
{
	var image_url = $id('image_url').value;
	$id('all_comments_new').innerHTML = "<div class=\"u_load\"></div>";	
	newloc("?p="+page);
	setTimeout("all_comments()", 300);
	
}
//функция перехода на страницу (комменты фото)
function goPhotoComm(page)
{
	$id('comments_photo').innerHTML = "<div class=\"u_load\"></div>";
	var image_url = $id('comments_photo').value;	
	setTimeout("comments_photo()", 0);
	if(parseInt(getAtr("c")))
		newloc(setAtr("c",page));
	else
		newloc(location.href+"&c="+page);
}
//переходим на страницу с промта (комменты)
function clickPage(){
	var confPage = prompt("Введите номер страници, на которую хотите перейти");
	if(confPage){
		goPage(confPage);
	}
	newloc("?p="+confPage);
}
//разширяем форму ввода комментов
function onForm(){
	if($id('formtext').value == "Комментировать...")
		$id('formtext').value = "";
		with ($id('formtext').style) {
	        height="55px";
			color="#000000";
			border="1px solid #4c7fdd";
		}
	$id('formtext').focus();
	$id('butt').innerHTML = "<button onclick='addKomm(); onForm();' class='btn btn-info'>Отправить</button>";
}

//возвращаем форум ввода комментов (ре предыдущая функция)
function offFormTime(){	
	if($id('formtext').value == "" || $id('formtext').value == " "){
		$id('formtext').value = "Комментировать...";
		with ($id('formtext').style) {
		 height="20px";
		}
		$id('butt').innerHTML = "";
	}
	with ($id('formtext').style) {
		color="#888";
		border="1px solid #bbb";
	}
}
//лайкаем
function like(id){
	var addLike = "like="+id;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1)
						all_comments();
			}
		}
		req.open("POST", "edit.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", addLike.length);
		req.send(addLike);
}
//удаляем лайк
function nolike(id){
	var addLike = "nolike="+id;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1)
						setTimeout("all_comments()", 300);
			}
		}
		req.open("POST", "edit.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", addLike.length);
		req.send(addLike);
}
//лайкаем фотку
function likePhoto(){
	id = getAtr("photo");
	var addLike = "likePhoto="+id;
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
	{
		if (req.readyState != 4)return;
		if (req.status == 200){
			var status = req.responseText;
			if(status == 1){
				$id("like_photo_butt").innerHTML = "Не нравится";
				$("#like_photo_butt").attr("onclick","nolikePhoto();");
				var lik = parseInt($id("clike_photo_butt").innerHTML);
				lik++;
				$id("clike_photo_butt").innerHTML = lik;
			}
		}
	}
	req.open("POST", "edit.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-Length", addLike.length);
	req.send(addLike);
}
//удаляем лайк фотки
function nolikePhoto(){
	id = getAtr("photo");
	var addLike = "nolikePhoto="+id;
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
	{
	if (req.readyState != 4)return;
		if (req.status == 200){
			var status = req.responseText;
			if(status == 1){
				$id("like_photo_butt").innerHTML = "Нравится";
				$("#like_photo_butt").attr("onclick","likePhoto();");
				var lik = parseInt($id("clike_photo_butt").innerHTML);
				lik--;
				$id("clike_photo_butt").innerHTML = lik;
			}
		}
	}
	req.open("POST", "edit.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-Length", addLike.length);
	req.send(addLike);
}
//сл фотка
function nextPhoto(prev,onlyAlbom){
	$("#viewimg").attr("src",arr[1]);
	$id('com_title').innerHTML = "Комментарии";
	var photo_id = getAtr("photo");
	var id = $id("id_user").value;
	var post = "next="+photo_id+"&id="+id;
	if(prev)
		var post = post+"&prev=1";
	var only = '';
	if(onlyAlbom || getAtr('only') > 0){
		var albom = getAtr("alb");
		var post = post+"&onlyAlbom=1&albom="+albom;
		only = "&only=1";
	}	
	allTextPhotoOff();
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
	{
		if (req.readyState != 4)return;
		if (req.status == 200){
			var status = req.responseText;
			if(status == "Ошибка"){
				//ошибка
				alert(status);
			}else{						
				arr = status.split('|');
				$("#viewimg").attr("src",arr[1]);
				//описание фотографии
				var text = arr[2];
				if(text.length > 70){
					$id('reserv').innerHTML = arr[2]+' <br><div class="allTextPhotoOff" onclick="allTextPhotoOff()">Свернуть</div>';
					text = text.slice(0,75);
					text = '<u onclick="allTextPhoto()" class="allTextPhoto" title="Посмотреть полное описание">'+text+'...</u>';
				}
				$id('load_view_text').innerHTML = text;
				delete(text);
				
				$id('load_view_date').innerHTML = arr[3];
				newloc("?alb="+arr[4]+"&photo="+arr[0]+only);
				$("#edit_photo_butt").attr("href","profile.php?p=4&alb="+arr[4]+"&photo="+arr[0]);
				//лайки
				$id("clike_photo_butt").innerHTML = arr[5];
				if(parseInt(arr[6]) == 1){
					$id("like_photo_butt").innerHTML = "Не нравится";
					$("#like_photo_butt").attr("onclick","nolikePhoto();");
				}else{
					$id("like_photo_butt").innerHTML = "Нравится";
					$("#like_photo_butt").attr("onclick","likePhoto();");
				}
				//назание альбома
				$id("gotoalbom").innerHTML = arr[7];
				comments_photo();
				//если одна фотка то выбрасываем с просмотрщика
				if(!arr[5])
					closeBox()
			}
		}
	}
	req.open("POST", "post_ajax.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-Length", post.length);
	req.send(post);
}
//прячем кнопки вперед назад
function nextOn(id){
	if(id){
		$('#prev2').fadeIn(200);
		$('#next2').fadeIn(200);
		$('#nave_view').fadeIn(200);
	}else{
		$('#prev2').fadeOut(500);
		$('#next2').fadeOut(500);		
		$('#nave_view').fadeOut(500);		
	}	
}
//сворачиваем правую часть просмотра 
function closeRightView(){
	$('#view_right').fadeOut(300);
	$('#closeBoxHidden').fadeIn(10);
	$("#viewimg").attr("style","max-width:900px;");
	$("#next2").attr("style","margin-left:370px;");
	setTimeout("$('#viev_left').attr('style','width:900px;');",300);
	$id('off_comm_view').value = 1;
}
//сворачиваем правую часть просмотра 
function showRightView(){
	$("#viewimg").attr("style","max-width:580px;");
	$("#next2").attr("style","margin-left:70px;");
	$('#viev_left').attr('style','width:600px;');
	$('#view_right').fadeIn(300);
	$('#closeBoxHidden').fadeOut(10);
	$id('off_comm_view').value = 1;
}
//раскрываем и скрываем информацию о пользователе
function oninform(){
	$('#hidden_information').fadeIn(300);
	$("#information").html("Скрыть подробную информацию");
	$("#information").attr("style","border-bottom:none;");
	$("#information").attr("onclick","offinform()");
}
//скрываем
function offinform(){
	$('#hidden_information').fadeOut(300);
	$("#information").attr("onclick","oninform()");
	$("#information").attr("style","border-bottom:1px solid #9ec4d4;");
	$("#information").html("Посмотреть подробную информацию");
}

//разширяем форму ввода комментов для фото
function onFormPhoto(){
	if($id('view_textarea').value == "Написать комментарий")
		$id('view_textarea').value = "";
		with ($id('view_textarea').style) {
			color="#383838";
			border="1px solid #29768a";
		}
	$id('view_textarea').focus();
	$('#butt_viev').fadeIn(50);
}

//возвращаем форум ввода комментов для фото (ре предыдущая функция)
function offFormTimePhoto(){	
	if($id('view_textarea').value == "" || $id('view_textarea').value == " "){
		$id('view_textarea').value = "Написать комментарий";
	}
	with ($id('view_textarea').style) {
		color="#ccc";
		border="1px solid #ccc";
	}
}
//добавляем коммент к фото
function addKommPhoto()
{
	var photoId = getAtr("photo");
	var text = $id('view_textarea').value;
	text = hts(text);
	var id_user = $id('id_user').value; //id кому коммент
	if(text.length > 1 && text != "Написать комментарий"){
		$id('com_title').innerHTML = "Комментарии";
		//морозим
		$id('view_textarea').disabled = true;
		var image_url = $id('image_url').value;
		//
		var addKomment = "commPhoto=" + text + "&" + "id_user=" + id_user + "&photoid="+photoId;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
						$id('view_textarea').value = "Написать комментарий";
						$id('view_textarea').blur();
						goPhotoComm(1)
						}else{
							if(status != "")alert(status);
						}
				}
		}
		req.open("POST", "post_ajax.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", addKomment.length);
		req.send(addKomment);
		//размораживаем
		$id('view_textarea').disabled = false;
	}
}

//новое сообщение
function newMes(){
	$("#new_mes").fadeIn();
	$("#colorbox").fadeIn();
	$("#new_mes textarea").focus();
}

//отправляем сообщение
function sendMess(){
	var text = $id("new_mesTextarea").value;
	var id_user = $id("id_user").value;
	
	var mes = "text=" + text + "&" + "id_user=" + id_user;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
							//
							closeBox();
						}else{
							if(status != "")alert(status);
						}
				}
		}
		req.open("POST", "post_ajax.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", mes.length);
		req.send(mes);
}