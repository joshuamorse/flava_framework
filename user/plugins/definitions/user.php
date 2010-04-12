<?php

$_definition = array(
 'name' => 'user',
  'engine' => 'MyISAM',
  'primary' => 'id',

  'fields' => array(
    'id' => array(
      'field' => 'id',
      'type' => 'int',
      'auto_inc' => 1,
    ),

    'clan' => array(
      'field' => 'clan_id',
      'type' => 'int',

      'relation' => array(
        'type' => 'one-to-one',
        'foreign' => array(
          'table' => 'clan',
          'field' => 'id',
        ),
      ),
    ),

    'comments' => array(
      'relation' => array(
        'type' => 'one-to-many',
        'foreign' => array(
          'table' => 'comment', 
          'field' => 'id', 
        ),
      ),
    ),

    'songs' => array(
      'relation' => array(
        'type' => 'many-to-many',
        'foreign' => array(
          'table' => 'song', 
          'field' => 'song_id', 
          'joiner' => 'user2song', 
        ),
      ),
    ),
    
    'name' => array(
      'field' => 'name',
      'type' => 'varchar',
      'length' => 255,
    ),

    'location' => array(
      'field' => 'location',
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
