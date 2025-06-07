<?php
if (!defined("_COMMON_")) exit("<h3>Файл настроек не найден. Доступ запрещен. перейдите на главную страницу и попробуйте еще раз</h3>");
function file_get($file) {
  $result = false;
	$fp = @fopen($file, 'r');
	if($fp) {
		$result = '';
		while(!@feof($fp))
		$result .= @fgets($fp);
		@fclose($fp);
	}
	return $result;
}
?>