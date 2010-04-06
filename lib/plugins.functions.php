<?php

function create_dir($dir)
{
  return run('mkdir '.$dir);
}

function delete_dir($dir)
{
  # prompt here?
  return run('rm -rf '.$dir);
}

function copy_example($example, $dest)
{
  global $_plugin;

  return run('cp '.DIR_PLUGINS.$_plugin['name'].'/lib/'.$example.'.php '.$dest);
}

function get_autoload_list()
{
  require_once(DIR_USER_CONFIG.'autoload.php');

  $list = array();

  foreach($_autoload as $plugin)
  {
    $list[] = array(
      'config' => DIR_PLUGINS.$plugin.'/lib/config.php',
      'functions' => DIR_PLUGINS.$plugin.'/lib/functions.php',
    );
  }

  return $list;
}

function plugin_is_installed($plugin)
{
  return file_exists(DIR_INSTALLED.'.'.$plugin);
}

function set_as_installed()
{
  global $_plugin;

  return run('touch '.DIR_INSTALLED.'.'.$_plugin['name']);
}

function set_as_uninstalled()
{
  global $_plugin;

  return run('rm '.DIR_INSTALLED.'.'.$_plugin['name']);
}
