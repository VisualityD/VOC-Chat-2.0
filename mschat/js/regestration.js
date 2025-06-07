$("#reg").click(function(){
	//login
	var login = $('input[name="login"]').val();
	var mail = $('input[name="mail"]').val();
	var status = "";
	
	$('#status').html("");
	
	if (login.length < 3 || login.length > 15) {
	
		$('#div-login').addClass("error");
		$('#div-login').removeClass("success");
		
		status = status +  "- Не допустимая длинна логина<br>";
	} else {
		
		// Задаем регулярное выражение
        var filter  = /^([a-zA-Z0-9_\-])+$/;
        if (!filter.test(login)){
			$('#div-login').addClass("error");
			$('#div-login').removeClass("success");
			$('#status').html("Не корректный ник (только английские символы, цифры, тире и знак подчеркивания)<br>");
			//return false;
		}
		
		$.ajax({
			type: "POST",
			url: "ajax/regestration.php",
			data: "login=" + login,
			success: function(msg){
				if (msg == 1){
					$('#div-login').addClass("error");
					$('#div-login').removeClass("success");
					$('#status').html("Такой логин уже занят");
					return false;
					
				}else{		
					$('#div-login').removeClass("error");
					$('#div-login').addClass("success");
				}
			}
		});
	}
	//password
	if ($('input[name="pass"]').val().length < 6) {
		$('#div-pass').addClass("error");
		$('#div-pass').removeClass("success");
		
		status = status + "- Слишком короткий пароль<br>";
	} else {
		$('#div-pass').removeClass("error");
		$('#div-pass').addClass("success");
	}
	//email
	if (!isValidEmailAddress(mail)) {
		$('#div-mail').addClass("error");
		$('#div-mail').removeClass("success");
		
		status = status + "- Не корректный email<br>";
	} else {
		$.ajax({
			type: "POST",
			url: "ajax/regestration.php",
			data: "mail=" + mail,
			success: function(msg){
				if (msg == 1){
					$('#div-mail').addClass("error");
					$('#div-mail').removeClass("success");
					$('#status').html("Пользователь с таким email уже зарегистрирован");
					return false;
					
				}else{		
					$('#div-mail').removeClass("error");
					$('#div-mail').addClass("success");
				}
			}
		});
	}
	
	if (status.length > 0) {
		$('#status').html(status);
		return false;
	}
});
function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return pattern.test(emailAddress);
}
