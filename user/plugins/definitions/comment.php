<?php

$_definition = array(
 'name' => 'comment',
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
    
    'comment' => array(
      'type' => 'varchar',
      'length' => 255,
    ),
  ),
);
