<?php
//header("HTTP/1.1 301 Moved Permanently");
$go=$_GET['url'];
$remove = array('http:/','http://','https://','https:/');
$stripedUrl = str_replace($remove, '', $go);
$url= (substr($go, 0, 5)=='https') ? 'https://'.$stripedUrl : 'http://'.$stripedUrl;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<meta name="robots" content="noindex,nofollow">	
<title>Redirecting..</title> 
<style type="text/css"> body { font: 62.5% "Lucida Grande", Arial, sans-serif; background-color: #f6f6f6; color: #777;}#main {margin: 15% auto; width: 730px; margin-bottom: 10px; overflow: hidden;padding: 0px; border: 1px solid #cbcbcb; -moz-border-radius: 10px; -webkit-border-radius:10px; background:#fff;text-align:center; }h1 { font: 30px Arial, Helvetica, sans-serif; letter-spacing:-1px; padding:10px 0 0 0; margin: 0; }h2 { font:18px Arial, Helvetica, sans-serif; padding: 0  0 3px 0; margin-bottom: 5; }h1, h2, h3, h4, h5 { color:#222; }a {text-decoration: none; color: #08c; font:14px  Arial, Helvetica, sans-serif;  }</style> 
</head> 
<body>
<div id="main">
<h1>Redirecting..</h1>
<h2><?=$url?></h2>
</div>	
<script>setTimeout("location.href = '<?=$url?>';",2500);</script>
</body> 
</html>