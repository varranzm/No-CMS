<?php
//curl http://rss.cnn.com/rss/cnn_topstories.rss --append >> rss/`date +%s`_result.rss
error_reporting(E_ERROR);
require_once("curl_rss_config.php");
ini_set('display_errors', true);
openlog("curl_rss", LOG_PID | LOG_PERROR, LOG_USER);

if (empty($_REQUEST['catcher'])) {
	syslog(LOG_ERR,"Param catcher is mandatory, exiting...");
	closelog();
	exit(1);
}
$ca = $catcher[$_REQUEST['catcher']];
if (empty($ca)) {
	syslog(LOG_ERR,"Unknow catcher ".$_REQUEST['catcher'].", exiting...");
	closelog();
	exit(2);
}

if (!$ch = curl_init($ca['rss'])) {
	syslog(LOG_ERR,"Error initiating curl session ".$ca['rss'].", exiting...");
	closelog();
	exit(3);
}
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
	case 'vladimirrss': 
		require_once(__DIR__."/parsers/rss.php");
		$bf = new BlogFeed ($tempnam,$ca['type']);
		print_r($bf->posts);
		break;
	case 'vladimir':
		require_once(__DIR__."/parsers/rss.php");
		require_once(__DIR__."/parsers/vladimir.php");
		//¿Blogfeed exists?
		if (false) {
			syslog(LOG_WARNING,"Exiting...blog exists in db: (id,type,timestamp,hash)()");
			closelog();
			exit(0);
		} else {
			//insert blog
			syslog(LOG_INFO,"New blog inserted "./*id db creado*/", parsing rss.."); 
			require_once(__DIR__."/parsers/vladimir.php");
			$bf = new BlogFeed ($tempnam,$ca['type'],$ca['title']);
			if (count($bf->posts) > 0){
				syslog(LOG_INFO,count($bf->posts)." new blog posts, iterating ...");			
				foreach($bf->posts as $post) {
					//database exists'
					
					if (false) {
						//syslog(LOG_DEBUG,"Next...post exists in db: (feed;id)(".$post->feed.";".$post->id.")");
					} else {
						//insert database
						//syslog(LOG_INFO,"Inserted post ".$post->feed." ".$post->id);
						if (preg_match("#\bforecast\b#", $post->title)) {
							syslog(LOG_INFO,"Parsing signal of post ".$post->id."...");
							$signals = New Parse($post->text);
							echo "signals=".$signals->output ;
							
						} else {
							syslog(LOG_WARNING,"Title don't match ".$post->feed." ".$post->id." ".$post->title);
							//send mail to evaluate?
						}		
					}
				}
			} else {
				syslog(LOG_WARNING,"No items...¿correct xml? blog "./*db id*/" dump :\n".$bf->x);
				closelog();
				exit(0);
			}
		}
		break;
		
	} 
closelog();
?>
