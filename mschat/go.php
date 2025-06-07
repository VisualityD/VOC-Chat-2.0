<?
header("Content-type: text/html;charset=utf-8");
require_once("common.php");
if(isset($_GET['url'])){
	$url = strip_tags($_GET['url']);
	//проверяем состоит ли ссылка в черном списке
	$bl_file = File($data_dir."blackurl.dat");
	
	for ($i=0; $i<count($bl_file); $i++){	
		$search = trim($bl_file[$i]);
		if(preg_match("/".$search."/is", $url))
			$status = true;
	}
	if($status){
		//достаем с шаблона дизайн
		$html = file_get_contents($temp."go_no.tpl");
		$html = tpl($html);
		echo $html;
		exit;
	}else{
		//проверяем состоит ли ссылка в белом списке
		$bl_file = File($data_dir."whiteurl.dat");
		for ($i=0; $i<count($bl_file); $i++){
			$search = trim($bl_file[$i]);
			if(preg_match("/".$search."/is", $url))
				$status_white = true;
		}
		if($status_white){//если ссылка с этого сайта или с доверенного сайта то переходим сразу
			header("Location: $url");
		exit;
		}
		//достаем с шаблона дизайн
		$html = file_get_contents($temp."go_yes.tpl");
		$html = tpl($html);
		$html = str_replace("{url}",$url, $html);
		echo $html;
		exit;
	}
}else{
	go('index.php');
	exit;
}
?>