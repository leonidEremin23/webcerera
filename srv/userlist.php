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
/*
  * Ответ:
  * {
  *   "data": ["пользователь1", "пользователь2", "пользовательN",],
  *   "result": true/false
  * }
*/

require_once "common.php";

$cnt = 0;
$usrlist = array();
$sql = "select usr from users order by usr";
$res = queryDb($sql);
while(list($n1) = fetchRow($res)) {
  $usrlist[$cnt] = $n1;
  $cnt++;
}
// формируем объект-ответ
$txt = Otvet(true, $usrlist);
echo $txt;
