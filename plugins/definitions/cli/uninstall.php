<?php

if(run('rm -rf '.DIR_DEFINITIONS))
{
  run('rm '.DIR_INSTALLED.'.definitions');
  $success = 'definitions was successfully uninstalled!';
}
else
{
  $error = 'There was an error uninstalling definitions';
}
