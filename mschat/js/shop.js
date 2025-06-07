//покупаем
function by(id){	
	var post = "item="+id;
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
	{
		if (req.readyState != 4)return;
		if (req.status == 200){
			var status = req.responseText;
			var arr = status.split("|");
			$id('status').innerHTML = arr[2];
			$('#status').fadeIn(50);
			$id('mon1').innerHTML = parseInt($id('mon1').innerHTML)-arr[0];
			$id('mon2').innerHTML = parseInt($id('mon2').innerHTML)-arr[0];
		}
	}
	req.open("POST", "post_shop.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-Length", post.length);
	req.send(post);
}
function closeStatus(){
	$('#status').fadeOut(500);
	$id('status').innerHTML = '';
	var get = getGet();
	$("#shop_load").load('inc/shop.php?c='+get.c+'&t='+get.t);
	
}
//навигация магазин
function openMenu(id){	
	$('#menu_'+id).animate({height: "toggle"},"slow");
}
function loadMenu(id,type){
	var image_url = $id('image_url').value;
	$id('shop_load').innerHTML = "<div class='loader'><img src='"+image_url+"loading.gif'></div>";
	$("#shop_load").load('inc/shop.php?c='+id+'&t='+type);
	newloc("?c="+id+'&t='+type);
}