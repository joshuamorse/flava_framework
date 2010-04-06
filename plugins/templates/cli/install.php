<?php

$plugin_name = 'templates';

if(run('mkdir '.DIR_TEMPLATES))
{
  //if(run('cp -r '.DIR_PLUGINS.'definitions/lib/definition.php.example '.DIR_FLAVA_TEMPLATES))
  //{
    run('touch '.DIR_INSTALLED.'.'.$plugin_name);
    $success = $plugin_name.' was successfully installed!';
  //}
}
else
{
  $error = 'There was an error installing '.$plugin_name;
}
