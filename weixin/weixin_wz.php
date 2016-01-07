<?php
header("Content-type:text/html;charset='utf-8'");
//######################
$redis = new Redis();
$redis->connect('localhost', '6379');
#此处加上验证更安全
$wytypeid=$redis->zRangeByScore('zjseowytypeid', '-inf', '+inf', array('withscores'=>false));
//如果为数组为0的话，组件一个0~19的数组，没执行一次sPop随机返回并删除名称为key的set中一个元素
//$redis->DEL('typeid');
if(count($wytypeid)==0){
	   for($i=0;$i<10;$i++){
          $redis->zAdd('zjseowytypeid', $i,$i);
		} 
	   $wytypeid=$redis->zRangeByScore('zjseowytypeid', '-inf', '+inf', array('withscores'=>false));
  }
$randwytypeid=array_rand($wytypeid);//取得key
$lanmu=$wytypeid[$randwytypeid];//根据key删除值
$redis->zRemRangeByScore('zjseowytypeid', $lanmu, $lanmu);//根据取得要删除的key选择一个相等的值去除
//var_dump($wytypeid);exit; 
$jkysid=array(47,48,49,50,51,52,53,54,55,56);//这里是对应的织梦后台栏目
//对应10个栏目的id
//var_dump($wyurl);
$type=$jkysid[$lanmu];//根据上面取到的得到要插入数据的栏目
//////////////////////////////////////////【获取关键词开始】//////////////////////////////////////////////////////
//获取关键词从redis中［每获取一个就删除一个，知道关键词耗尽］
$zijingkeyword=$redis->zRange('zjseokeywords', 0, -1);
$zijingcount=count($zijingkeyword);
//var_dump($zijingkeyword);
//var_dump($zijingcount);
if($zijingcount==1||$zijingcount==0){//当redis中关键词不够时，再次导入关键词
	$zijings = file_get_contents("zijingkeyword.txt"); 
	$zijings = mb_convert_encoding($zijings, 'utf-8', 'gbk');
	$zijingkeys=explode("\n",$zijings);
	//var_dump($zijingkeys);
	$zjc=count($zijingkeys);// 获取数组个数
	for($i=0;$i<$zjc;$i++){
          $redis->zAdd('zjseokeywords', $i,$zijingkeys[$i]);
	}
	$zijingkeyword=$redis->zRange('zjseokeywords', 0, -1);
	$zijingcount=count($zijingkeyword);
 }
//var_dump($zijingkeyword);
//////////////////////////////////////////【获取关键词结束】//////////////////////////////////////////////////////
//######################
$conn=mysql_connect("127.0.0.1","root","") or die ("error");
mysql_select_db("rlyy0710",$conn) or die ("select error");
mysql_query("set names utf8");
$keysql="select * from `xyseo_acaijiwz` where pflag=0 ORDER BY  id asc LIMIT 1";
$res=mysql_query($keysql);
if(!empty($res)){
 while($row= mysql_fetch_row($res))
  {
   $data[]=$row;
  }
}
//var_dump($data);
//var_dump($data);exit; 
for($i=0;$i<count($data);$i++){
$url=$data[$i][7];
include("simple_html_dom.php");
$html=file_get_html($url);
if(strpos($html,'此帐号已被封')>0){
	echo "此帐号已被封";
 mysql_query("UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '2' WHERE  `id` =".$data[$i][0]." LIMIT 1 ");
 exit;
}
if(strpos($html,'此内容被多人举报')>0){
	echo "此内容被多人举报";
 mysql_query("UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '2' WHERE  `id` =".$data[$i][0]." LIMIT 1 ");
 exit;
}
if(strpos($html,'该内容已被发布者删除')>0){
	echo "该内容已被发布者删除";
 mysql_query("UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '2' WHERE  `id` =".$data[$i][0]." LIMIT 1 ");
 exit;
}
if(strpos($html,'经用户举报，发现此内容涉嫌违反相关法律法规和政策，查看')>0){ 
echo "经用户举报，发现此内容涉嫌违反相关法律法规和政策，查看";
 mysql_query("UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '2' WHERE  `id` =".$data[$i][0]." LIMIT 1 ");
 exit; 
}
if(strpos($html,'此内容因违规无法查看')>0){ 
echo "此内容因违规无法查看";
 mysql_query("UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '2' WHERE  `id` =".$data[$i][0]." LIMIT 1 ");
 exit; 
}
if($url==""){ 
 echo "网址为空";
 mysql_query("UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '2' WHERE  `id` =".$data[$i][0]." LIMIT 1 ");
 exit; 
}
if(strpos($html,'id="js_content"')<=0){
   echo "被屏蔽了";
   exit;
}

$cont=$html->find('#js_content',0)->innertext;
$allpic = $html->find('img');
$key1=$zijingkeyword[rand(0,$zijingcount)];
$key2=$zijingkeyword[rand(0,$zijingcount)];
$key3=$zijingkeyword[rand(0,$zijingcount)];
//替换图片属性可以，并且将关键词写入属性
$cont = preg_replace('/<img/','<span class="hereiszijingtj" onclick="jsfunc();">'.str_replace(array("\r\n", "\r", "\n"), "", $key1).'</span><img  onclick="jsfunc();"  alt="'.str_replace(array("\r\n", "\r", "\n"), "", $key1).str_replace(array("\r\n", "\r", "\n"), "", $key2).str_replace(array("\r\n", "\r", "\n"), "", $key3).'"',$cont);
//绕过公众账号图片防盗链
$cont = preg_replace("/http:\/\/mmbiz.qpic.cn/","http://img02.store.sogou.com/net/a/05/link?appid=100520091&url=http://mmbiz.qpic.cn/",$cont);
//$cont = preg_replace("/\?wx_fmt=jpeg/","",$cont);
$cont = preg_replace("/data-src=/","src=",$cont);
$cont = preg_replace("/'/","’",$cont);//替换掉单引 号
$cont =preg_replace('/<iframe/','<span class="hereiszijingtj" onclick="jsfunc();">'.str_replace(array("\r\n", "\r", "\n"), "", $key1).'</span><iframe',$cont); //过滤frame标签
//$cont =preg_replace("/<(\/?i?frame.*?)>/si","",$cont); //过滤frame标签
//echo $cont;
////$wzaddsql="INSERT INTO  `r6l_article` (`id` ,`typeid` ,`title` ,`keywords` ,`description` ,`content` ,`thumb` ,`listorder` ,`addtime` ,`is_index` ,`is_pro`) VALUES (NULL ,  '4',  '".$data[$i][1]."',  '".$data[$i][1]."',  '".$data[$i][3]."',  '".$cont."',  '',  '0',  '".$timein."',  '1',  '1')";
//echo $wzaddsql="INSERT INTO  `city`.`s_cguanlian` (`cid` ,`ctitle` ,`cdescription` ,`ccontent` ,`cglid` ,`curl` ,`keywords` ,`author` ,`thumb` ,`sendtime` ,`deleteflag`)VALUES (NULL ,  '".$data[$i][1]."',  '".$data[$i][6]."',  '".$cont."',  '".$data[$i][9]."',  '".jiamihunhe($data[$i][7])."',  '".$data[$i][3]."',  '".$data[$i][4]."',  '".$data[$i][5]."',  '".$data[$i][7]."',  '0')";
//$flag=mysql_query($wzaddsql);
//	if($flag){
 $upsql="UPDATE  `xyseo_acaijiwz` SET  `typeid` =  '{$type}',`keywords` =  '{$key1},{$key2},{$key3}',`miaoshu` =  '{$key1},{$data[$i][4]}',`body` =  '{$cont}',`pflag` =  '1' WHERE  `xyseo_acaijiwz`.`id` =".$data[$i][0]." LIMIT 1";
      $addflag = mysql_query($upsql);
	  if($addflag){
		  echo 'ok,data!';
		  }else{
		  echo 'no,error!';	  
		}
//	}else{
//       mysql_query("UPDATE  `xyseo_acaijiwz` SET  `pflag` =  '2' WHERE  `id` =".$data[$i][0]." LIMIT 1 ");
//	} 
}
$html->clear();
mysql_close($conn);//关闭连接