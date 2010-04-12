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
      'type' => 'int',

      'relation' => array(
        'type' => 'one-to-many',
        'foreign' => array(
          'table' => 'comment', 
          'field' => 'id', 
        ),
      ),
    ),

    //'song_id' => array(
      //'type' => 'int',

      //'relation' => array(
        //'type' => 'many-to-many',
        //'name' => 'songs',
        //'foreign' => array(
          //'table' => 'user2song', 
          //'field' => 'song_id', 
        //),
      //),
    //),
    
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
  ),
);
