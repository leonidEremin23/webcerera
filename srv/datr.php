<?php
/**
 * Copyright (c) 2020. Eremin
 * 24.03.20 21:27
 *
 */

/*
 * Узнать дату(время) чтения нескольких сообщений по списку
 * входные параметры:
 *  ims - индексы сообщений (массив JSON) [N1,N2,...N3]
 *  pwd - пароль пользователя-отправителя
 *
 * {
 *   "data": [
 *             ["N1","дата_чтения"],
 *             ["N2","дата_чтения"],
 *             ["N3","дата_чтения"]
 *           ]
 *   "result": true|false
 * }
 *
 */

require_once "../common.php";

$ims = $_REQUEST['ims'];        // список номеров сообщений
$pwd = s2s($_REQUEST['pwd']);   // пароль получателя
$a = array();                   // массив ответа
try {
  // уберем все апострофы, кавычки и точки с запятой
  // из списка номеров сообщений
  $search = array("'",'"', ';');
  $str = str_replace($search,' ', $ims);
  $imsa = json_decode($str);  // сделаем из JSON массив чисел
  $stri = implode(',', $imsa);  // сделаем из массива список
  //
  // прочитаем сообщение и узнаем от кого
  list($f) = getVals("SELECT ufrom FROM mess WHERE im=" . intval($imsa[0]));
  // проверить пароль пользователя
  $nn = getVal("SELECT count(*) FROM users WHERE usr='$f' AND pwd='$pwd'");
  if(intval($nn) > 0) {
    // пароль верный, заполним данные сообщения
    $res = queryDb("SELECT im,datr FROM mess WHERE im IN ($stri)");
    $i = 0;
    while($r = fetchRow($res)) {
      $a[$i++] = $r;
    }
    $result = true;
  } else {
    $result = false;
  }
} catch (Exception $e) {
  $result = false;
}
if(!$result)
  sleep(ERROR_AUTH_SLEEP);
// формируем объект-ответ
$txt = Otvet($result, $a);
echo $txt;
