<?php

function include_css($css)
{
  global $_plugin;

  echo '<link rel="stylesheet" type="text/css" href="/'.$_plugin['dir']['css'].$css.'.css" />';
}

function include_js($js)
{
  global $_plugin;

  echo '<script type="text/javascript" src="/'.$_plugin['dir']['js'].$js.'.js"></script>';
}
