<?php
/**
 * Copyright (c) 2020. Eremin
 * 02.03.20 16:41
 *
 */

/*
 * Отправка сообщения пользователю
 * входные параметры:
 *   from - имя отправителя
 *   to   - имя получателя
 *   msg  - текст сообщения (зашифрованный)
 *
 * Ответ:
 * {
 *   "metka":"cerera#send",
 *   "array":["true/false"]
 * }
 *
 */
require_once "common.php";

$from = s2s($_REQUEST['from']);        // имя отправителя
$to   = s2s($_REQUEST['to']);        // имя получателя
$msg  = s2s($_REQUEST['msg']);  // сообщение
$otv[0] = 'false';
$n1 = getVal("SELECT count(*) FROM users WHERE usr='$from'");
$n2 = getVal("SELECT count(*) FROM users WHERE usr='$to'");
if($n1==1 && $n2==1 && strlen($msg)>0) {
  $sql = "INSERT INTO mess (ufrom,uto,msg) VALUES (?,?,?)";
  $stmt = prepareSql($sql);
  $stmt->bind_param('sss', $from, $to, $msg);
  if($stmt->execute()) {
    // отметим время последнего обращения пользователя "from"
    execSQL("UPDATE users SET last=NOW() WHERE usr='$from'");
    $otv[0] = 'true';
  }
}
$txt = Otvet(__FILE__, $otv);
echo $txt;

