<?php

function install()
{
  global $_plugin;
  global $success;
  global $error;
  global $errors;

  !plugin_is_installed($_plugin['name'])
    or $error = $errors['installed'];

  create_dir($_plugin['dir']['fixtures'])
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

  delete_dir($_plugin['dir']['fixtures'])
    or $error = $errors['delete_dir'];
    
  set_as_uninstalled()
    or $error = $errors['uninstalling'];

  $success = $_plugin['name'].' was successfully uninstalled';
}

function build($argv)
{
  if(isset($argv[3]))
  {
    # Load fixtures;
    foreach($fixtures as $fixture)
    {
      $query = ' 
        INSERT INTO '.$_definition['name'].' ('.implode(',', array_keys($fixture)).') 
        VALUES ('.implode(',', array_values(enquote($fixture))).')
      ';

      if(mysql_query($query))
      {
        $success = 'oh yeah?';
      }
      else
      {
        $error = mysql_error();
      }   
    }   
  } 
}
