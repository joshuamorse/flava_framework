<?php

require('lib/system.config.php');
require('lib/system.functions.php');
require('user/plugins/functions/base/user.php');

db_connect();
use_db();

$user = new user_base(1);

echo $user->get_name();

$clan = $user->get_clan();
print_r($clan);
//echo $song->get_album()."\n\n";
