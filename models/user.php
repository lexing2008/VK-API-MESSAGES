<?php

namespace Models;

use DB\DB;

/**
 * Модель User
 *
 * @author Алексей Согоян
 */
class User {

    /** Осуществляет авторизацию пользователя
     * 
     * @param string $email Email пользователя
     * @param string $password пароль пользователя
     * @return bool получилось ли залогиниться
     */
    public static function login($email, $password){
        $password = md5(md5($password));

        $db = DB::getInstance();
        $statement = $db->prepare('SELECT id, name, surname, email, password
                                    FROM users
                                    WHERE email = :email  AND password = :password LIMIT 1');
        $statement->execute(array(
            'email' => $email,
            'password' => $password,
        ));
        
        if( $statement->rowCount() ){
            $_SESSION['user'] = $statement->fetch();
        }

        return !empty($_SESSION['user']);
    }
    
    /** Возвращает true если пользователь авторизован
     * 
     * @return bool 
     */
    public static function is_auth(){
        return !empty( $_SESSION['user']);
    }
    
    /**
     * Возвращает ID пользователя
     * @return int ID пользователя
     */
    public static function user_id(){
        return $_SESSION['user']['id'];
    }
    
    /**
     * Возвращает информацию о пользователе
     * @param int $user_id
     * @return array Массив информации о пользователе
     */
    public static function get_user( $user_id ){
        $db = DB::getInstance();
        $statement = $db->prepare('SELECT id, name, surname, email, phone, password, about, file_photo
                                    FROM users
                                    WHERE id = :id LIMIT 1');
        $statement->execute(array(
            'id' => $user_id
        ));
        return $statement->fetch();
    }
    
    /** Добавляет пользователя с передаваемыми параметрами в базу данных
     * 
     * @param type $surname Фамилия
     * @param type $name Имя
     * @param type $phone Телефон
     * @param type $email Электронная почта
     * @param type $password Пароль
     * @param type $about О себе
     * @param type $file_name Имя файла изображения
     */
    public static function insert_into_database( $surname, $name, $phone, $email, $password, $about, $file_name ){
        // создаем пользователя в БД
        $db = DB::getInstance();

        $statement = $db->prepare('INSERT INTO users (surname, name, phone, email, password, about, file_photo)
            VALUES(:surname, :name, :phone, :email, :password, :about, :file_photo)');
        $statement->execute(array(
            'surname' => $surname,
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => md5(md5($password)),
            'about' => $about,
            'file_photo' => $file_name,
        ));
    }
}