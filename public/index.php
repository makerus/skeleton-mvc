<?php

/*
 * Инициализация приложения
 */

define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/vendor/autoload.php';
require_once APP_ROOT . '/app/configs/paths.php';
require_once APP_ROOT . '/system/autoload.php';
require_once APP_ROOT . '/app/configs/route.php';
require_once CONFIG_DIR . '/database.php';

use system\core\Route;
use system\core\View;
use system\core\Database;

View::initViewEngine();
Database::initializeDatabase();
Route::match($_SERVER['QUERY_STRING'], $_SERVER['REQUEST_METHOD']);