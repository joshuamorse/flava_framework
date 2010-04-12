<?php
/**
 * Functions Plugin
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

  create_dir($_plugin['dir']['user'])
    or $error = $errors['create_dir'];

  create_dir($_plugin['dir']['base'])
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

  delete_dir($_plugin['dir']['base'])
    or $error = $errors['delete_dir'];
    
  delete_dir($_plugin['dir']['user'])
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

  # Fetch definitions functions.
  require(get_plugin_functions_path_for('definitions'));
  
  $_definition = get_definition_for($argv[3]);

  //print_r($_definition); die();

  # Build declare fields string.

  $_declare_fields = '';
  $_get_methods = '';
  $_one_to_one_methods = '';

  foreach($_definition['fields'] as $name => $data)
  {
    if(!isset($data['relation']))
    {
    $_declare_fields .= "\t".'private $'.$name.';'."\n"; 

    $_get_methods .= "\n\t".'public function get_'.$name.'()'."\n"; 
    $_get_methods .= "\t".'{'."\n"; 
    $_get_methods .= "\t\t".'return $this->'.$data['field'].';'."\n"; 
    $_get_methods .= "\t".'}'."\n"; 
    }
    else
    {
      //one-to-one: user.clan_id -> clan.id (one)
      //one-to-many: user -> comment.user_id (many)
      //many-to-many: user.id -> song.id -> song2user.user_id + song2user.song_id (many)

      if($data['relation']['type'] == 'one-to-one')
      {
        $_one_to_one_methods .= "\t".'public function get_'.$name.'()'."\n"; 
        $_one_to_one_methods .= "\t".'{'."\n"; 
        $_one_to_one_methods .= "\t\t".'$query = mysql_query(\'SELECT * FROM '.$data['relation']['foreign']['table'].' WHERE id = \'.$this->'.$data['field'].');'."\n"; 
        $_one_to_one_methods .= "\t\t".'return mysql_fetch_assoc($query);'."\n"; 
        $_one_to_one_methods .= "\t".'}'."\n"; 
      }

      if($data['relation']['type'] == 'one-to-many')
      {
        $_one_to_many_methods .= "\t".'public function get_'.$name.'()'."\n"; 
        $_one_to_many_methods .= "\t".'{'."\n"; 
        $_one_to_many_methods .= "\t\t".'$query = mysql_query(\'SELECT * FROM '.$data['relation']['foreign']['table'].' WHERE '.$_definition['name'].'_id = \'.$this->'.$_definition['name'].'_id);'."\n"; 
        $_one_to_many_methods .= "\t\t".'return mysql_fetch_assoc($query);'."\n"; 
        $_one_to_many_methods .= "\t".'}'."\n"; 
      }

      if($data['relation']['type'] == 'many-to-many')
      {
        $query = '';
        $query .= 'SELECT *';
        $query .= ' FROM '.$_definition['name'].' t1, '.$data['relation']['foreign']['table'].' t2, '.$data['relation']['foreign']['joiner'].' jt';
        $query .= ' WHERE t1.id IS NOT NULL';
        $query .= ' AND tj.'.$_definition['name'].'_id = \'.$this->'.$_definition['name'].'_id.\'';
        $query .= ' AND t1.id = tj.'.$_definition['name'].'_id';
        $query .= ' AND t2.id = tj.'.$data['relation']['foreign']['table'].'_id';

        $_many_to_many_methods .= "\t".'public function get_'.$name.'()'."\n"; 
        $_many_to_many_methods .= "\t".'{'."\n"; 
        $_many_to_many_methods .= "\t\t".'$query = mysql_query(\''.$query.'\');'."\n"; 
        $_many_to_many_methods .= "\t\t".'return mysql_fetch_assoc($query);'."\n"; 
        $_many_to_many_methods .= "\t".'}'."\n"; 
      }
    }
  }

  # Fetch the template. Change this to example.php?
  $_functions = file_get_contents('plugins/functions/lib/base_template.php'); 

  # Replace the place holders.
  $_functions = str_replace('%table%', $_definition['name'], $_functions);
  $_functions = str_replace('%table_base%', $_definition['name'].'_base', $_functions);
  $_functions = str_replace('////declare_vars', $_declare_fields, $_functions);
  $_functions = str_replace('////get_methods', $_get_methods, $_functions);
  $_functions = str_replace('////one_to_one_methods', $_one_to_one_methods, $_functions);
  $_functions = str_replace('////one_to_many_methods', $_one_to_many_methods, $_functions);
  $_functions = str_replace('////many_to_many_methods', $_many_to_many_methods, $_functions);

  # Write the base functions file.
  $handle = fopen($_plugin['dir']['base'].$_definition['name'].'.php', 'w');

  if(fwrite($handle, $_functions))
  {
    $success = 'successfully built functions for '.$_definition['name'].'!';
  }

  # Write the user functions file, if none exists.
  $_user_function_path = $_plugin['dir']['user'].$_definition['name'].'.php';

  if(!file_exists($_user_function_path))
  {
    # Fetch the user template.
    $_functions = file_get_contents('plugins/functions/lib/user_template.php'); 

    $_functions = str_replace('%table_base%', $_definition['name'].'_base', $_functions);
    $_functions = str_replace('%table_user%', $_definition['name'], $_functions);

    # Write the user functions file.
    $handle = fopen($_plugin['dir']['user'].$_definition['name'].'.php', 'w');

    if(fwrite($handle, $_functions))
    {
      $success = 'successfully built functions for '.$_definition['name'].'!';
    }
  }
}
