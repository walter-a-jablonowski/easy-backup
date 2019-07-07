<?php

/*-

  for sort use a sort func

-*/
function scan_all_fils( $dir)
{ 
  $dir  = rtrim( $dir, '/' );  // unify just for this func
  $base = scandir($dir);
  
  $r = [];
  foreach( $base as $f)
  { 
    if( $f === '.' || $f === '..')
      continue;
    
    elseif( is_file("$dir/$f"))
    {
      $r[] = "$dir/$f";
      continue;
    }
    
    $r = array_merge( $r, scan_all_fils( "$dir/$f"));
  } 

  return $r;
}

?>