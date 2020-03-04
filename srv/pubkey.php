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
 * Ответ:
 * {
 *   "data": ["<public key>"],
 *   "result": true/false
 * }
 *
 */

require_once "common.php";

$usr = s2s($_REQUEST['usr']);        // имя пользователя
$otv[0] = '';
$result = false;
if(strlen($usr) > 0) {
  $pubkey = getVal("SELECT pubkey FROM users WHERE usr='$usr'");
  if(strlen($pubkey) > 16) {
    $result = true;
    $otv[0] = $pubkey;
  }
}
$txt = Otvet($result, $otv);
echo $txt;
