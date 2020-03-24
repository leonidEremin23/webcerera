<?php
/**
 * Copyright (c) 2020. Eremin
 * 24.03.20 21:27
 *
 */

/*
 * Узнать дату(время) чтения сообщения
 * входные параметры:
 *   im  - индекс сообщения
 *   pwd - пароль пользователя-отправителя
 *
 *  Ответ:
 * {
 *   "data":[дата_чтения]
 *   "result": true|false
 * }
 *
 */

require_once "../common.php";

$im = intval($_REQUEST['im']);  // номер сообщения
$pwd = s2s($_REQUEST['pwd']);   // пароль получателя
$a = array();
// прочитаем сообщение и узнаем от кого.
list($f,$d) = getVals("SELECT ufrom,datr FROM mess WHERE im=$im");
// проверить пароль пользователя
$nn = getVal("SELECT count(*) FROM users WHERE usr='$f' AND pwd='$pwd'");
if(intval($nn) > 0) {
  // пароль верный, заполним данные сообщения
  $a[0] = $d; // дата чтения сообщения
  $result = true;
} else {
  sleep(4); // в случае ошибки задержимся
  // неправильный пользователь
  $result = false;
}
// формируем объект-ответ
$txt = Otvet($result, $a);
echo $txt;
