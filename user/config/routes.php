<?php

$_routes = array(
  'default' => array(
    'url' => '/:module/:action',
  ),

  'user_index' => array(
    'url' => '/user/index/:id',
    'target' => array('module' => 'user', 'action' => 'index'),
  ),
);
