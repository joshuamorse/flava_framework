<?php

function get_fixtures($fixture_def)
{
  global $_plugin;

  require_once($_plugin['dir']['fixtures'].$fixture_def.'.php');

  return $_fixtures;
}

function get_fixture_id($needle_key, $fixtures)
{
  foreach($fixtures AS $key => $fixture)
  { 
    if(array_search($needle_key, $fixture)) 
    {
      return ($key + 1); 
    }
  }

  return false; 
}
