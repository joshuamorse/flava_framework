<?php

require('user/config/app.php');

$_dir = array(
  'system_lib' => 'system/lib/',
);

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

function temp($arr) { # includes stuff
  if(is_array($arr)) {
    foreach($arr as $val) {
      require('include/' . $val .'.php');
    }
  } else {
    require('include/' . $arr . '.php');
  }
}

function db_connect() {
  # add stuff here for localhost/server connections
  global $_app;

  return mysql_connect($_app['db']['local']['host'], $_app['db']['local']['user'], $_app['db']['local']['pass']);
}

function use_db() {
  global $_app;

  db_connect();

  return mysql_select_db($_app['db']['local']['name']);
}

function use_functions($def) {
  global $_dir;

  require($_dir['def'] . $def . '/function/index.php');
}

function enquote($arr) {
  foreach($arr as $key => $val) {
    $arr[$key] = '"' . $val . '"';
  }

  return $arr;
}

function pre($arr) {
  echo '<pre style="font-face:myriad pro">';
    print_r($arr);
  echo '</pre>';
}

function req($arr) {
  # dunno if this'll work properly
  foreach($arr as $require) {
    require($require);
  }
}

function get_form($def, $form) {
  global $system;
  global $errors;
  global $_dir;

  ob_start();

  require($_dir['def'] . $def . '/form/' .$form. '.php');
  
  return ob_get_clean();
}

function render_form($def) {
  global $system;

  require($system['dir']['def'] . $def . '/form/index.php');
}

function use_helper($helper) {
  global $system;

  require($system['dir']['helper'] . $helper . '.php');
}

function use_definition($def) {
  global $system;

  require($system['dir']['def'] . $def . '/index.php');
}

function validate_form($post) {
  pre($post);

  $errors = array('name' => 'invalid');

  return $errors;
}

function is_ajax_request() {
  return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}

function write_file_sig($file) {
  global $_user;

  $rtn = 0;

  $handle = fopen($file, 'w') or die('cannot open ' . $file);

  if(fwrite($handle, get_file_sig($file))) {
    $rtn = 1;
  }

  return $rtn;
}

function get_file_sig($file, $end_php = 0) {
  global $_user;

  # Define the sig.
  $sig = '';
  $sig .= '<?php' . "\n\n";
  $sig .= '# FLAVA FRAMEWORK' . "\n";
  $sig .= '# file: ' . $file . "\n";
  $sig .= '# author: ' . $_user['name'] . ' <' . $_user['email'] . '>' . "\n";
  
  if($end_php) {
    $sig .= "\n" . '?>';
  }

  $sig .= "\n";


  return $sig;
}

function get_validation_error($type) {
  # Return a validation error.

  global $_app;

  if($_app['error'][$type]) {
    # If the error of the type specified is defined in app.php...

    # We'll return that.
    return $_app['error'][$type];

  } else {
    # Otherwise, we'll return $_system's error.
    global $system;

    return $system['error'][$type];
  }
}

function get_mod_path($module, $action) {
  global $_dir;

  return $_dir['module'] . $module . '/' . $action . '/';
}

function use_js($js, $in_a_module = 0) {
  global $_route;

  # Set the route target array to a var for readability.
  $route = $_route['target'];

  if($in_a_module) {
    # If this function is being called in a module...

    # We'll include the module's js.
    $src = get_mod_path($route['module'], $route['action']) . 'include/'; 

  } else {
    # Otherwise, we'll include a global js.
    $src = $dir['js']; 

  }

  # Echo out the include string.
  echo '<script type="text/javascript" src="' . $src . $js . '.js"></script>';
}

function autoload_plugin_assets()
{
  require_once(DIR_USER_CONFIG.'autoload.php');

  foreach($_autoload as $plugin)
  {
    $functions = DIR_PLUGINS.$plugin.'/lib/'.$plugin.'.config.php';
    $config = DIR_PLUGINS.$plugin.'/lib/'.$plugin.'.functions.php';

    if(file_exists($config))
    {
      require($config);
    }

    if(file_exists($functions))
    {
      require($functions);
    }
  }

  # this will autoload all installed plugin functions.
  //$dhandle = opendir(DIR_PLUGINS);

  //if($dhandle)
  //{
    //while(false !== ($fname = readdir($dhandle)))
    //{
      //if(file_exists(DIR_INSTALLED.'.'.$fname))
      //{
        //if(!preg_match('/\./', $fname) && ($fname != basename($_SERVER['PHP_SELF'])))
        //{
          //$plugins[] = $fname;
        //}
      //}
    //}

  //closedir($dhandle);
  //} 

  //foreach($plugins as $plugin)
  //{
    //$file = DIR_PLUGINS.$plugin.'/lib/'.$plugin.'.config.php';

    //if(file_exists($file))
    //{
      //require($file);
    //}

    //unset($file);

    //$file = DIR_PLUGINS.$plugin.'/lib/'.$plugin.'.functions.php';

    //if(file_exists($file))
    //{
      //require($file);
    //}
  //}
}
