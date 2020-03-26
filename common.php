<?php
/**
 * (C) 2020. Eremin
 * 01.03.2020

 */
/*
 * Библиотека общих функций.
 */
require_once "MyDB.php";
// объект базы данных
$My_Db = new MyDB() ;
// запуск сессии
//session_start();

// пауза при ошибке идентификации
define('ERROR_AUTH_SLEEP', 4);

/**
 * Преобразование даты из формата SQL в строку русского формата DD.MM.YYYY
 * @param string $dat строка в формате SQL YYYY-MM-DD
 * @return string дата DD.MM.YYYY
 */
function  dat2str($dat)
{
  $str = null;
  if(preg_match("/(\d{4})-(\d{1,2})-(\d{1,2}).*/",$dat, $mah)) {
    $y = $mah[1];  $m = $mah[2];  $d = $mah[3];
    $str = sprintf("%02d.%02d.%04d", $d,$m,$y);
  }
  return $str;
}

/**
 * Преобразование строки русского формата DD.MM.[YY]YY в дату формата SQL YYYY-MM-DD
 * @param string $str строка в формате DD.MM.[YY]YY (вместо точки может быть запятая)
 * @return string дата  YYYY-MM-DD
 */
function  str2dat($str)
{
  $dat = null;
  $d = 0; $y = '00';
  if (preg_match("/(\d{1,2})[\.,](\d{1,2})[\.,](\d{2,4}).*/", $str, $match)) {
    $d = $match[1];
    $m = $match[2];
    $y = $match[3];
  } else if (preg_match("/(\d{2,4})[\.,-](\d{1,2})[\.,-](\d{1,2}).*/", $str, $match)) {
    $d = $match[3];
    $m = $match[2];
    $y = $match[1];
  }
  if ($d > 0) {
    if ($y < 100) {
      $y = '20' . $y;
    }
    $dat = sprintf("%04d-%02d-%02d", $y, $m, $d);
  }
  return $dat;
}

/**
 * Проверяет корректность строки даты с заданным форматом
 * http://php.net/manual/ru/function.checkdate.php
 * http://php.net/manual/ru/datetime.createfromformat.php
 * @param string $dat     строка даты
 * @param string $format  формат строки даты
 * @return bool true - дата корректна, false - неправильная дата
 */
function validateDate($dat, $format = 'Y-m-d')
{
  $d = DateTime::createFromFormat($format, $dat);
  return ($d) && ($d->format($format) == $dat);
}

/**
 * Переход в указанное место URL
 * @param string $url  URL перехода
 */
function  gotoLocation($url)
{
  header("HTTP/1.1 301 Moved Permanently");
  header("Location: " . $url);
}

/**
 * Возвращает первое поле в первой строке, заданного SQL-запроса
 * @param string $sql SQL запрос
 * @return null значение поля
 */
function  getVal($sql)
{
  $val = null;
  $res = queryDb($sql);
  if ($row = fetchRow($res)) $val = $row[0];
  $res->close();
  return $val;
}

/**
 * Возвращает массив значений первой строки заданного SQL-запроса
 * @param string $sql запрос
 * @return null array цифровой массив значений
 */
function  getVals($sql)
{
  $res = queryDb($sql);
  $row = fetchRow($res);
  $res->close();
  return $row;
}

/**
 * Простая обертка для функции выполнения запроса
 * @param string $sql   строка запроса
 * @return bool|mysqli_result результат запроса
 */
function  queryDb($sql)
{
  global $My_Db;
  return $My_Db->query($sql);
}

/**
 * Простая обертка для функции загрузки числового массива полей строки запроса
 * @param mysqli_result $res    результат query
 * @return mixed    числовой массив результата
 */
function   fetchRow($res)
{
  return $res->fetch_row();
}

/**
 * Простая обертка для функции загрузки ассоциативного массива полей строки запроса
 * @param mysqli_result $res     результат query
 * @return mixed    ассоциативный массив результата
 */
function   fetchAssoc($res)
{
  return $res->fetch_assoc();
}

/**
 * Простая обертка для функции загрузки числового и ассоциативного массива полей строки запроса
 * @param mysqli_result $res  результат query
 * @return mixed  числовой и ассоцитивный массив строки
 */
function  fetchArray($res)
{
  return $res->fetch_array();
}

/**
 * Выполнить SQL-запрос
 * @param string $sql  SQL-запрос
 * @return boolean|mixed результат выполнения оператора типа INSERT, DELETE, UPDATE
 */
function  execSQL($sql)
{
  global $My_Db;
  $r = $My_Db->query($sql);
  return $r;
}

/**
 * Подготавливает оператор для выполнения подстановок в SQL запросе
 * @param string $sql  строка SQL запроса
 * @return mysqli_stmt подготовленный оператор
 */
function  prepareSql($sql)
{
  global $My_Db;
  return $My_Db->prepare($sql);
}

/**
 * Преобразовывает символы кавычек и других символов входной строки в безопасные символы
 * @param string $str входная строка
 * @return string строка без кавычек
 */
function  s2s($str)
{
  return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * Вернуть значение парметра из параметра формы или сессионной переменной
 * и задать этот параметр в сессию, а если параметр формы не задан, то прочитать
 * этот парметр из сессии.
 * @param string $namePar  имя параметра
 * @return mixed
 */
function getParSes($namePar)
{
  $par = null;
  if(array_key_exists($namePar, $_REQUEST)) {
    // вызвали форму
    $par = $_REQUEST[$namePar];
    $_SESSION[$namePar] = $par;
  } else {
    // форму не вызывали, проверим сессионную переменную
    if(array_key_exists($namePar, $_SESSION))
      $par = $_SESSION[$namePar];
  }
  return $par;
}

/**
 * формирование ответа
 * @param $result   - результат true - выполнено, false - ошибка
 * @param $arrout   - массив ответа
 * @return false|string
 */
function Otvet($result, $arrout = null)
{
  // $metka = 'cerera#' . basename($filename, '.php');
// формируем объект-ответ
  if($arrout == null)
    $arrout = array();
  $obj = (object) [
    'data'   => $arrout,
    'result' => $result
  ];
  $txt = json_encode($obj);
  return $txt;
}
