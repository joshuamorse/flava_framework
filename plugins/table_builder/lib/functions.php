<?php

function dependencies_met()
{
  return is_dir(DIR_DEFINITIONS) && file_exists(DIR_INSTALLED.'.definitions');
}
