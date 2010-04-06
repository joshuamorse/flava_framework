<?php

function get_definition_for($def)
{
  require('user/plugins/definitions/'.$def.'.php');

  return $_definition;
}
