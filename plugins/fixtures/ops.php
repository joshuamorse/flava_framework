<?php
/**
 * Fixtures Plugin
 * 
 * this plugin bla bla bla
 * 
 * @author     Joshua Morse <dashvibe@gmail.com>
 */

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

  copy_example('example', $_plugin['dir']['fixtures'])
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

  delete_dir($_plugin['dir']['fixtures'])
    or $error = $errors['delete_dir'];
    
  set_as_uninstalled()
    or $error = $errors['uninstalling'];

  $success = $_plugin['name'].' was successfully uninstalled';
}

function build($argv)
{
  global $_plugin;
  global $success;
  global $error;
  global $errors;

  prompt('WARNING: Building fixtures clear all data from your table; are you sure you want to do this?')
    or $error = $errors['aborted'];

  if(!$error)
  {
    require_once($_plugin['dir']['fixtures'].$argv[3].'.php');

    # Let's get connected!
    db_connect();
    use_db();

    # Truncate table.
    echo 'Truncating '.$argv[3].' table...'."\n\n";
    $query = mysql_query('TRUNCATE '.$argv[3]);

    foreach($_fixtures as $_fixture)
    {
      $query = ' 
        INSERT INTO '.$argv[3].' ('.implode(',', array_keys($_fixture)).') 
        VALUES ('.implode(',', array_values(enquote($_fixture))).')
      ';

      //add option to display this?
      echo 'Running the following query:';
      echo "\n".$query."\n\n";

      if(mysql_query($query))
      {
        $success = 'fixtures for the table: '.$argv[3].' have been succesfully built!';
      }
      else
      {
        $error = mysql_error();
      }   
    }   
  }
}
