<?php

if(run('mkdir definitions'))
{
  if(run('mv plugins/definitions/lib/definition.php.example definitions/'))
  {
    $success = 'definitions was successfully installed!';
  }
}
else
{
  $error = 'There was an error installing definitions.';
}
