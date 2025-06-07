function setAtrForLoad(prmName,val){
    var res = '';
	var d = location.href.split("#")[0].split("?");  
	var base = d[0];
	var query = d[1];
	if(query) {
		var params = query.split("&");  
		for(var i = 0; i < params.length; i++) {  
			var keyval = params[i].split("=");  
			if(keyval[0] != prmName) {  
				res += params[i] + '&';
			}
		}
	}
	res += prmName + '=' + val;
	newvar = base + '?' + res;
	return res;
}
function loadUsers(get){
	$("#users").load('inc/users.php?'+get);	
}
function page(p){
	loadUsers(setAtrForLoad("p",p));
	newloc(setAtr("p",p));
}
function search(){
	var val = $id('name').value;
	val = str_replace(" ","+",val);
	if(val.length > 0){
		loadUsers(setAtrForLoad("name",val));
		newloc(setAtr("name",val));
	}else{
		loadUsers(setAtrForLoad("name",""));
		newloc(setAtr("name",""));
	}
	$id('name').focus();
}
function onchangeSearch(){
	var val = $id('name').value;
	var last = val.length - 1;
	if($id('name').value == "" || val[last] == " ")
		search();
}
function searchSex(){
	var val = $id('sex').value;
	loadUsers(setAtrForLoad("sex",val));
	newloc(setAtr("sex",val));
}
function searchSp(){
	var val = $id('sp').value;
	loadUsers(setAtrForLoad("sp",val));
	newloc(setAtr("sp",val));
}
function searchLand(){
	var val = $id('land').value;
	loadUsers(setAtrForLoad("land",val));
	newloc(setAtr("land",val));
}

function searchCity(){
	var val = $id('city').value;
	val = str_replace(" ","+",val);
	loadUsers(setAtrForLoad("city",val));
	newloc(setAtr("city",val));
}
function online(){
	if ($id('online').checked == true){
		loadUsers(setAtrForLoad("o",1));
		newloc(setAtr("o",1));
	}else{
		loadUsers(setAtrForLoad("o",0));
		newloc(setAtr("o",0));
	}
}

function photo(){
	if ($id('photo').checked == true){
		loadUsers(setAtrForLoad("ph",1));
		newloc(setAtr("ph",1));
	}else{
		loadUsers(setAtrForLoad("ph",0));
		newloc(setAtr("ph",0));
	}
}
