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
 *
 * Ответ
 * {
 *   "metka":"cerera#registeruser",
 *   "array":["true/false"]
 * }
 *
 */
require_once "common.php";

$usr = s2s($_REQUEST['usr']);        // имя пользователя
$pubkey = s2s($_REQUEST['pubkey']);  // публичный ключ
$otv[0] = 'false';
if(strlen($usr) > 0) {
  $sql = "select count(*) from users where usr='$usr'";
  $num = intval(getVal($sql));
  if ($num < 1) {
    $sql = "INSERT INTO users (usr,pubkey) VALUES ('$usr', '$pubkey')";
    $a = execSQL($sql);
    if ($a)
      $otv[0] = 'true';
  }
}
$txt = Otvet(__FILE__, $otv);
echo $txt;
