<?php
header("Content-type:text/html;charset='utf-8'");
$conn=mysql_connect("127.0.0.1","root","") or die ("error");
mysql_select_db("rlyy0710",$conn) or die ("select error");
mysql_query("set names utf8");
$keysql="select * from `xyseo_acaijiwz` where pflag=1 ORDER BY  id asc LIMIT 1";
$res=mysql_query($keysql);
if(!empty($res)){
 $row= mysql_fetch_row($res);
}else{
echo "no data result";	
exit;	
}
if($row[2]==""||$row[3]==""||$row[4]==""){
exit;	
}
//dedecms一篇文章对应的时三张数据表
$time=time();
$click=rand(30,99);
$addsql="INSERT INTO  `xyseo_archives` (`id` ,`typeid` ,`typeid2` ,`sortrank` ,`flag` ,`ismake` ,`channel` ,`arcrank` ,`click` ,`money` ,`title` ,`shorttitle` ,`color` ,`writer` ,`source` ,`litpic` ,`pubdate` ,`senddate` ,`mid` ,`keywords` ,`lastpost` ,`scores` ,`goodpost` ,`badpost` ,`voteid` ,`notpost` ,`description` ,`filename` ,`dutyadmin` ,`tackid` ,`mtype` ,`weight`)VALUES (NULL,  '{$row[1]}',  '0',  '0', '{$time}' ,  '1',  '1',  '0',  '{$click}',  '0',  '{$row[2]}',  '',  '',  'admin',  '{$row[6]}',  '{$row[5]}',  '{$time}',  '{$time}',  '0',  '{$row[3]}',  '0',  '0',  '0',  '0',  '0',  '0',  '{$row[4]}',  '',  '1',  '0',  '0',  '0')"; 
$addflag=mysql_query($addsql);
if($addflag){
   $newID = mysql_insert_id();
	$body=$row[8];
	//去掉首尾空格
	$body = mb_ereg_replace('^(　| )+', '', $body);
	$body = mb_ereg_replace('(　| )+$', '', $body);
	$body=mb_ereg_replace('　　', "\n　　", $body);
	//去掉首尾空格 
    $addarcsql="INSERT INTO  `xyseo_addonarticle` (`aid` ,`typeid` ,`body` ,`redirecturl` ,`templet` ,`userip`)VALUES ('{$newID}',  '{$row[1]}',  '{$body}',  '',  '',  '101.201.141.136')";
	$addarcflag=mysql_query($addarcsql);
    $arctinysql="INSERT INTO  `xyseo_arctiny` (`id` ,`typeid` ,`typeid2` ,`arcrank` ,`channel` ,`senddate` ,`sortrank` ,`mid`)VALUES ('{$newID}',  '{$row[1]}',  '0',  '0',  '1',  '{$time}',  '{$time}',  '1')";
	$addarcflag2=mysql_query($arctinysql); 
	if($addarcflag){
		$upsql="UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '2' WHERE  `id` ={$row[0]} LIMIT 1 ";//文章最终成功
		echo "文章body最终成功<br/>";
		mysql_query($upsql);
	}else{
		$upsql="UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '3' WHERE  `id` ={$row[0]} LIMIT 1 ";//文章body未更新成功
		echo "文章body未更新成功<br/>";
		mysql_query($upsql);
		}
}else{
		$upsql="UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '4' WHERE  `id` ={$row[0]} LIMIT 1 ";//文章基本信息未插入成功
		echo "文章基本信息未插入成功<br/>";
		mysql_query($upsql);
	}
mysql_close($conn); 