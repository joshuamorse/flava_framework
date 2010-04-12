<?php

$_definition = array(
 'name' => 'clan',
  'engine' => 'MyISAM',
  'primary' => 'id',

  'fields' => array(
    'id' => array(
      'type' => 'int',
      'auto_inc' => 1,
    ),

    //'user_id' => array(
      //'type' => 'int',

      //'relation' => array(
        //'type' => 'many',
        //'name' => 'users',
      //),
    //),
    
    'name' => array(
      'type' => 'varchar',
      'length' => 255,
    ),
  ),
);
