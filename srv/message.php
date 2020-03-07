<?php
/**
 * Copyright (c) 2020. Eremin
 * 03.03.20 15:20
 *
 */

/*
 * выдать сообщение и сделать отметку о прочтении
 * входные параметры:
 *   im  - индекс сообщения
 *   pwd - пароль пользователя-получателя
 *
 * Ответ:
 * {
 *   "data":[от_кого, кому, сообщение, дата_сообщения]
 *   "result": true/false
 * }
 *
 */
require_once "../common.php";

$im = intval($_REQUEST['im']);  // номер сообщения
$pwd = s2s($_REQUEST['pwd']);   // пароль получателя
$a = array();
list($f,$t,$m,$w) = getVals("SELECT ufrom,uto,msg,wdat FROM mess WHERE im=$im");
// проверить пароль пользователя
$nn = getVal("SELECT count(*) FROM users WHERE usr='$t' AND pwd='$pwd'");
if(intval($nn) > 0) {
  // пароль верный
  // заполним данные сообщения
  $a[0] = $f; // от кого
  $a[1] = $t; // кому сообщение
  $a[2] = $m; // сообщение
  $a[3] = $w; // дата сообщения
  $result = true;
  // отметим, что прочитали сообщение
  execSQL("UPDATE mess SET datr=NOW() WHERE im=$im");
} else {
  // неправильный пользователь
  $result = false;
}
// формируем объект-ответ
$txt = Otvet($result, $a);
echo $txt;
