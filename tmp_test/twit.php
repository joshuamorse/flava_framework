<?php

require('plugins/twitter/lib/functions.php');

$feed = get_twitter_feed(14983693);

if(is_object($feed))
{
  echo 'I see a feed object; looks good!'."\n";
  echo "\n";
  echo get_twitter_feed_list(14983693, 3);
  echo "\n";
  //print_r($feed);
}
