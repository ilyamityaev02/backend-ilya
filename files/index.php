<?php

// Отправляем правильную кодировку.
header('HTTP/1.1 404 Not Found');
header('Content-Type: text/html; charset=UTF-8');

// Выводим все полученные через POST параметры.
// если запрос 2-5) сделан правильно, то можно будет увидеть
// отправленный комментарий в ответе веб-сервера.
print_r($_POST);

$xml = file_get_contents('php://input');

print('Привет, мир!');

if (isset($v1)) {
  $v1++;
}
else {
  $v1 = 1;
}

print($v1);

include('form.php');
