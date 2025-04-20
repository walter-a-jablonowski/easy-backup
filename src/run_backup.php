<?php

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

require 'vendor/autoload.php';


$config = Yaml::parse( file_get_contents('config.yml'));

if( ! $config['running'] )  exit();

$a = []; $debug = [];

foreach( $config['sourceFlds'] as $base )
{
  $fils = scan_all_fils( $base );
  
  foreach( $fils as $f )
  {
    // General rules
  
    foreach( $config['skip'] as $s )
      if( strpos( $f, $s) !== false)
        continue;
  
    // Rules from name
  
    $a = [];
    preg_match_all(
      '/' . '(\\' . $config['doBackup'] . ')|(\\' . $config['noBackup'] . ')' . '/',
      $f, $a
    );

    if( $a[0] && $a[0][ count($a[0]) - 1 ] == $config['doBackup'])  // last rule is do backup
    {
      $one = 1;  // str_rpl needs this
  
      backup_single_named([
        
        'base'        => $base,
        'source'      => str_replace( $base, '', $f, $one),
        'backup_base' => $config['backupFld'],
        'backup_fld'  => date('Y-m-d_H-i-s'),
        'app_name'    => 'backup'
      ]);
    }
  }
}

?>
