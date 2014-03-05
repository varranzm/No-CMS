<?php

class BlogPost
{
    var $id;	
    var $date;
    var $ts;
    var $link;

    var $title;
    var $text;
}

//http://stackoverflow.com/questions/250679/best-way-to-parse-rss-atom-feeds-with-php
class BlogFeed
{
    var $posts = array();
	var $type = "";

    function __construct($file_or_url,$type_param)
    {
    	$type = $type_param;
        $file_or_url = $this->resolveFile($file_or_url);
        if (!($x = simplexml_load_file($file_or_url)))
            return;
		switch($type) {
			case 'rss':
				foreach ($x->channel->item as $item)
				        {
        	
				        	echo 'antesblog='.$post->title;
				            $post = new BlogPost();
							echo 'despues='.$post->title;
				            $post->date  = (string) $item->pubDate;
				            $post->ts    = strtotime($item->pubDate);
				            $post->link  = (string) $item->link;
				            $post->title = (string) $item->title;
				            ;
				            $post->text  = (string) $item->description;
				
				            // Create summary as a shortened body and remove images, 
				            // extraneous line breaks, etc.
				            $post->summary = $this->summarizeText($post->text);
				
				            $this->posts[] = $post;
				        }
					break;
			case 'feed':
				//print_r($x);
				foreach ($x->entry as $item)
				        {
				        	$post = new BlogPost();
							$post->id  = (string) $item->id;
				            $post->date  = (string) $item->updated;
				            $post->ts    = strtotime($item->updated);
				            $post->link  = (string) $item->link['href'];
				            $post->title = (string) $item->title;
				            ;
				            $post->text  = (string) $item->content;
				
				            // Create summary as a shortened body and remove images, 
				            // extraneous line breaks, etc.
				            //$post->summary = $this->summarizeText($post->text);
							$post->summary = (string) $item->summary;
				            $this->posts[] = $post;
				        }
					break;
														
		}
     }

    private function resolveFile($file_or_url) {
        if (!preg_match('|^https?:|', $file_or_url))
            $feed_uri = $file_or_url;
        else
            $feed_uri = $file_or_url;

        return $feed_uri;
    }

    private function summarizeText($summary) {
        $summary = strip_tags($summary);

        // Truncate summary line to 100 characters
        $max_len = 100;
        if (strlen($summary) > $max_len)
            $summary = substr($summary, 0, $max_len) . '...';

        return $summary;
    }
}
?>