<?php

require('user/config/app.php');

$_log = array();

function log_me($str)
{
  global $_log;
  $_log[] = $str;
}

function fwd_404()
{
  die('404!');
}

function curr_url()
{
  return url_explode($_SERVER['REQUEST_URI']);
}

function url_explode($url)
{
  $url = explode('/', $url);
  array_shift($url);
  
  return $url;
}

function is_route_wildcard($def)
{
  return preg_match('/\:.*/', $def);
}

function url_for($route, $vars = 0)
{
  global $_routes;

  $og_route = $route;
  $route = url_explode($_routes[$route]['url']);

  foreach($route as $key => $val)
  {
    # Check if the current route iteration is that of a wildcard.
    # We'll modify our $route array to include any passed values.
    # E.g. /this/:var will return this/passedVar

    if(is_route_wildcard($val))
    {
      $r = str_replace(':', '', $val);
      
      if($vars[$r])
      {
        $route[$key] = $vars[$r];
      }
      else
      {
        die('missing var!');
      }
    }
  }

  # Return the URL.
  return '/' . implode('/', $route);
}

function db_connect()
{
  # add stuff here for localhost/server connections
  global $_app;

  return mysql_connect($_app['db']['local']['host'], $_app['db']['local']['user'], $_app['db']['local']['pass']);
}

function use_db()
{
  global $_app;

  db_connect();

  return mysql_select_db($_app['db']['local']['name']);
}

function enquote($arr)
{
  foreach($arr as $key => $val)
  {
    $arr[$key] = '"' . $val . '"';
  }

  return $arr;
}

function pre($arr)
{
  echo '<pre style="font-face:myriad pro">';
    print_r($arr);
  echo '</pre>';
}

function is_ajax_request()
{
  return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}

function get_mod_path($module, $action)
{
  global $_dir;

  return $_dir['module'] . $module . '/' . $action . '/';
}
