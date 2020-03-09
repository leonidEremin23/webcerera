<?php
/**
 * Copyright (c) 2020. Eremin
 * 03.03.20 15:11
 *
 */

/*
 * список сообщений для пользователя-получателя
 * входные параметры:
 *   from - от кого
 *   to   - кому (получатель)
 *   pwd  - пароль получателя
 *
 * Ответ:
 * {
 *   "data":
 *    ["номер1", "отправитель", "получатель", "дата1"],
 *    ["номер2", "отправитель", "получатель", "дата2"],
 *    ["номер3", "отправитель", "получатель", "дата3"],
 *   "result": true/false
 * }
 *
 */
require_once "../common.php";

$from = s2s($_REQUEST['from']);   // имя отправителя
$to   = s2s($_REQUEST['to']);     // имя получателя
$pwd  = s2s($_REQUEST['pwd']);    // пароль получателя
$ufrom = '';
$uto   = '';
$list = array();
// проверить пароль пользователя
$nn = getVal("SELECT count(*) FROM users WHERE usr='$to' AND pwd='$pwd'");
$otv = (intval($nn) > 0);
if($otv) {
  // пароль соответствует, будем извлекать список
  if (strlen($from) > 0) {
    $wfrom = "AND ufrom='$from'";
  }
  if (strlen($to) > 0) {
    $wto = "AND uto='$to'";
  }
  // выборка списка сообщений для получателя
  $sql = "SELECT im,ufrom,uto,wdat FROM mess WHERE (datr) is null $wfrom $wto ORDER BY im";
  $res = queryDb($sql);
  $cnt = 0;
  while ($ro = fetchRow($res)) {
    $list[$cnt] = $ro;  // intval($ro[0]);
    $cnt++;
  }
}
// формируем объект-ответ
$txt = Otvet($otv, $list);
echo $txt;
