<?php

function dependencies_met()
{
  return is_dir('definitions') && file_exists('plugins/.installed/.definitions');
}
