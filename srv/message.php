<?php
/**
 * Copyright (c) 2020. Eremin
 * 03.03.20 15:20
 *
 */

/*
 * выдать сообщение и сделать отметку о прочтении
 * входные параметры:
 *   im - индекс сообщения
 *
 * Ответ:
 * {
 *   "data":[от_кого, кому, сообщение, дата_сообщения]
 *   "result": true/false
 * }
 *
 */
require_once "common.php";

$im = intval($_REQUEST['im']);        // номер сообщения
$a = array();
list($f,$t,$m,$w) = getVals("SELECT ufrom,uto,msg,wdat FROM mess WHERE im=$im");
$a[0] = $f;
$a[1] = $t;
$a[2] = $m;
$a[3] = $w;
// отметим, что прочитали сообщение
execSQL("UPDATE mess SET datr=NOW() WHERE im=$im");
// формируем объект-ответ
$txt = Otvet(!empty($f), $a);
echo $txt;
