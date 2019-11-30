<?php
namespace App;

use DB\DB;
use Config\Config;
use Core\Patterns\Singleton;

/**
 * Класс приложения MVC
 */
class App{
    use Singleton;
    /**
     * Инициализация приложения
     */
    public function run(){
        $config = Config::getInstance();
        // запускаем сессию
        session_name( $config->get('SESSION_NAME') );
        session_set_cookie_params (1400 , '/' , '.' . $config->get('DOMAIN') );
        session_start();
        
        // подключаемся к БД
        $db = DB::getInstance();
        $db->connect();
        
        if( empty($_GET) ){
            // устанавливаем конктроллер по умолчанию
            $controller_name = 'site';
            $action = 'index';
        } else {
            $controller_name = $_GET['controller'];
            $action = $_GET['action'];
        }
        
        $controller_name = 'Controllers\\' . $controller_name;
        if( class_exists($controller_name) ){
            $controller = new $controller_name;
            $controller->node($action);
        } else {
            echo 'Не удалось найти такой контроллер: ';
            echo $controller_name;
        }

        $db->close();   
    }
}
