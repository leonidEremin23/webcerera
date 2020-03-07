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
 *   pwd  - пароль отправителя
 *   to   - имя получателя
 *   msg  - текст сообщения (зашифрованный)
 *
 * Ответ:
 * {
 *   "data": [],
 *   "result": true/false
 * }
 *
 */
require_once "../common.php";

$from = s2s($_REQUEST['from']);   // имя отправителя
$pwd  = s2s($_REQUEST['pwd']);    // пароль отправителя
$to   = s2s($_REQUEST['to']);     // имя получателя
$msg  = s2s($_REQUEST['msg']);    // сообщение
$result = false;
$n1 = getVal("SELECT count(*) FROM users WHERE usr='$from' AND pwd='$pwd'");
$n2 = getVal("SELECT count(*) FROM users WHERE usr='$to'");
if(intval($n1)==1 && intval($n2)==1 && strlen($msg)>0) {
  $sql = "INSERT INTO mess (ufrom,uto,msg) VALUES (?,?,?)";
  $stmt = prepareSql($sql);
  $stmt->bind_param('sss', $from, $to, $msg);
  if($stmt->execute()) {
    // отметим время последнего обращения пользователя "from"
    execSQL("UPDATE users SET last=NOW() WHERE usr='$from'");
    $result = true;
  }
}
$txt = Otvet($result);
echo $txt;
