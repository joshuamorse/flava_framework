<?php

require('lib/system.config.php');
require('lib/system.functions.php');
require('lib/plugins.functions.php');
require('user/config/routes.php');
require('user/config/app.php');
require('user/config/user.php');

# Define an array for controller's vars.
$_controller = array();

$_controller['current_url'] = curr_url();

$_url_match = 0;

# Check and see if we have a route match
foreach($_routes as $_route)
{
  $_controller['route_url'] = url_explode($_route['url']); 

  # Check for an array size match between the current url and the current stored url iteration.
  if(count($_controller['current_url']) == count($_controller['route_url']))
  {
    log_me("Looks like we've got a url count match on -- ".implode('/', $_controller['route_url']));

    $size = count($_controller['current_url']);

    # Compare the urls
    for($i = 0; $i < $size; ++$i)
    {
      # Let's catch the route wildcards
      if(is_route_wildcard($_controller['route_url'][$i]))
      {
        # We know we're dealing with a wildcard--let's find out if it's a module or action
        if($_controller['route_url'][$i] == ':module')
        {
          $_module = str_replace(':', '', $_controller['current_url'][$i]);
          log_me("The following module wildcard was found -- ".$_module);
        }

        if($_controller['route_url'][$i] == ':action')
        {
          $_action = str_replace(':', '', $_controller['current_url'][$i]);
          log_me("The following action wildcard was found -- ".$_action);
        }

        if($_module && $_action)
        {
          $_url_match = 1;
          log_me("Looks like we've got both a module and action wildcard; setting".' $_url_match to true');
        }

        # Make sure that the wildcards aren't matching on :module or :action, as these are reserved wildcards.
        if($_controller['route_url'][$i] != ':module' && $_controller['route_url'][$i] != ':action')
        {
          # If they aren't, add the wildcard to the request array (this will allow user's to set things like id, slug, etc).
          $_request[str_replace(':', '', $_controller['route_url'][$i])] = $_controller['current_url'][$i];
          log_me("The following wildcard was found -- ".$_controller['route_url'][$i]);
        }
      }
      else
      {
        # If the current url iteration doesn't match the route url iteration
        //echo($_controller['current_url'][$i] .'--'. $_controller['route_url'][$i].'<br/>');
        if($_controller['current_url'][$i] != $_controller['route_url'][$i])
        {
          # Set the flag
          $_url_match = 0; 
        }
        else
        {
          $_url_match = 1;
        }
      }
    }
  } 

  log_me('$_url_match is -- '.$_url_match);

  if($_url_match)
  {
    break;
  }
}

# If we have a route match, let's continue to render that route
if($_url_match)
{
  # Load up any installed plugin functions.
  $_list = get_autoload_list();

  foreach($_list as $_plugin)
  {
    require($_plugin['functions']);
  }

  # Let's set our $_target var here.
  $_target = DIR_MODS;

  # Define our module.
  if($_module)
  {
    $_target .= $_module;
  }
  else
  {
    $_target .= $_route['target']['module'];
  }

  # Define our action.
  if($_action)
  {
    $_target .= '/'.$_action;
  }
  else
  {
    $_target .= '/'.$_route['target']['action'];
  }

  # Fetch the logic.
  include($_target.'/logic.php');

  # Init the content var.
  $content = '';

  # Fetch the view.
  ob_start();
    include($_target.'/view.php');
  $_content .= ob_get_clean();

  # If a template was specificied, we'll include that, otherwise, we'll just render the content.
  if(isset($_action['template']))
  {
    require(DIR_TEMPLATES.$_action['template'].'.php');
  }
  else
  {
    echo $_content;
  }
}
else
{
  # Otherwise, let's 404 it.
  fwd_404();
}

//pre($_log);
