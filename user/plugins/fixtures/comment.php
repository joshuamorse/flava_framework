<?php

$_user = get_fixtures('user');

$_fixtures = array(
  array(
    'comment' => 'this is comment 1',
    'slug' => 'comment1',
    'user_id' => get_fixture_id('user1', $_user),
  ), 

  array(
    'comment' => 'this is comment 1',
    'slug' => 'comment2',
    'user_id' => get_fixture_id('user2', $_user),
  ),

  array(
    'comment' => 'this is comment 3',
    'slug' => 'comment3',
    'user_id' => get_fixture_id('user1', $_user),
  ), 
);
