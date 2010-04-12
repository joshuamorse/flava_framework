<?php

$_definition = array(
 'name' => 'user',
  'engine' => 'MyISAM',
  'primary' => 'id',

  'fields' => array(
    'id' => array(
      'type' => 'int',
      'auto_inc' => 1,
    ),

    'clan_id' => array(
      'type' => 'int',

      'relation' => array(
        'type' => 'one',
        'name' => 'clan',
      ),
    ),
    
    'name' => array(
      'type' => 'varchar',
      'length' => 255,
    ),

    'location' => array(
      'type' => 'varchar',
      'length' => 255,
    ),
  ),
);
