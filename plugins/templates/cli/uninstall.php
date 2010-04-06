<?php

$plugin_name = 'templates';

if(run('rm -rf '.DIR_TEMPLATES))
{
  run('rm '.DIR_INSTALLED.'.'.$plugin_name);
  $success = $plugin_name.' was successfully uninstalled!';
}
else
{
  $error = 'There was an error uninstalling '.$plugin_name;
}
