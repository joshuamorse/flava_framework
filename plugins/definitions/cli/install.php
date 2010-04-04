<?php

require(DIR_PLUGINS.'definitions/lib/definitions.config.php');

if(run('mkdir '.DIR_DEFINITIONS))
{
  if(run('cp -r '.DIR_PLUGINS.'definitions/lib/definition.php.example '.DIR_DEFINITIONS))
  {
    run('touch '.DIR_INSTALLED.'.definitions');
    $success = 'definitions was successfully installed!';
  }
}
else
{
  $error = 'There was an error installing definitions.';
}
