<?php
//curl http://rss.cnn.com/rss/cnn_topstories.rss --append >> rss/`date +%s`_result.rss
error_reporting(E_ALL);
require_once("curl_rss_config.php");
ini_set('display_errors', true);

$ca = $catcher[$_REQUEST['catcher']];
$ch = curl_init($ca['rss']);
echo __DIR__."/".$ca['title']."/rss";//$_SERVER['DOCUMENT_ROOT']."/catch/".$ca['title']."/rss";
$fp = tempnam(__DIR__."/".$ca['title']."/rss", $ca['title']);

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

$response = curl_exec($ch);
echo $response;
curl_close($ch);
fclose($fp);
?>
