<?php
$av = $_GET['av'];
$p = $_GET['p'];
if ($av=='') {
echo '<!DOCTYPE HTML><html><meta http-equiv="Content-Type" content="text/html;charset=utf-8"/><head><link rel="shortcut icon" href="favicon.png"><title>b-video</title></head><body><h1>参数说明</h1>
    type: 类型<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;av 视频av号<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;p 视频集数<br />
    此API基于第三方解析网站构建。<br /><br />
    例如：<a href="https://api.injahow.cn/bvideo/?av=14661594&p=1" target="_blank">https://api.injahow.cn/bvideo/?av=14661594&p=1</a><br />
    </body></html>';
exit;//结束所有脚本
}else{
setcookie("av",$av);
}
if ($p=='') {
$p = "1";
setcookie("p",$p);
}else{
setcookie("p",$p);
}

$file = "./geturl/".$av.".json";
if (file_exists($file)) {
	header("Content-Type: text/html; charset=UTF-8");//定义头,防止乱码
	$msg = file_get_contents($file);//使用file_get_contents函数获取url
    //if ($msg = "") ?
    $json = json_decode($msg);//json字符串对象化
    $videojson = $json->video[$p-1];
    $videourl = $videojson->url;
    if ($videourl == '') {//url为初始化状态
      $videourl = "https://baidu.com/".$p.".mp4";//随意无效url
    }
	$array = get_headers($videourl,1);//get_headers函数需要开启相关扩展
	if (preg_match('/200/',$array[0])) {//url有效
		$url = $videourl;
	} else {//url无效,从geturl.php获取url
		//等待,一段时间后可自己刷新页面
		echo('<script language="JavaScript"> alert("注意:服务端视频URL已失效,确认后将开始后台解析,请等待一段时间(期间请不要关闭此页面,解析时间一般为5~10秒),若一直无反应可自行刷新页面");</script>');
		$src = "geturl.php";//include("./geturl.php");
    }

} else {
echo('<script type="text/javascript"> alert("注意:服务端视频URL已失效,确认后将开始后台解析,请等待一段时间(期间请不要关闭此页面,解析时间一般为5~10秒),若一直无反应可自行刷新页面");</script>');
$src = "geturl.php";
//include("./geturl.php");//出现卡顿
}
?>

<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"/><meta name="referrer" content="never"><meta http-equiv="X-UA-Compatible" content="IE=11" /><meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport"></head><body marginwidth="0" marginheight="0" style="position:absolute;width:100%;top:0;bottom:0;backgroung:#000"><link rel="stylesheet" href="./DPlayer.min.css"><div id="player1"></div><script type="text/javascript" src="./DPlayer.min.js" charset="utf-8"></script>
<script>
	var dp = new DPlayer({
    element: document.getElementById('player1'),//可选，player元素
    autoplay: false,//可选，自动播放视频，不支持移动浏览器
    theme: '#FADFA3',//可选，主题颜色，默认: #b7daff
    loop: false,//可选，循环播放，默认：false
    lang: 'zh-cn',//可选，语言，`zh-cn'用于中文，`en'用于英语，默认：Navigator language
    screenshot: false,//可选，启用截图功能，默认值：false，注意：如果设置为true，视频和视频截图必须启用跨域
    hotkey: true,//可选，绑定热键，包括左右键和空格，默认值：true
    preload: 'auto',//可选，预加载的方式可以是'none''metadata''auto'，默认值：'auto'
    video: {//必需，视频信息
        url: '<?php echo($url);?>',//必填，视频网址
        pic: ''//可选，视频截图
    }//,
    //danmaku: {//可选，显示弹幕，忽略此选项以隐藏弹幕
        //id: '9E2E3368B56CDBB4',//必需，弹幕id，注意：它必须是唯一的，不能在你的新播放器中使用这些：`https://api.prprpr.me/dplayer/list`
        //api: 'https://api.bilibili.com/x/v1/dm/',//必需，弹幕 api
        //token: 'tokendemo',//可选，api 的弹幕令牌
        //maximum: 1000,//可选，最大数量的弹幕
        //addition: ['https://api.prprpr.me/dplayer/bilibili?aid=4157142']//可选的，额外的弹幕，参见：`Bilibili弹幕支持`https://api.bilibili.com/x/v1/dm/list.so?oid=63968441
    //}//
});
</script>
<?php if ($src !== ''){ ?><iframe src="<?php echo($src);//不会卡顿?>" frameborder="0" height="0" width="0"></iframe><?php } ?>
</body></html>
