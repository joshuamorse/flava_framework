<?php

$errors = array(
  'installed' => $_plugin['name'].' is already installed',
  'not_installed' => $_plugin['name'].' is not installed',
  'create_dir' => 'error creating '.$_plugin['dir']['definitions'],
  'delete_dir' => 'error deleting '.$_plugin['dir']['definitions'],
  'example' => 'error copying example file/s',
  'installing' => 'error installing '.$_plugin['name'],
  'uninstalling' => 'error uninstalling '.$_plugin['name'],
);

function install()
{
  global $_plugin;
  global $success;
  global $error;
  global $errors;

  !plugin_is_installed($_plugin['name'])
    or $error = $errors['installed'];

  create_dir($_plugin['dir']['definitions'])
    or $error = $errors['create_dir'];

  copy_example('example', $_plugin['dir']['definitions'])
    or $error = $errors['example'];

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

  delete_dir($_plugin['dir']['definitions'])
    or $error = $errors['delete_dir'];
    
  set_as_uninstalled()
    or $error = $errors['uninstalling'];

  $success = $_plugin['name'].' was successfully uninstalled';
}
