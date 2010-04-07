<?php
/**
 * Fixtures Plugin
 * 
 * this plugin bla bla bla
 * 
 * @author     Joshua Morse <dashvibe@gmail.com>
 */

function get_twitter_feed($id)
{
  $feed = 'http://twitter.com/statuses/user_timeline/'.$id.'.rss';
  $feed = file_get_contents($feed);
  $feed = new SimpleXmlElement($feed);

  return $feed;
}

function get_twitter_feed_list($id, $max_tweets = NULL)
{
  $feed = get_twitter_feed($id);

  $rtn = '<ul>';

    for($i = 0; $i < $max_tweets; $i++)
    {
      $rtn .= '<li>'.str_replace('JoshuaMorse: ', '', $feed->channel->item[$i]->title).'</li>';
    }

  $rtn .= '</ul>';

  return $rtn;
}
