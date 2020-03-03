<?php
/**
 * Copyright (c) 2020. Eremin
 * 03.03.20 16:34
 *
 */

/*
 * Выводит список сообщений

 */

require_once "srv/common.php";

echo <<<_EOF

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Обмен сообщениями</title>
 <link rel="stylesheet" type="text/css" href="css/style.css">
 <meta http-equiv="Refresh" content="5" />
</head>
<body>

_EOF;

echo "<table class='spis'>";
$sql = "SELECT ufrom, uto, wdat FROM mess ORDER BY wdat DESC ";
$rst = queryDb($sql);
while(list($ufrom, $uto, $wdat) = fetchRow($rst)) {
  echo "<tr>";
  echo "<td class='spis'>$ufrom</td>";
  echo "<td class='spis'>$uto</td>";
  echo "<td class='spis'>$wdat</td>";
  echo "</tr>\n";
}

echo "</table>\n";
echo "</body>\n";
echo "</html>\n";
