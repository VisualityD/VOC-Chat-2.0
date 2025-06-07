<?php

########################
##                    ##
##   Skriptoff chat   ##
##   www.pichat.ru    ##
##   icq 3503584      ##
##   pichat@bk.ru     ##
##                    ##
########################

if (!defined("_COMMON_"))
	define("_COMMON_", 1);
//получаем путь к корню и data
$common_dir = __DIR__;
$common_dir = str_replace("\\","/", $common_dir);
$common_dir .= "/";
$data_dir = $common_dir."data/";
$engine = $data_dir."engine/";
$data_conf = $data_dir."file.conf";
//подключаем функции работы с ошибками
require_once($common_dir."functions/errors.php");
require_once($common_dir."functions/general.php");
require_once($common_dir."functions/filter.php");
require_once($common_dir."functions/message.php");
require_once($common_dir."functions/photo.php");
require_once($common_dir."language/ru.php");
require_once($common_dir."functions/gradient.php");
require_once($common_dir."functions/files.php");
//получаем файл настроек
if(!is_file($data_conf))
	globalError("Не могу найти файл с настойками data", "Проверте что с файлом file.conf");
$config = implode("", file($data_conf));
eval($config);

$temp = $conf['url']."templaces/".$conf['temp']."/";

//Подключаем нужне файлы
require_once($common_dir."functions/sql.php");
$temp_dir = $common_dir."templaces/".$conf['temp']."/";
$image_url = $conf['url']."templaces/".$conf['temp']."/images/";
$css_url = $conf['url']."templaces/".$conf['temp']."/css/";

/* ban hostvoc */
$bans = array(
	"91.209.51.37",
	"62.182.69.137",
	"193.0.147.117",
	"92.215.143.48",
	"46.119.120.173",
	"37.55.213.131",
	"176.99.4.91",
	"194.242.2.49",
	"194.126.251.124"
	);
$hostvoc = false;
foreach($bans as $ban) {
	if($_SERVER['REMOTE_ADDR'] == $ban) {
		$hostvoc = true;
	}
}
$exip = explode('.',$_SERVER['REMOTE_ADDR']);
if ($exip[0] == 91 && $exip[1] == 198) $hostvoc = true;
if ($exip[0] == 91 && $exip[1] == 207) $hostvoc = true;
if ($exip[0] == 193 && $exip[1] == 0) $hostvoc = true;
?>