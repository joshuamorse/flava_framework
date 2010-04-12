<?php

$_definition = array(
 'name' => 'song',
  'engine' => 'MyISAM',
  'primary' => 'id',

  'fields' => array(
    'id' => array(
      'type' => 'int',
      'auto_inc' => 1,
    ),
    
    'song' => array(
      'type' => 'varchar',
      'length' => 255,
    ),
  ),
);

