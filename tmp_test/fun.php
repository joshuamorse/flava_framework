<?php

require('lib/system.config.php');
require('lib/system.functions.php');
require('tmp_test/test.php');

db_connect();
use_db();

$song = new song_base(23);

$album = $song->get_album();
print_r($album);
//echo $song->get_album()."\n\n";
