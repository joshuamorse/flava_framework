<?php

if(run('rm -rf definitions'))
{
  run('rm plugins/.installed/.definitions');
  $success = 'definitions was successfully uninstalled!';
}
else
{
  $error = 'There was an error uninstalling definitions';
}
