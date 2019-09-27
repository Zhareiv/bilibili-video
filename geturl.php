<?php
$av = $_COOKIE["av"];//$av = "14661594";
$p = $_COOKIE["p"];//$p = "1";
//$av = $_GET["av"];//$av = "14661594";
//$p = $_GET["p"];//$p = "1";
$hash = gethash();
$api = "https://pv.vlogdownloader.com/api.php?url=https://www.bilibili.com/video/av".$av."&hash=".$hash;
$json = getjson($api);
if($json=='{"captcha":"ok","message":"\u4e3a\u4e86\u9632\u6b62\u975e\u6388\u6743\u4f7f\u7528\u672c\u7ad9\u63a5\u53e3\uff0c\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801\uff01"}') {
echo '<script language="JavaScript"> alert("？？？解析失败？？？");</script>';
exit;
}
//echo $json;
//php解析json字符串数据
$json = json_decode($json);//json字符串对象化
header("Content-Type: text/html; charset=UTF-8");//定义头文件，防止乱码
$status = $json->status;
if ($status != "ok") {//
echo '<script language="JavaScript"> alert("？？？解析失败？？？");</script>';
exit;
}
$videojson = $json->video[$p-1];
$videourl = $videojson->url;
if ($videourl == "") {
echo '<script language="JavaScript"> alert("？？？解析返回值获取失败？？？");</script>';
exit;
}
$videourl = str_replace('http','https',$videourl);//修改为https

$file = "./geturl/".$av.".json";
if (file_exists($file)) {//判断json数据叠加条件
$getjson = file_get_contents($file);
} else {
$getjson = array('av'=>$av,'video'=>[],'status'=>'ok');//json初始化
$getjson = json_encode($getjson);//php数组json字符串化
writeurl($file ,$getjson);
}

$getjson = json_decode($getjson,ture);

for ($p0=1;$p0<=$p;$p0++) {//json初始化后，video初始化
if (array_key_exists($p0-1,$getjson[video])) {//判断数组中关键字key是否存在
} else {
$getjson[video][$p0-1] = array('p'=>"$p0",'url'=>"");//初始化
}
}
$getjson[video][$p-1] = array('p'=>$p,'url'=>$videourl);//video单元数据覆盖
$getjson = json_encode($getjson);
writeurl($file ,$getjson);//json数据更新覆盖
echo('<script language="JavaScript">top.location.href=top.location.href;alert("！！！解析完毕！！！");</script>');//写入json后弹出提示框并刷新主页面

function gethash() {//实时获取hash字符串hash="…………"
	$data = file_get_contents('https://pv.vlogdownloader.com/');//parsevideo.com获取hash
	$result = array();
	preg_match_all("/(?:hash =)(.*)(?:;)/i",$data, $result);//匹配hash大致字符串
	$data = $result[1][0];
	$data = substr($data, 2, strlen($data)-3);
	return $data;
}

function getjson($url) {
	$curl = curl_init();//创建一个新的CURL资源
	$headers = rand_headers();
	curl_setopt($curl,CURLOPT_URL,$url);//设置URL和相应的选项
	curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);//伪造请求ip
	$ua = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36";
	curl_setopt($curl,CURLOPT_USERAGENT,$ua);//模拟windows用户正常访问
	curl_setopt($curl,CURLOPT_REFERER,"https://pv.vlogdownloader.com/");//伪造请求源referer
	curl_setopt($curl,CURLOPT_HEADER,0);//0表示不输出Header，1表示输出
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);//数据不输出到页面
	$json = curl_exec($curl);
	curl_close($curl);
	return $json;
}

function rand_headers(){//随机ip
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

function writeurl($TxtFileName,$str) {
	if(($TxtRes=fopen($TxtFileName,"w+")) === FALSE){//读写打开，不存则创建
	//创建失败
	exit();
	}
	//创建成功
	if(!fwrite($TxtRes,$str)) {//写入
	//写失败
	fclose($TxtRes);
	exit();
	}
	//写成功
	fclose($TxtRes);//关闭指针
}

?>
