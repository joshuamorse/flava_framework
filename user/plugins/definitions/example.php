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

    'posse_id' => array(
      'type' => 'int',

      'relation' => array(
        'type' => 'one',
        'name' => 'posse',
      ),
    ),

    'profile_id' => array(
      'type' => 'int',

      'relation' => array(
        'type' => 'one',
        'name' => 'profile',
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

    'url' => array(
      'type' => 'varchar',
      'length' => 255,
    ),

    'bla' => array(
      'type' => 'varchar',
      'length' => 255,
    ),
  ),
);
