<?php

function install()
{
  global $_plugin;
  global $success;
  global $error;
  global $errors;

  !plugin_is_installed($_plugin['name'])
    or $error = $errors['installed'];

  create_dirs($_plugin['dir'])
    or $error = $errors['create_dir'];

  set_as_installed()
    or $error = $errors['installing'];

  $success = $_plugin['name'].' was successfully installed';
}

function uninstall()
{
  global $_plugin;
  global $success;
  global $error;
  global $errors;

  plugin_is_installed($_plugin['name'])
    or $error = $errors['not_installed'];

  delete_dirs($_plugin['dir'])
    or $error = $errors['delete_dir'];
    
  set_as_uninstalled()
    or $error = $errors['uninstalling'];

  $success = $_plugin['name'].' was successfully uninstalled';
}
