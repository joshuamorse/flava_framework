<?php

$_definition = array(
 'name' => 'song',
  'engine' => 'MyISAM',
  'primary' => 'id',

  'fields' => array(
    'id' => array(
      'field' => 'id',
      'type' => 'int',
      'auto_inc' => 1,
    ),
    
    'song' => array(
      'field' => 'song',
      'type' => 'varchar',
      'length' => 255,
    ),
  ),
);

