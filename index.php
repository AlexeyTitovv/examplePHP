<?php

//$string= '21-11-2015';

//$pattern = '/([0-9]+)-([0-9]+)-([0-9]+)/';

//$replacement = 'Month: $2, Day: $1, Year: $3';

//echo preg_replace($pattern, $replacement, $string);


//FRONT CONTROLLER
//включаем сессии
session_start();

//1. Общие настройки
ini_set("display errors", 1);
error_reporting(E_ALL);
        
//2. Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once (ROOT. '\components\Autoload.php');



//3. Установка Соединения с БД
//4. Вызов Router
$router = new Router();
$router->run();

