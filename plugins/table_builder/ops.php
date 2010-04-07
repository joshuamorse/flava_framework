<?php

$errors['usage'] = 'Usage: [ build/install/uninstall ] [ definition ]';

function install($argv)
{
  global $_plugin;
  global $success;
  global $error;
  global $errors;

  !plugin_is_installed($_plugin['name'])
    or $error = $errors['installed'];

  set_as_installed()
    or $error = $errors['installing'];

  $success = $_plugin['name'].' was successfully installed';
}

function uninstall($argv)
{
  global $_plugin;
  global $success;
  global $error;
  global $errors;

  plugin_is_installed($_plugin['name'])
    or $error = $errors['not_installed'];

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

  plugin_is_installed($_plugin['name'])
    or $error = $error['not_installed'];

  isset($argv[3])
    or $error = $errors['usage'];

  prompt('WARNING: Building a table from a definition will clear all data from your table; are you sure you want to do this?')
    or $error = $errors['aborted'];

  if(!$error)
  {
    # Let's get connected!
    db_connect();
    use_db();

    # Get definition config.
    $_definition = get_plugin_config('definitions');

    # Fetch the requested table definition and its fixtures.
    require($_definition['dir']['definitions'].$argv[3].'.php');

    # Drop the current table. Should really be its own script, no?
    # Check for table existence.
    if(mysql_query('SELECT * FROM ' . $_definition['name']))
    {
      mysql_query('DROP TABLE ' . $_definition['name']);
    }

    # Let's build this noise!
    $query = 'CREATE TABLE '.$_definition['name'].'('."\n"; 

    # We'll foreach through the table def and build the SQL string as needed.
    foreach($_definition['fields'] as $field => $data)
    {
      $query .= $field.' '.strtoupper($data['type']);
      
      if($data['length'])
      {
        $query .= '('.$data['length'].')';
      }
      
      if(!$data['null'])
      {
        $query .= ' NOT NULL';
      }

      if($data['auto_inc'])
      {
        $query .= ' AUTO_INCREMENT';
      }

      # Add a comma and line break.
      $query .= ",\n";

      # Output relational data.
      if(isset($data['relation']))
      {
        $query .= 'INDEX ' . $data['relation']['name']. '_rel(' . $data['relation']['name'] . '_id)';
        $query .= ',' . "\n" . 'FOREIGN KEY(' . $data['relation']['name'] . '_id) REFERENCES ' . $data['relation']['name'] . '(id) ON DELETE CASCADE';
        $query .= ",\n";
      }
    }

    if($_definition['primary'])
    {
      $query .= 'PRIMARY KEY('.$_definition['primary'].')';
    }

    # End query here.
    $query .= "\n".')';

    //add option to display this!
    echo 'Executing the following query:'."\n".$query."\n\n";

    if(mysql_query($query))
    {
      //$success = 'Created ' . $_definition['name'] . ' with the following query: ' . "\n" . $query;
      $success = 'Created "'.$_definition['name'].'"';
    }
    else
    {
      $error = mysql_error();
    }
  }
}
