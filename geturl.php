<html>
<head>
<?php
$url0 = "https://www.parsevideo.com";
$result = file_get_contents($url0);//输出parsevideo.com网站，为获取hash
echo $result;
?>
<script type="text/javascript">
var av = "36417189";
var hash = "",str1 = "",url1 = "",str1 = "",url = "";
function load() {//获取url0源代码，为了获取动态hash
        var str=document.getElementsByTagName('html')[0].innerHTML;
        return str;
	}
str1 = load();
function gethash() {//实时获取hash字符串hash="…………"
	hash = str1.match(/hash = (\S*)/)[1];//匹配hash大致字符串
	hash = hash.substring(1, hash.length-2);//hash加工截取
	return hash;
	}
url1 = "https://www.parsevideo.com/api.php?url=https://www.bilibili.com/video/av" + av + "&hash=" + gethash();
var name = "getapi",value = url1//js定义cookie数据
document.cookie = name+" = " + value + ";"//js写入cookie数据
</script>

<?php
if (isset($_COOKIE["getapi"])) {
$url1 = $_COOKIE["getapi"];//php读取js写入的cookie数据
$UserAgent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
$curl = curl_init();//创建一个新的CURL资源
curl_setopt($curl,CURLOPT_URL,$url1);//设置URL和相应的选项
curl_setopt($curl,CURLOPT_HEADER,0);//0表示不输出Header，1表示输出
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);//设定是否显示头信息,1显示，0不显示//如果成功只将结果返回，不自动输出任何内容。如果失败返回FALSE
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($curl,CURLOPT_ENCODING,'');//设置编码格式，为空表示支持所有格式的编码//header中“Accept-Encoding: ”部分的内容，支持的编码格式为："identity"，"deflate"，"gzip"
curl_setopt($curl,CURLOPT_USERAGENT,$UserAgent);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);//设置这个选项为一个非零值(象 “Location: “)的头，服务器会把它当做HTTP头的一部分发送(注意这是递归的，PHP将发送形如 “Location: “的头)
$data=curl_exec($curl);//获取返回的json代码
curl_close($curl);//关闭cURL资源，并释放系统资源//echo curl_errno($curl); //返回0时表示程序执行成功
if ($data == '{"captcha":"ok","message":"\u4e3a\u4e86\u9632\u6b62\u975e\u6388\u6743\u4f7f\u7528\u672c\u7ad9\u63a5\u53e3\uff0c\u8bf7\u8f93\u5165\u9a8c\u8bc1\u7801\uff01"}') {
	include("./Snoopy.class.php");
	$data = new Snoopy;
	$data->fetch($url1);//获取所有内容
	$data = $data->results;
	echo $data;
	} else {
	echo $data;
	}
} else {
echo "<script language=JavaScript> location.replace(location.href);</script>";//php刷新页面
}
?>
<script type="text/javascript">
str2 = load();//再次获取含有json代码的网页源码
function getjson(){//获取含有url字符串的json数据
	str2 = str2.match(/{"pa(\S*)/)[1];//匹配json大致字符串
	return str2;
	}
var json = getjson()
json = json.replace(/[\\]/g,'');json = json.replace('amp;','');json = json.replace('amp;','');json = json.replace('amp;','');json = json.replace('amp;','');json = json.replace('amp;','');json = json.replace('amp;','');json = json.replace('amp;','');json = json.replace('amp;','');json = json.replace('amp;','');
//alert(json);
function geturl(){//解析返回josn字符串代码获取视频URL
	var str = json//JSON.stringify();//定义json对象转换字符
	url = str.match(/url(\S*)thumb/)[1];//匹配url大致字符串
	url = url.substring(3, url.length-3);//url加工截取
	url = "https" + url.substring(4, url.length);//url替换为https
	//url = String(url);
	return url;
	}
//alert(geturl());
var name = "geturl",value = geturl();//js定义cookie数据
document.cookie = name + " = " + value + ";";//js写入cookie数据
</script>
</head>
<body>
<iframe src="writeurl.php" frameborder="0" height="0" width="0"></iframe>
</body>
</html>
