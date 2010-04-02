<?php

require(DIR_PLUGINS.'definitions/lib/definitions.config.php');

if(run('mkdir '.DIR_DEFINITIONS))
{
  if(run('cp plugins/definitions/lib/definition.php.example definitions/'))
  {
    run('touch plugins/.installed/.definitions');
    $success = 'definitions was successfully installed!';
  }
}
else
{
  $error = 'There was an error installing definitions.';
}
