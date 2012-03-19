<?php
header("HTTP/1.1 301 Moved Permanently");
$go=$_GET['url'];
$remove = array('http:/','http://','https://','https:/');
$stripedUrl = str_replace($remove, '', $go);

if (substr($go, 0, 5)=='https'){
header('Location: https://'.$stripedUrl);
}else{
header('Location: http://'.$stripedUrl);
}
?>