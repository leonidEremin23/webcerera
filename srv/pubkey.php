<?php
/**
 * Copyright (c) 2020. Eremin
 * 02.03.20 16:44
 *
 */

/*
 * получить публичный ключ пользователя
 *  входные параметры:
 *   usr - имя пользователя
 *
 * * Ответ:
 * {
 *   "metka":"cerera#pubkey",
 *   "array":["true/false", "<public key>"]
 * }
 *
 */

require_once "common.php";

$usr = s2s($_REQUEST['usr']);        // имя пользователя
$pubkey = s2s($_REQUEST['pubkey']);  // публичный ключ
$otv[0] = 'false';
$otv[1] = '';
if(strlen($usr) > 0) {
  $sql = "select pubkey from users where usr='$usr'";
  $pubkey = getVal($sql);
  if (strlen($pubkey) > 2) {
    $otv[0] = "true";
    $otv[1] = $pubkey;
  }
}
$txt = Otvet(__FILE__, $otv);
echo $txt;
