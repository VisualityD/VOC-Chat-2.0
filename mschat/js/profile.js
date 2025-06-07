//типа JQ
function $id(elemid){return document.getElementById(elemid);}

//подгружаем альбомы
function get_alboms(){
	var filter = $id('prof_alboms').value;
	$("#prof_alboms").load('inc/profile_alboms.php');
}

//создаем новый альбом
function newAlbom(){
	var newalbom = $id('newalbom').value;
	var albomtext = $id('albomtext').value;
	var post = "newalbom="+newalbom+"&albomtext="+albomtext;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					
					if(status == 1){
						//пишем текст
						get_alboms();
						$id('newalbom').value = "";
						$id('albomtext').value = "";
					}else{
						$('#status').fadeIn(100);
						$id('status').innerHTML = status;
						get_alboms();
						setTimeout("$('#status').fadeOut(600)", 3000);
					}
			}
		}
		req.open("POST", "edit_profile.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", post.length);
		req.send(post);
}
//удаляем альбом
function deleteAlbom(id){
	var post = "deletealbom="+id;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
						//пишем текст
						$('#alb'+id).fadeOut(300);
					}else{
						$('#status').fadeIn(100);
						$id('status').innerHTML = status;
						get_alboms();
						setTimeout("$('#status').fadeOut(600)", 3000);
					}
			}
		}
		req.open("POST", "edit_profile.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", post.length);
		req.send(post);
}
//меняем форму редактора на форму загрузки фоток
function form_swich(){	
	$('#edit_photoalbom').fadeOut(100);
	$('#photos_edit').fadeOut(100);
	setTimeout("$('#edit_form').fadeIn(100);", 100);
}
//закрываем форму редактора
function cancel_save(){
	$('#edit_form').fadeOut(100);
	setTimeout("$('#photos_edit').fadeIn(100);", 100);
	setTimeout("$('#edit_photoalbom').fadeIn(100);", 100);
}
//редакритуем альбом
function save_alb_ed(id){
	$id('butt_save_edit').innerHTML = "Загрузка";
	var name_albom = $id('name_albom').value;
	var albom_text = $id('albom_text').value;	
	var post = "edit="+id+"&name_albom="+name_albom+"&albom_text="+albom_text;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
						//пишем текст
						$('#edit_form').fadeOut(300);
						setTimeout("$('#photos_edit').fadeIn(300);", 300);
						setTimeout("$('#edit_photoalbom').fadeIn(300);", 300);
						$id('butt_save_edit').innerHTML = 'Сохранить';						
					}else{
						$id('butt_save_edit').innerHTML = 'Сохранить';
						alert(status);						
					}
			}
		}
		req.open("POST", "edit_profile.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", post.length);
		req.send(post);
}
//удаляем фотографию c фотоальбома
function deletePhoto(id){
	var post = "deletephoto="+id;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
						//пишем текст
						$('#photo'+id).fadeOut(300);
					}else{
						$('#status').fadeIn(100);
						$id('status').innerHTML = status;
						setTimeout("$('#status').fadeOut(600)", 3000);
					}
			}
		}
		req.open("POST", "edit_profile.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", post.length);
		req.send(post);
}
//разширяем форму ввода описания к фотографии
function onFormPhoto(){
	if($id('photo_text').value == "Изменить описание фотографии...")
		$id('photo_text').value = "";
		with ($id('photo_text').style) {
	        height="95px";
			color="#000000";
			border="1px solid #4c7fdd";
		}
	$id('photo_text').focus();
	$id('edit_form_photo').innerHTML = "<button  class=\"btn btn-info\" id=\"butt_save_edit_photo\" onclick=\"save_photo_ed('');\">Сохранить</button>";
}
//возвращаем форум ввода комментов (ре предыдущая функция)
function offFormPhoto(){	
	if($id('photo_text').value == "" || $id('photo_text').value == " "){
		$id('photo_text').value = "Изменить описание фотографии...";
		with ($id('photo_text').style) {
		 height="40px";
		}
		$id('edit_form_photo').innerHTML = "";
	}
	with ($id('photo_text').style) {
		color="#888";
		border="1px solid #bbb";
	}
}
function nextPhoto(prev){
	var photo_id = $id('photo_id').value
	var post = "next="+photo_id+"&albom_id="+$id('albom_id').value;
	if(prev)
		var post = post+"&prev=1";
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
	{
		if (req.readyState != 4)return;
		if (req.status == 200){
				var status = req.responseText;
				if(status == "Ошибка"){
					//ошибка
					$('#status').fadeIn(100);
					$id('status').innerHTML = status;
					setTimeout("$('#status').fadeOut(600)", 3000);
				}else{
					arr = status.split('|');						
					$("#photo_big").attr("src",arr[1]);
					if(arr[2])
						$id('photo_text').value = arr[2];
					else
						$id('photo_text').value = "Изменить описание фотографии...";
					$id('photo_id').value = arr[0];
					newloc("profile.php?p=4&alb="+$id('albom_id').value+"&photo="+arr[0]);
					if(arr[0] == "")					
						location.href="profile.php?p=4&alb="+$id('albom_id').value;
				}
		}
	}
	req.open("POST", "edit_profile.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-Length", post.length);
	req.send(post);
}

//сохраняем текст к фото
function save_photo_ed(){
$id('butt_save_edit_photo').innerHTML = "Загрузка";	
	var photo_id = $id('photo_id').value;	
	var photo_text = $id('photo_text').value;
	if(photo_text != "Изменить описание фотографии...")
	{
		var post = "photo_id="+photo_id+"&photo_text="+photo_text;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
					var status = req.responseText;
					if(status == 1){
						//пишем текст
						$id('butt_save_edit_photo').innerHTML = 'Сохранить';
						with ($id('photo_text').style) {
							height="40px";
						}
						$id('edit_form_photo').innerHTML = "";
					}else{
						$id('butt_save_edit_photo').innerHTML = 'Сохранить';
						alert(status);
					}
			}
		}
		req.open("POST", "edit_profile.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", post.length);
		req.send(post);
	}
}
//удаляем фотографию внутри ее))
function deletePhotoBig(){
	var photo_id = $id('photo_id').value;	
	var post = "deletephoto="+photo_id;
		var req = getXmlHttpRequest();
		req.onreadystatechange = function()
		{
			if (req.readyState != 4)return;
			if (req.status == 200){
				var status = req.responseText;
				if(status == 1){
					//перекидываем на новую фотографию		
					nextPhoto();
				}else{
					$('#status').fadeIn(100);
					$id('status').innerHTML = status;
					setTimeout("$('#status').fadeOut(600)", 3000);
				}
			}
		}
		req.open("POST", "edit_profile.php", true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-Length", post.length);
		req.send(post);
}
//прячем кнопки вперед назад
function nextOn(id){
	if(id){
		$('#prev').fadeIn(80);
		$('#next').fadeIn(80);
	}else{
		$('#prev').fadeOut(80);
		$('#next').fadeOut(80);		
	}
	
}