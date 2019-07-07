<?php

/*-

see readme

DEBUG:

  ?PRIMARY_CLOUD.'v-app-data/backup/conf/conf.yml'
  PRIMARY_CLOUD.%27v-app-data%2Fbackup%2Fconf%2Fconf.yml%27

-*/

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

use WAJ\Lib\BasicClasses\Args\Arg;

require 'vendor/autoload.php';
require 'config.php';


/*--------------------------------------------------------
| Init
--------------------------------------------------------*/

// define( 'DBG', 'DBG' );

if( defined('DBG'))
  require_once 'kint.phar';

$conf = Arg::defaultVal( 'BACKUP_CONF' )
          ->URLArg('conf')->cmdArg('conf')->trim()->val();

eval( "\$conf = $conf;");  // cause use of PHP defines in arg is possible


$backup_sub = date('Y-m-d_H-i-s');


/*--------------------------------------------------------
| Source
--------------------------------------------------------*/

$def = Yaml::parse( file_get_contents( $conf ));

if( ! $def['Running'] )  exit();

eval( '$backup_fld = ' . $def['Backup fld'] . ';');  // cause you can use defines in conf: MY_DEFINE . 'myfld/'


$a = []; $debug = [];
foreach( $def['Source flds'] as $base )
{
  eval( "\$base = $base;");  // also use of PHP defines
  // $fils = all_fils( $base);
  $fils = scan_all_fils( $base);
  
  foreach( $fils as $f)
  {
    
    // General rules
  
    foreach( $def['General rules']['Skip'] as $s)
      if( strpos( $f, $s) !== false)
        continue;
  
    // Rules from name
  
    $a = [];
    preg_match_all(
      '/' . '(\\' . $def['Do backup'] . ')|(\\' . $def['No backup'] . ')' . '/',
      $f, $a
    );

    if( $a[0] && $a[0][ count($a[0]) - 1 ] == $def['Do backup'])  // last rule is do backup
    {
      $one = 1; // str_rpl needs this
      if( ! defined('DBG'))
  
        backup_single_named([
          
          'base'        => $base,
          'source'      => str_replace( $base, '', $f, $one),
          'backup_base' => $backup_fld,
          'backup_fld'  => $backup_sub,
          'app_name'    => 'backup'
        ]);
  
      else  $debug[] = str_replace( $base, '', $f, $one);
    }
  }
}

if( defined('DBG'))  !d( $debug);

?>