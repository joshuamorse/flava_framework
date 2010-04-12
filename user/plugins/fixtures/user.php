<?php

$_clan = get_fixtures('clan');

$_fixtures = array(
  array(
    'name' => 'user1',
    'slug' => 'user1',
    'location' => 'nashville',
    'clan_id' => get_fixture_id('clan1', $_clan),
  ),

  array(
    'name' => 'user2',
    'slug' => 'user2',
    'location' => 'cleveland',
    'clan_id' => get_fixture_id('clan2', $_clan),
  ),
);
