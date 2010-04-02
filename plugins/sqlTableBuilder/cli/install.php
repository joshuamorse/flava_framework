<?php

require('plugins/sqlTableBuilder/lib/sql_table_builder.functions.php');

if(dependencies_met())
{
  run('touch plugins/.installed/.sqlTableBuilder');
  $success = "Looks like definitions is installed; you're ready to rock!";
}
else
{
  $error = "sqlTableBuilder requires definitions to be installed.";
}
