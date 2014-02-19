<?php
//curl http://rss.cnn.com/rss/cnn_topstories.rss --append >> rss/`date +%s`_result.rss
error_reporting(E_ERROR);
require_once("curl_rss_config.php");
ini_set('display_errors', true);

$ca = $catcher[$_REQUEST['catcher']];
$ch = curl_init($ca['rss']);
//echo __DIR__."/".$ca['title']."/".$ca['type'];//$_SERVER['DOCUMENT_ROOT']."/catch/".$ca['title']."/rss";
//$fp = fopen(tempnam(__DIR__."/".$ca['title']."/".$ca['type'], $ca['title']),'rw');
$tempnam = tempnam('', $ca['title']);
$fp = fopen($tempnam,'w');

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);

fwrite($fp, $response);
curl_close($ch);
fclose($fp);

switch ($ca['title']) {
	case 'vladimir': 
		require_once(__DIR__."/parsers/vladimir.php");
		$bf = new BlogFeed ($tempnam,$ca['type']);
		print_r($bf->posts);
		break;
	case 'vladimirfeed': 
		require_once(__DIR__."/parsers/vladimir.php");
		$bf = new BlogFeed ($tempnam,$ca['type']);
		print_r($bf->posts);
		break;
} 

?>
