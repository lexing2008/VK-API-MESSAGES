<?php
// устраняем проблему с кодировкой
header('Content-type: text/html; charset=utf-8');

use App\App;

require_once 'vendor/autoload.php';

$app = App::getInstance();
$app->run();



