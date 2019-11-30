<?php
namespace Config;

use Core\Patterns\Singleton;
use Core\Patterns\PropertyContainer;

class Config {
    use Singleton;
    use PropertyContainer;
}

$config = Config::getInstance();
$config->set('DB_HOST', 'localhost');
$config->set('DB_NAME', 'vk_db');
$config->set('DB_USER', 'root');
$config->set('DB_PASSWORD', '');
$config->set('DOMAIN', 'localhost');
$config->set('SESSION_NAME', 'LOCALHOST_MY');
$config->set('CSRF_SECRETKEY', '54as5da4s5d4as5d4wq5d45a4sd5ad'); // ключ для формирования токена, служащего защитой от CSRF атаки

// токен доступа к Vk 
$config->set('VK_ACCESS_TOKEN', '');
// ID группы Vk 
$config->set('VK_GROUP_ID', '');
// VK API Version
$config->set('VK_API_VERSION', '5.95');