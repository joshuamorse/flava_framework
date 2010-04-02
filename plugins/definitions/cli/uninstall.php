<?php

if(run('rm -rf definitions'))
{
  $success = 'definitions was successfully uninstalled!';
}
else
{
  $error = 'There was an error uninstalling definitions';
}
