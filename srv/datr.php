<?php
/**
 * Copyright (c) 2020. Eremin
 * 24.03.20 21:27
 *
 */

/*
 * Узнать дату(время) чтения сообщения
 * входные параметры:
 *  im  - номер сообщения
 *  pwd - пароль пользователя-отправителя
 *
 * Ответ А:
 * {
 *   "data": ["дата_чтения"]
 *   "result": true|false
 * }
 *
 */

require_once "../common.php";

if(array_key_exists("im", $_REQUEST)) {
  $im = intval($_REQUEST["im"]);
} else {
  $im = 0;
}
$pwd = s2s($_REQUEST['pwd']);   // пароль получателя
$a = array();
// задан номер сообщения "im"
// прочитаем сообщение и узнаем от кого.
list($f,$d) = getVals("SELECT ufrom,wdat FROM mess WHERE im=$im");
// проверить пароль пользователя
$nn = getVal("SELECT count(*) FROM users WHERE usr='$f' AND pwd='$pwd'");
if (intval($nn) > 0) {
  // пароль верный, заполним данные сообщения
  $a[0] = $d; // дата чтения сообщения
  $result = true;
} else {
  // неправильный пользователь
  sleep(4); // в случае ошибки задержимся
  $result = false;
}
// формируем объект-ответ
$txt = Otvet($result, $a);
echo $txt;
