<?php

require('plugins/flava_table_builder/lib/flava_table_builder.functions.php');

if(dependencies_met())
{
  run('touch '.DIR_INSTALLED.'.flava_table_builder');
  $success = "Looks like definitions is installed; you're ready to rock!";
}
else
{
  $error = "flava_table_builder requires definitions to be installed.";
}
