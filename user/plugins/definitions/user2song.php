<?php

$_definition = array(
 'name' => 'user2song',
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
    ),

    'song' => array(
      'field' => 'song_id',
      'type' => 'int',
    ),
  ),
);

