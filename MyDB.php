<?php
/**
 * (C) 2020. Eremin
 * 01.03.2020
 */
require_once ".mydb.php";
// файл .mydb.php:
//$cccmydb = array (
// 'db'   => 'имя_базы',
// 'host' => 'адрес_хоста',
// 'usr'  => 'пользователь',
// 'pwd'  => 'пароль'
//);

class MyDB
    extends mysqli
{
  function __construct()
  {
    global $cccmydb;
    $c = $cccmydb;

    parent::__construct($c['host'], $c['usr'], $c['pwd'], $c['db']);
    //@ $this->connect($c['host'], $c['usr'], $c['pwd'], $c['db']);
    if($this->connect_errno) {
      die("?-Error-Ошибка открытия БД");
    }
  }

  function __destruct()
  {
    $this -> close();
    //echo " destruct ";
  }
}
