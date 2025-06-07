<?php
header("Content-type: text/html;charset=utf-8");

########################
##                    ##
##   Skriptoff chat   ##
##   www.pichat.ru    ##
##   icq 3503584      ##
##   pichat@bk.ru     ##
##                    ##
########################

function gradient($text, $from='', $to='', $mode="hex")
{
	$from = str_replace("#","",$from);
	$to = str_replace("#","",$to);
	if($mode=="hex"){
		//Переводим цвет в 10 ричный код
        $to   = hexdec($to[0].$to[1]).",".hexdec($to[2].$to[3]).",".hexdec($to[4].$to[5]);
        $from = hexdec($from[0].$from[1]).",".hexdec($from[2].$from[3]).",".hexdec($from[4].$from[5]);
    }
    if( empty($text) )
        return '';
    else
		$levels = mb_strlen($text, "utf-8"); 
		
    if (empty($from))
		$from = array(0,0,255);
    else
		$from = explode(",", $from);
                
    if (empty($to)) 
		$to = array(255,0,0);
    else
		$to = explode(",", $to);
 
    $output = "";
	
	$text = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
	
    for ($i=1;$i<=$levels;$i++){
        //вырезаем все что в {} скобках (не ставим туда градиент)
		if($text[$i-1] == "<" || $ekr == 1 || $text[$i-1] == ">"){
			$output .= $text[$i-1];
			$ekr = 1;
			if($text[$i-1] == ">")
				$ekr = 0;
		}else{
			for ($ii=0;$ii<4;$ii++){
				$tmp[$ii] = $from[$ii] - $to[$ii];
				$tmp[$ii] = floor($tmp[$ii] / $levels);
				$rgb[$ii] = $from[$ii] -($tmp[$ii] * $i);
				if ($rgb[$ii] > 255) $rgb[$ii] = 255;
					$rgb[$ii] = dechex($rgb[$ii]);
					$rgb[$ii] = strtoupper($rgb[$ii]);
					if (strlen($rgb[$ii]) < 2) $rgb[$ii] = "0$rgb[$ii]";
			}		
			$output .= "<span style=\"color:#".$rgb[0].$rgb[1].$rgb[2]."\">".$text[$i-1]."</span>";
		}
	}
	return $output;
}
function gradient3($text, $from='', $to='', $three='', $mode="hex")
{
	$from = str_replace("#","",$from);
	$to = str_replace("#","",$to);
	$three = str_replace("#","",$three);
	
	$count_text = mb_strlen($text, "utf-8");
	
	if($count_text%2){
		$count_text++;
	}
	$halb = $count_text/2;
	if($halb%2)
		$halb++;
	$text1 = substr($text, 0, $halb);
	$text2 = substr($text, $halb);
	
	$text1 = gradient($text1, $from, $to);
	$text2 = gradient($text2, $to, $three);
	return $text1.$text2."\n";
}
?>