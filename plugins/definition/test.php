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
      'label' => 'Name',
      'type' => 'varchar',
      'length' => 255,
      'validation' => 'string',
    ),

    'location' => array(
      'label' => 'Location',
      'type' => 'varchar',
      'length' => 255,
      'validation' => 'string',
    ),

    'url' => array(
      'label' => 'Homepage',
      'type' => 'varchar',
      'length' => 255,
      'validation' => 'url',
    ),

    'bla' => array(
      'label' => 'Bla',
      'type' => 'varchar',
      'length' => 255,
      'validation' => 'phone',
    ),

  ),
);
