<?php

function create_dir($dir)
{
  return run('mkdir '.$dir);
}

function copy_example($example, $dest)
{
  global $_plugin;

  return run('cp '.DIR_PLUGINS.$_plugin['name'].'/lib/'.$example.'.php '.$dest);
}

function autoload_select_plugin_assets()
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
}

function plugin_is_installed($plugin)
{
  echo file_exists(DIR_INSTALLED.'.'.$plugin);
  return file_exists(DIR_INSTALLED.'.'.$plugin);
}

function set_as_installed()
{
  global $_plugin;

  return run('touch '.DIR_INSTALLED.'.'.$_plugin['name']);
}
