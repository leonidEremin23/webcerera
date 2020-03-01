<?php
/**
 * Created by PhpStorm.
 * User: ae
 * Date: 01.03.2020
 * Time: 11:25
 */

/*
 * проверка соединения с БД
 */
require_once "common.php";

$cnt = 0;
$usrlist = array(0);
$sql = "select usr from users";
$res = queryDb($sql);
while(list($n1) = fetchRow($res)) {
  $usrlist[$cnt] = $n1;
  $cnt++;
}
