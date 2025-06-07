<?php
function hts($var){
	if(isset($_POST[$var])){
		$var = $_POST[$var];
	}else
	if(isset($_GET[$var])){
		$var = $_GET[$var];
	}else{
		$var = $var;
	}
	$var = htmlspecialchars(trim($var));
	$var = mysql_escape_string($var);
	
	$var = trim($var);
	return($var);
}
function addurl($str)
{
		$str = str_replace("[and]","&",$str);
        global $conf;
        $str2 = $str;
        if (function_exists('preg_replace')){
            $str2 = preg_replace("/(?<!<a href=\")(?<!\")(?<!\">)((http|https|ftp):\/\/[\w?=&.\/-~#-_]+)/e",
                                        "'<a href=\"".$conf['url']."go.php?url='.urlencode('\\1').'\" target=\"_blank\">\\1</a>'",
                                        $str);
            $str2 = preg_replace("/((?<!<a href=\"mailto:)(?<!\">)(?<=(>|\s))[\w_-]+@[\w_.-]+[\w]+)/","<a href=\"mailto:\\1\">\\1</a>",$str2);
        }
        return $str2;
}
//разделяем пробелами сообщение
function fixup($what) {
    $fix_arr = explode(" ", $what);
    $rez_arr = array();

    for($i = 0; $i < count($fix_arr); $i++) {
            $fix_arr[$i] = trim($fix_arr[$i]);
            if(strlen($fix_arr[$i]) > 25) $fix_arr[$i] = substr($fix_arr[$i], 0, 25);
        if(strlen($fix_arr[$i]) > 0) $rez_arr[] = $fix_arr[$i];
    }
    return implode(" ", $rez_arr);
}
?>