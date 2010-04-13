<?php

require('lib/system.config.php');
require('lib/system.functions.php');
require('user/plugins/functions/base/user.php');

db_connect();
use_db();

$user = new user_base(1);

//echo $user->get_name();

//echo "\n\n";
//echo $user->get_clan()->name;
//echo "\n\n";

echo "\n\n";
$comments = $user->get_comments();
echo $comments[1]->comment;
echo "\n\n";
//print_r($clan);
//echo $clan->name;
