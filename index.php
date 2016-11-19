<?php
define(UPLOADDIR,"data/");
function writefile($filep) {
	$pictype="jpg";
	$base64 = $_POST[$filep];
	if( $base64 == null) {
		
		return -3;
	}
	$picurl = explode(',',$base64);
	if (preg_match('/^(data:\s*image\/(\w+);base64)/', $picurl[0], $result)){
		$pictype = $result[2];
		if($pictype == 'jpeg') $pictype='jpg';
	}

	$path = UPLOADDIR.date('Ymd',time())."/";
	if(!file_exists($path))
	{
		//检查是否有该文件夹，如果没有就创建，并给予最高权限
		mkdir($path, 0755);
	}
	
	$picfile = $path.$filep.".".$pictype;
	
	$bigpic = base64_decode($picurl[1]);
	$size = file_put_contents($picbigfile, $bigpic);//返回的是字节数
	
	
	if(!$bigpic) {
		return -2;
	}
	
	$fp = @fopen($picfile, 'wb');
	if(!$fp) {
		return -4;
	}
	@fwrite($fp, $bigpic);
	@fclose($fp);
	
	return 1;
	
}

@header("Expires: 0");
@header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
header("Content-type: application/json; charset=utf-8");
$ret = writefile('picbig');
if($ret < 0) {
	echo '{"error":'.$ret.'}';
	return;
}
$ret = writefile('picmid');
if($ret < 0) {
	echo '{"error":'.$ret.'}';
	return;
}

$ret = writefile('picsmall');
if($ret < 0) {
	echo '{"error":'.$ret.'}';
	return;
}
echo '{"error":'.$ret.'}';

/*$pictype=".jpg";
$picbigfile = UPLOADDIR."/picbig".$pictype;
$picmidfile = UPLOADDIR."/picmid".$pictype;
$picsmallfile = UPLOADDIR.'./picsmall'.$pictype;
$base64 = $_POST['picbig'];

$picurl = explode(',',$base64);
$bigpic = base64_decode($picurl[1]);
$size = file_put_contents($picbigfile, $bigpic);//返回的是字节数

$base64 = $_POST['picbig'];
$picurl = explode(',',$base64);
$middlepic = base64_decode($picurl[1]);

$base64 = $_POST['picbig'];
$picurl = explode(',',$base64);
$smallpic = base64_decode($picurl[1]);

if(!$bigpic || !$middlepic || !$smallpic) {
	echo '{"error":-2}';
}

$success = 1;
$fp = @fopen($picbigfile, 'wb');
@fwrite($fp, $bigpic);
@fclose($fp);

$fp = @fopen($picmidfile, 'wb');
@fwrite($fp, $middlepic);
@fclose($fp);

$fp = @fopen($picsmallfile, 'wb');
@fwrite($fp, $smallpic);
@fclose($fp);

$biginfo = @getimagesize($picbigfile);
$middleinfo = @getimagesize($picmidfile);
$smallinfo = @getimagesize($picsmallfile);

if($success) {
	echo '{"success":1}';
} else {
	echo '{"success":0}';
}
*/
?>
