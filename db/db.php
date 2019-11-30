<?php
namespace DB;

Use Config\Config;
Use Core\Patterns\Singleton;
Use PDO;
use PDOException;
/**
 * Класс работы с БД
 *
 * @author Lexing
 */
class DB {
    use Singleton;
    
    private $pdo = NULL;
    
    /** Соединение с базой данныз Mysql
     * 
     * @throws Exception
     */
    public function connect(){
        $config = Config::getInstance();

        $dsn = 'mysql:host=' . $config->get('DB_HOST') .';dbname=' . $config->get('DB_NAME') .';charset=utf8';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $config->get('DB_USER'), $config->get('DB_PASSWORD'), $options);
    }
    
    /** Возврашает объект PDO
     * 
     * @return PDO объект PDO
     */
    public function pdo(){
        return $this->pdo;
    }
    

    /** Выполняет SQL запрос к БД
     * 
     * @param string $sql
     * @return type результат запроса
     */
    public function query( $sql ){
        return $this->pdo->query($sql);
    }
    
    public function prepare( $sql ){
        return $this->pdo->prepare($sql);
    }
    
    /**
     * Закрытие соединения с БД Mysql
     */
    public function close(){
        $this->pdo = NULL;
    }
}