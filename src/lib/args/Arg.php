<?php

namespace WAJ\Lib\BasicClasses\Args;

require_once( str_replace('//', '/', dirname(__FILE__)) . '/args_func.php');


/*-

USAGE:

  $arg = Arg::defaultVal('')->URLArg('name')
                            ->cmdArg('name')->trim()->val();

  $arg = Arg::required()->strURLArg('name')->trim()->val(); // throws if mising

DEV:

  - currently no valid of args
  
    ->verify('string')->val();
    ->verify('int', '> 1', '<= 5')->val();
    ->verify('int', func() {
    
    })->val();

-*/

class Arg  /*@*/
{
  private $v;
  private $required;
  private $default;


  public static function required()
  {
    return new self( true, null);
  }

  public static function defaultVal( $default)
  {
    return new self( false, $default);
  }
  

  private function __construct( $required, $default)
  {
    $this->required = $required;
    $this->default = $default;
    return $this;
  }


  public function URLArg( $name)
  {
    $this->v = url_arg( $name, $this->v);
    return $this;
  }

  public function cmdArg( $name)
  {
    $this->v = cmd_arg( $name, $this->v);
    return $this;
  }


  public function trim()
  {
    if( is_string( $this->v))  $this->v = trim($this->v);
    return $this;
  }


  public function val()
  {
    if( $this->required && ! $this->v)
      throw new Exception('Required arg empty');

    elseif( ! $this->required && $this->default)
      $this->v = $this->default;

    return $this->v;
  }
}

?>