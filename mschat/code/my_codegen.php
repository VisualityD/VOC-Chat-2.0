<?php
session_start();
//  error_reporting(E_ALL);
/* $DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("code_dir", $DOCUMENT_ROOT."/code/my_codegen/");
*/
//���� �������, ������� ���� ������������ ��� ������������ ����� � ���������, � �� �� ��.

//�� ������
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("code_dir", "my_codegen/");

function generate_code(){
    $str = rand(1000,10000); //������� ������
    $str = md5(md5(md5($str))); //������ ������� � md5
	$str = strrev($str);// ������ ������
	$str = substr($str, 2, 4); // ��������� 6 ��������, ������� � 3
	// ��� ������� �� ����� ��������� ������ ��������, ��� ���, ���� ��������� ������, ����� ������ �������� ��� ��� ������������, �� � ������ �� ����� ������.
	$array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
    srand ((float)microtime()*1000000);
    shuffle ($array_mix);
	//��������� ������������, ����, ����� �� �����!!!
    $_SESSION['code'] = implode("", $array_mix);
	return $_SESSION['code'];
}

function img_code(){
header("Cache-Control: no-store, no-cache, must-revalidate");         
header("Cache-Control: post-check=0, pre-check=0", false);           
header("Pragma: no-cache");                                     
header("Content-Type:image/png");
//������ �� �����������...������ ������� �� ����� ��������...

$linenum = 5; //�����
$img_arr = array(
                // "codegen.png",
				 "codegen1.png",
                 //"codegen0.png"
                );

$font_arr = array();
$font_arr[0]["fname"] = "verdana.ttf"; //ttf ������, ����� �������� �� ����
$font_arr[0]["size"] = 20;//������
$font_arr[1]["fname"] = "times.ttf"; //ttf ������, ����� �������� �� ����
$font_arr[1]["size"] = 22;//������
$font_arr[2]["fname"] = "ariali_0.ttf"; //ttf ������, ����� �������� �� ����
$font_arr[2]["size"] = 20;//������

$n = rand(0,sizeof($font_arr)-1);
$img_fn = $img_arr[rand(0, sizeof($img_arr)-1)];
$im = imagecreatefrompng (code_dir . $img_fn); //������� ����������� �� ��������� �����

for ($i=0; $i<$linenum; $i++)
{
//������ �����
    $color = imagecolorallocate($im, rand(100, 200), rand(100, 200), rand(100, 200));
    imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
}

$color = imagecolorallocate($im, rand(50, 200), rand(50, 200), rand(50, 200));
imagettftext ($im, $font_arr[$n]["size"], rand(-10, 10), rand(5, 45), rand(30, 35), $color, code_dir.$font_arr[$n]["fname"], generate_code());//����������� ���

/*for ($i=0; $i<$linenum; $i++)//��� ��� �����! ��� ������.
{
    $color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
    imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
}*/

ImagePNG ($im);
ImageDestroy ($im);//�� ��� � ������� �����������!
}

img_code();
?>
