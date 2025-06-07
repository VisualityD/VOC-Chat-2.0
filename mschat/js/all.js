function $id(elemid)
{
	return document.getElementById(elemid); 
}
//cookie
function delete_cookie(cookie_name)
{
  var cookie_date = new Date();
  cookie_date.setTime(cookie_date.getTime()-1);
  document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}
function set_cookie(name, value, exp_y, exp_m, exp_d, path, domain, secure)
{
  var cookie_string = name + "=" + escape(value);
   if(exp_y)
  {
    var expires = new Date (exp_y, exp_m, exp_d);
    cookie_string += "; expires=" + expires.toGMTString();
  }
   if(path)
        cookie_string += "; path=" + escape(path);
   if(domain)
        cookie_string += "; domain=" + escape(domain);
  if(secure)
        cookie_string += "; secure";
  document.cookie = cookie_string;
}
function str_replace(search, replace, subject) {
	return subject.split(search).join(replace);
}

function getAtr(atr){
	nowPage = location.href;
	nowPage = nowPage.split(atr+'=');
	if(parseInt(nowPage[1]) > 0){
		nowPage = nowPage[1].split('&');
		nowPage = nowPage[0];
	}else
		nowPage = -1;
	return nowPage;
}
function getGet() {
	var $_GET = {}; 
	var __GET = window.location.search.substring(1).split("&"); 
	for(var i=0; i<__GET.length; i++) { 
		var getVar = __GET[i].split("="); 
		$_GET[getVar[0]] = typeof(getVar[1])=="undefined" ? "" : getVar[1]; 
	} 
	return $_GET; 
}
function setAtr(prmName,val){
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
	return newvar;
}
function hts(name){
	name = name.split("+").join("[plus]");
	name = name.split("&").join("[and]");
	return name;
}
var newloc = function(loc){
	try{
		history.pushState({}, '', loc);
		return;
	} catch(e) {}
	location.hash = '#' + loc;
}