<?php
$av = $_COOKIE["av"];
$hash = gethash();
$api = "https://www.parsevideo.com/api.php?url=https://www.bilibili.com/video/av".$av."&hash=".$hash;
$json = getjson($api);
if($json=='{"captcha":"ok","message":"\u4e3a\u4e86\u9632\u6b62\u975e\u6388\u6743\u4f7f\u7528\u672c\u7ad9\u63a5\u53e3\uff0c\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801\uff01"}') {
	include("./Snoopy.class.php");
	$json = new Snoopy;
	$json->fetch($api);//获取所有内容
	$json = $json->results;
}
//echo $json;
$result = array();
preg_match_all("/(?:url)(.*)(?:thumb)/i",$json, $result);//匹配视频url大致字符串
$geturl = $result[1][0];
$geturl = substr($geturl, 3, strlen($geturl) - 6);//截取url完整字符串
$geturl = str_replace('\\','',$geturl);//删除\得到url正常字符串
//echo $geturl;
$geturl = str_replace('http','https',$geturl);//修改为https

$array = get_headers($geturl,1);
if (preg_match('/200/',$array[0])) {//判断解析出的url(包含解析异常判断)有效性
$file = "./geturl/".$av.".txt";
writeurl($file ,$geturl);
echo('<script language="JavaScript">top.location.href=top.location.href;alert("解析完毕！！！");</script>');//写入刷新主页面并弹出提示框
	} else {//url无效,从iframe获取url
	//提示后台解析失败
	echo '<script language="JavaScript"> alert("后台解析失败，请稍后再试！！！");</script>';
}

function gethash() {//实时获取hash字符串hash="…………"		
	$url = "https://www.parsevideo.com";
	$data = file_get_contents($url);//parsevideo.com获取hash
	//echo $data;
	$result = array();
	preg_match_all("/(?:hash =)(.*)(?:;)/i",$data, $result);//匹配hash大致字符串
	$data = $result[1][0];
	$data = substr($data, 2, strlen($data)-3);
	return $data;
}
function getjson($url) {
	$curl = curl_init();//创建一个新的CURL资源
	$headers = randIP();
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//伪造请求ip
	curl_setopt($curl, CURLOPT_REFERER, "https://www.parsevideo.com");//伪造请求源referer
	curl_setopt($curl,CURLOPT_URL,$url);//设置URL和相应的选项
	curl_setopt($curl,CURLOPT_HEADER,0);//0表示不输出Header，1表示输出
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//数据不输出到页面
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
	curl_setopt($curl,CURLOPT_ENCODING,'');//设置编码格式，为空表示支持所有格式的编码//header中“Accept-Encoding: ”部分的内容，支持的编码格式为："identity"，"deflate"，"gzip"
	$UserAgent="Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36";
	curl_setopt($curl,CURLOPT_USERAGENT,$UserAgent);//模拟windows用户正常访问
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);//设置这个选项为一个非零值(象 “Location: “)的头，服务器会把它当做HTTP头的一部分发送(注意这是递归的，PHP将发送形如 “Location: “的头)
	$json = curl_exec($curl);
	curl_close($curl);
	return $json;
}
function randIP(){//随机ip
	$ip_long = array(
		array('607649792', '608174079'), //36.56.0.0-36.63.255.255
		array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
		array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
		array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
		array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
		array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
		array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
		array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
		array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
		array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
	);
	$rand_key = mt_rand(0, 9);
	$ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
	$headers['CLIENT-IP'] = $ip;
	$headers['X-FORWARDED-FOR'] = $ip;
	$headerArr = array();
	foreach( $headers as $n => $v ) {
		$headerArr[] = $n .':' . $v;
	}
	return $headerArr;
}
function writeurl($TxtFileName,$url) {//服务器存放写入url的txt文件(名称,字符串)
	if(($TxtRes=fopen($TxtFileName,"w+")) === FALSE){//以读写方式打写指定文件，如果文件不存则创建
	//创建可写文件$TxtFileName失败
	exit();
	}
	//创建可写文件$TxtFileName成功
	$StrConents = $url;//要写进文件的内容
	if(!fwrite($TxtRes,$StrConents)) {//将信息写入文件
	//尝试向文件$TxtFileName写入$StrConents失败
	fclose($TxtRes);
	exit();
	}
	//尝试向文件$TxtFileName写入$StrConents成功！
	fclose($TxtRes); //关闭指针
}

?>
