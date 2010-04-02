<?php

if(run('rm plugins/.installed/.sqlTableBuilder'))
{
  $success = 'sqlTableBuilder successfully uninstalled!';
}
else
{
  $error = 'There was a problem uninstalling sqlTableBuilder!';
}
