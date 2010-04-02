<?php
function run($cmd)
{
  system($cmd, $output);

  # If success, cli returns output as 0, let's reverse that so that it makes sense.
  if($output == 0)
  {
    $rtn = 1;
  }

  return $rtn;
}

function color($str, $fg, $bg)
{
  global $system;

  require_once($system['dir']['lib']['class'] . 'colors.php');

  $colors = new Colors();

  return $colors->getColoredString($str, $fg, $bg);
}

function out($str, $fg = 0, $bg = 0)
{
  # Outputs text to the terminal.

  global $cli_config;
  
  if($fg)
  {
    echo color($str, $fg, $bg);
  }
  else
  {
    echo $str;
  }
}

function success($str)
{
  $out = color('SUCCESS:', 'light_green', 0);
  $out .= ' ' .$str;

  out($out);
}

function skip($str)
{
  $out = color('SKIPPING:', 'blue', 0);
  $out .= ' ' .$str;

  out($out);
}

function error($str)
{
  $out = color('ERROR:', 'light_red', 0);
  $out .= ' ' .$str;

  out($out);
}

function br()
{
  echo "\n";
}
