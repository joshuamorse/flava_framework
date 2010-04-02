<?php

# Builds a SQL table!

if(isset($argv[2]))
{
  # Let's get connected!
  db_connect();
  use_db();

  # Fetch the requested table definition and its fixtures.
  require(DIR_DEFINITIONS.$argv[3].'.definition.php');
  //require($system['dir']['def'] . $argv[2] . '/fixtures.php');

  if(isset($_definition))
  { 
    # Drop the current table. Should really be its own script, no?
    # Check for table existence.
    if(mysql_query('SELECT * FROM ' . $_definition['name']))
    {
      mysql_query('DROP TABLE ' . $_definition['name']);
    }

    # Let's build this noise!
    $query  = 'CREATE TABLE ' . $_definition['name'] . '(' . "\n"; 

    # We'll foreach through the table def and build the SQL string as needed.
    foreach ($_definition['fields'] as $field => $data)
    {
      $query .= $field . ' ' . strtoupper($data['type']);
      
      if($data['length'])
      {
        $query .= '(' . $data['length'] . ')';
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
      //$query .= ",\n" . 'PRIMARY KEY(' . $_definition['primary'] .')';
      $query .= 'PRIMARY KEY(' . $_definition['primary'] .')';
    }

    # End query here.
    $query .= "\n" . ')';

    //add option to display this!
    //echo "\n";
    //echo $query;
    //echo "\n";
    //echo "\n";

    if(mysql_query($query))
    {
      //$success = 'Created ' . $_definition['name'] . ' with the following query: ' . "\n" . $query;
      $success = 'Created "' . $_definition['name'] . '"';
    }
    else
    {
      $error = mysql_error();
    }

    //if(isset($fixtures))
    //{
      //# Load fixtures;
      //foreach ($fixtures as $fixture)
      //{
        //$query = '
          //INSERT INTO ' . $_definition['name'] . ' (' . implode(',', array_keys($fixture)) .')
          //VALUES (' . implode(',', array_values(enquote($fixture))) . ')
        //';

        //if(mysql_query($query)) {
          //$success = 'Created "' . $_definition['name'] . '" and loaded its fixtures!';
        //} else {
          //$error = mysql_error();
        //}
      //}
    //}
  }
  else
  {
    skip($argv[2]);
  }
}
else
{
  $error = 'learn to use this crap!';
}
