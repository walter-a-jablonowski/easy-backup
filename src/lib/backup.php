<?php

/*-

  Backup single fil in backup fld

    BACKUP_BASE/BACKUP_BASE/Sub/Fil
      
    where
      
      BACKUP_FLD: use YY-MM-DD pr similar

  - also makes backup_fld if missing

USAGE:

  backup_single()
  backup_single_named():  named args


ARGS:

  base:         dont add in backup_fld (gd)
  source:       sub fld, will be added in backup_fld
  backup_base:  
  backup_fld:   yy-mm-dd sub fld
  app_name:     added in fil

-*/

function backup_single_named( $args)
{
  backup_single( $args['base'], $args['source'], $args['backup_base'], $args['backup_fld'], $args['app_name']);
}


function backup_single( $base, $source, $backup_base, $backup_fld, $app_name = '')  /*@*/
{
  // if( strrpos($backup_fld, '/') === strlen($backup_fld) - 1)  // no slash
  //   $backup_base = substr( $backup_base, 0 , strlen($backup_base) - 1);
  $backup_fld = rtrim( $backup_fld, '/' );

  if( $app_name)  $backup_fld .= "-$app_name";  // backup_fld add app
  $backup_fld .= '/';

  $dir = pathinfo($source)['dirname'] . '/';

  if( ! file_exists( $backup_base . $backup_fld . $dir))
    if( ! mkdir( $backup_base . $backup_fld . $dir, 0777, true))  // make all sub dir
      print "<b>Error:</b> backup_single() error making dir $backup_base$backup_fld$dir";

  copy( $base . $source, $backup_base . $backup_fld . $dir . basename($source));
}

?>