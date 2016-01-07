<?php
header("Content-type:text/html;charset='utf-8'");
include("simple_html_dom.php");
$conn=mysql_connect("127.0.0.1","root","") or die ("error");
mysql_select_db("rlyy0710",$conn) or die ("select error");
mysql_query("set names utf8");
$type=0;
$listurl='http://weixin.sogou.com/pcindex/pc/pc_3/1.html';//健康养生url
$html=file_get_html($listurl);
	$introall=$html->find('li');
	for($i=0;$i<count($introall);$i++){
	$introall[$i]; 
	$biaoti=$introall[$i]->find('.wx-news-info2 h4 a',0)->plaintext;
	$miaoshu=$introall[$i]->find('.wx-news-info2 a',1)->plaintext;
	$thumb=$introall[$i]->find('.wx-img-box  a img',0)->src;
	$wxname=$introall[$i]->find('.pos-wxrw p',1)->plaintext; 
	$logo=$introall[$i]->find('.pos-wxrw .fxf .pos-box img',0)->src;
	$erweima=$introall[$i]->find('.pos-wxrw .fxf .pos-box img',1)->src; 
	$lyurl=$introall[$i]->find('.wx-news-info2 h4 a',0)->href;
	$sendtime=time()-rand(60,600);
	$sql="INSERT INTO  `xyseo_acaijiwz` (`id` ,`typeid` ,`biaoti`,`keywords` ,`miaoshu` ,`thumb` ,`wxname` ,`lyurl` ,`body` ,`sendtime` ,`pflag`)VALUES (NULL ,  '{$type}',  '{$biaoti}',  '',  '{$miaoshu}',  '{$thumb}',  '{$wxname}',  '{$lyurl}',  '',   '{$sendtime}',  '0')";
    $flag=mysql_query($sql);
	} 
mysql_close($conn);