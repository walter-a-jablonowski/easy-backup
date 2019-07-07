<?php

/*-

  always typed

USAGE:

  function url_arg( $name, $default = null, $trim = ARG_NOTRIM)
  function cmd_arg( $name, $default = null, $trim = ARG_NOTRIM)  // php scrip.php arg1 arg2 arg3


  // Chain

  $conf = url_arg( 'spec_view', '');
  $conf = cmd_arg( 'spec_view', $conf);

  if( ! $conf) // default
    $conf = PRIMARY_CLOUD . 'v-app-data/backup/conf/conf.yml';


  // Check on forms

  $myarg = urlarg( 'mycheck', false);  TASK
  

RETURNS:

  In order of prio:
  
  - $default if val ! set
  
  - If $type flag ist true (default):
  
    - bool  if val is '' (= ?myarg), 'true', 'false', 'yes', 'no' or upper case variant
    - float if val is float
    - int   if val and int
  
  - or:
  
    - trimmed string if $trim flag (default)
    - string as given

DO:

  - Varaint form
  - int as str should be arg="5" in url
  - trim could be obsol (no valid), type?
  - If needed: nest array args

SIMILAR: array_val()
-*/

define('ARG_TRIM', true);
define('ARG_NOTRIM', false);

function url_arg( $name, $default = null, $trim = ARG_NOTRIM)
{
  return urlarg( $name, $default, true, $trim, $_REQUEST);
}

function cmd_arg( $name, $default = null, $trim = ARG_NOTRIM)
{
  if( ! isset($argv))  return $default;
  return urlarg( $name, $default, true, $trim, $argv);
}

function urlarg( $name, $default = '', $type = true, $trim = true, $use_args = [])
{
  if ( ! $use_args)  $use_args = $_REQUEST;  // Task: rm?

  if ( ! isset( $use_args[$name]))
    return $default;

  $v = $use_args[$name];
  if( is_array($v))  return $v;  // JSON via js

  $s = trim( $use_args[$name]);

  if ( $type && $s === '' || strtolower($s) === 'true' || strtolower($s) === 'yes')  // needed
    return true;
  elseif ( $type && strtolower($s) === 'false' || strtolower($s) === 'no')
    return false;
  elseif ( $type && is_numeric($v) && strpos($v, '.') !== false) 
    return floatval($v);            // PHP can handle a numeric string as num
  elseif ( $type && is_numeric($v)) // "10.0 pigs " + 1 = 11.0
    return intval($v);
  elseif( $trim )                   // is string
    return $s;
  else
    return $v;
}

?>