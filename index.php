<html>
<head>
<meta name="referrer" content="no-referrer"/>
</head>
<body>
<?php
$file = "geturl.txt";
if(file_exists($file)){
$msg = file_get_contents($file);//使用file_get_contents函数获取url
$array = get_headers($msg,1);
if(preg_match('/200/',$array[0])){//判断url有效性
$src="";
$url=$msg;
}else{//url无效,从iframe获取url
$src="geturl.php";
//提示等待,一段时间后可自己刷新页面
echo('<script language="JavaScript"> alert("注意:服务端视频URL已失效,确认后将开始后台解析,请等待一段时间(期间请不要关闭此页面,解析时间一般为5~25秒),若30秒后无反应可自行刷新页面");</script>');
}
}
?>
<iframe src="<?php echo($src);?>" frameborder="0" height="0" width="0"></iframe>
<!--............................................................................................................................................................................................................................................................................................................................................. -->
<link rel="stylesheet" href="./DPlayer.min.css">
<div id="player1" class="dplayer"></div>
<!-- ... -->
<script src="./DPlayer.min.js"></script>
<script>
	var dp = new DPlayer({
    element: document.getElementById('player1'),//可选，player元素
    autoplay: false,//可选，自动播放视频，不支持移动浏览器
    theme: '#FADFA3',//可选，主题颜色，默认: #b7daff
    loop: true,//可选，循环播放音乐，默认：true
    lang: 'zh',//可选，语言，`zh'用于中文，`en'用于英语，默认：Navigator language
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


</body>
</html>

