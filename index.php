<?php

require('config.php');
require('config/routes.php');
require('config/app.php');
require('config/user.php');

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
  # Let's set our $_target var here.
  $_target = $_dir['module'];

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
    $_target .= '/' . $_action;
  }
  else
  {
    $_target .= '/' . $_route['target']['action'];
  }

  # Fetch the logic.
  include($_target . '/logic.php');

  # Init the content var.
  $content = '';

  # Unset the $_action var, as the action will now use it.
  unset($_action);

  # Fetch the view.
  ob_start();
    include($_target.'/view.php');
  $_content .= ob_get_clean();

  # If a template was specificied, we'll include that, otherwise, we'll just render the content.
  if(isset($_action['template']))
  {
    log_me('The following template was specified in the action -- '.$_action['template']);

    require('template/'.$_action['template'].'.php');
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

pre($_log);
