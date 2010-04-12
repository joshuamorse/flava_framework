<?php

$_definition = array(
 'name' => 'clan',
  'engine' => 'MyISAM',
  'primary' => 'id',

  'fields' => array(
    'id' => array(
      'field' => 'id',
      'type' => 'int',
      'auto_inc' => 1,
    ),

    'name' => array(
      'field' => 'name',
      'type' => 'varchar',
      'length' => 255,
    ),
  ),
);
