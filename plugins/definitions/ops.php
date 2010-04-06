<?php

function install()
{
  global $_plugin;
  global $success;
  global $error;

  $errors = array(

  );

  !plugin_is_installed($_plugin['name']) or $error = $_plugin['name'].' is already installed';
  create_dir($_plugin['dir']['definitions']) or $error = 'error creating '.$_plugin['dir']['definitions'];
  copy_example('example', $_plugin['dir']['definitions']) or $error = 'error copying example file/s';
  set_as_installed() or $error = 'error installing '.$_plugin['name'];

  $success = $_plugin['name'].' was successfully installed';
}

function uninstall()
{
}
