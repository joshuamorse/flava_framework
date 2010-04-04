<?php

$file = DIR_INSTALLED.'.flava_table_builder';

if(file_exists($file))
{
  if(run('rm '.$file))
  {
    $success = 'flava_table_builder successfully uninstalled!';
  }
  else
  {
    $error = 'There was a problem uninstalling flava_table_builder!';
  }
}
else
{
  $error = 'flava_table_builder is not installed!';
}
