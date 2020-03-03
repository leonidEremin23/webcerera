<?php
/**
 * Copyright (c) 2020. Eremin
 * 03.03.20 15:11
 *
 */

/*
 * список сообщений для пользователя
 * входные параметры:
 *   from - от кого
 *   to   - кому
 *
 * Ответ:
 * {
 *   "metka":"cerera#list",
 *   "array":[номер_сообщения1, номер сообщения 2, ... номер сообщения N]
 * }
 *
 */
require_once "common.php";

$from = s2s($_REQUEST['from']);      // имя отправителя
$to   = s2s($_REQUEST['to']);        // имя получателя
$ufrom = '';
$uto   = '';
if(strlen($from) > 0) {
  $wfrom = "AND ufrom='$from'";
}
if(strlen($to) > 0) {
  $wto = "AND uto='$to'";
}
$list = array();
$sql = "SELECT im FROM mess WHERE (datr) is null $wfrom $wto ORDER BY im";
$res = queryDb($sql);
$cnt = 0;
while(list($im) = fetchRow($res)) {
  $list[$cnt] = intval($im);
  $cnt++;
}
// формируем объект-ответ
$txt = Otvet(__FILE__, $list);
echo $txt;
