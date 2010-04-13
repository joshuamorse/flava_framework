<?php

$_definition = array(
 'name' => 'comment',
  'engine' => 'MyISAM',
  'primary' => 'id',

  'fields' => array(
    'id' => array(
      'field' => 'id',
      'type' => 'int',
      'auto_inc' => 1,
    ),

    'user' => array(
      'field' => 'user_id',
      'type' => 'int',

      'relation' => array(
        'type' => 'one-to-one',
        'foreign' => array(
          'table' => 'user',
          'field' => 'id',
        ),
      ),
    ),
    
    'comment' => array(
      'field' => 'comment',
      'type' => 'varchar',
      'length' => 255,
    ),

    'slug' => array(
      'field' => 'slug',
      'type' => 'varchar',
      'length' => 255,
    ),
  ),
);
