<?php
/**
 * Copyright (c) 2020. Eremin
 * 02.03.20 14:37
 *
 */

/*
 * Регистрация нового пользователя
 * входные параметры:
 *   usr    - имя пользователя
 *   pubkey - строка публичного ключа
 *   pwd    - пароль пользователя
 *
 * Ответ
 * {
 *   "data": [],
 *   "result": true/false
 * }
 *
 */
require_once "../common.php";

$usr = s2s($_REQUEST['usr']);         // имя пользователя
$pubkey = s2s($_REQUEST['pubkey']);   // публичный ключ
$pwd    = s2s($_REQUEST['pwd']);      // пароль пользователя
$result = false;
if(strlen($usr) > 0 && strlen($pubkey) > 16) {
  $sql = "select count(*) from users where usr='$usr'";
  $num = intval(getVal($sql));
  if ($num < 1) {
    $sql = "INSERT INTO users (usr,pubkey,pwd) VALUES ('$usr', '$pubkey','$pwd')";
    $a = execSQL($sql);
    if ($a)
      $result = true;
  }
}
$txt = Otvet($result);
echo $txt;
