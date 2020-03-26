<?php
/**
 * Copyright (c) 2020. Eremin
 * 03.03.20 15:11
 *
 */

/*
 * список сообщений(непрочитанных) для пользователя-получателя
 * входные параметры:
 *   from - от кого (отправитель)
 *   to   - кому (получатель)
 *   pwd  - пароль получателя, если получатель не задан, то отправителя
 *
 * В случае ошибки пароля - задержка ответа на несколько секунд
 *
 * Ответ:
 * {
 *   "data":
 *    ["номер1", "отправитель", "получатель", "дата1"],
 *    ["номер2", "отправитель", "получатель", "дата2"],
 *    ["номер3", "отправитель", "получатель", "дата3"],
 *   "result": true|false
 * }
 *
 */
require_once "../common.php";

if(array_key_exists('from',$_REQUEST)) {
  $from = s2s($_REQUEST['from']);   // имя отправителя
} else {
  $from = '';
}
if(array_key_exists('to',$_REQUEST)) {
  $to = s2s($_REQUEST['to']);       // имя получателя
} else {
  $to = '';
}
$pwd = s2s($_REQUEST['pwd']);       // пароль получателя
//
$list = array();
// проверить пароль пользователя, если получатель не задан,
// то проверим пароль отправителя
$u = $to;
if(strlen($u) < 1)
  $u = $from;
$nn = getVal("SELECT COUNT(*) FROM users WHERE usr='$u' AND pwd='$pwd'");
$otv = (intval($nn) > 0);
if($otv) {
  // пароль соответствует, будем извлекать список
  $wfrom = '';
  if (strlen($from) > 0)
    $wfrom = "AND ufrom='$from'";
  $wto = '';
  if (strlen($to) > 0)
    $wto = "AND uto='$to'";
  // выборка списка сообщений для получателя
  $sql = "SELECT im,ufrom,uto,wdat FROM mess WHERE (datr) is null $wfrom $wto ORDER BY im";
  $res = queryDb($sql);
  $cnt = 0;
  while ($ro = fetchRow($res)) {
    $list[$cnt] = $ro;
    $cnt++;
  }
} else {
  sleep(ERROR_AUTH_SLEEP); // в случае ошибки задержимся
}
// формируем объект-ответ
$txt = Otvet($otv, $list);
echo $txt;
