<?php 

class Parse
{
    var $signals = array();
	var $input = "";
	var $output = "";
	var $post = "";
	
    function __construct($input_param,$id)
    {
    	$input = $input_param;
		$post = $id;
		echo 'dentro post = '.$post.' '.$input;
		$output = html_entity_decode($input);
		
		
		//$lines = preg_match_all("$pattern", $subject)a
		/*
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
							$post->feed = $feed;
							$post->id  = (string) $item->id;
				            $post->date  = (string) $item->updated;
				            $post->ts    = strtotime($item->updated);
				            $post->link  = (string) $item->link['href'];
				            $post->title = (string) $item->title;
				            $post->text  = (string) $item->content;
				
				            // Create summary as a shortened body and remove images, 
				            // extraneous line breaks, etc.
				            //$post->summary = $this->summarizeText($post->text);
							$post->summary = (string) $item->summary;
				            $this->posts[] = $post;
				        }
					break;
														
		}
		 * 
		 */
     }

    }
?>