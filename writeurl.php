<?php
if (isset($_COOKIE["geturl"])) {
$TxtFileName = "geturl.txt";//文件名称
if (($TxtRes=fopen($TxtFileName,"w+")) === FALSE) {//以读写方式打写指定文件，如果文件不存则创建
//创建可写文件$TxtFileName失败
exit();
}
//创建可写文件$TxtFileName成功
$StrConents = $_COOKIE["geturl"];//要写进文件的内容
if (!fwrite($TxtRes,$StrConents)) {//将信息写入文件
//尝试向文件$TxtFileName写入$StrConents失败
fclose($TxtRes);
exit();
}
//尝试向文件$TxtFileName写入$StrConents成功！
fclose($TxtRes); //关闭指针
setcookie('getapi', null);//php删除名为getapi的cookie
setcookie('geturl', null);//php删除名为geturl的cookie
echo('<script language="JavaScript">top.location.href=top.location.href;alert("解析完毕!!!");</script>');//写入url后刷新主页面并弹出提示框
} else {
echo "<script language=JavaScript>location.replace(location.href);</script>";//php刷新页面
}
?>
