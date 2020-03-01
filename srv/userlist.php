<?php
/**
 * Copyright (c) 2020. Eremin
 * 01.03.20 16:07
 *
 */

/*
 * Вывод список пользователей
 * Массив в формате JSON
 */

require_once "common.php";

$cnt = 0;
$usrlist = array();
$sql = "select usr from users";
$res = queryDb($sql);
while(list($n1) = fetchRow($res)) {
  $usrlist[$cnt] = $n1;
  $cnt++;
}
// формируем объект-ответ
$obj = (object) [
  'metka' => 'cerera#userlist',
  'array' => $usrlist
];
$txt = json_encode($obj);
echo $txt;
