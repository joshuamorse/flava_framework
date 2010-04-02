<?php

$file = DIR_INSTALLED.'.sql_table_builder';

if(file_exists($file))
{
  if(run('rm plugins/.installed/.sql_table_builder'))
  {
    $success = 'sqlTableBuilder successfully uninstalled!';
  }
  else
  {
    $error = 'There was a problem uninstalling sqlTableBuilder!';
  }
}
else
{
  $error = 'sqlTableBuilder is not installed!';
}
