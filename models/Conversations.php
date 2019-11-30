<?php

namespace Models;

use DB\DB;

/**
 * Модель User
 *
 * @author Алексей Согоян
 */
class Conversations {
    const STATUS_MESSAGES_DEFAULT = 0;
    const STATUS_MESSAGES_UPLOADED = 1;
    const STATUS_MESSAGES_PROCESSED = 2;

    /**
     *  Возвращает массив VK ID бесед (peer_id) 
     * @return array массив
     */
    public function get_all_peer_id(){
        $data = [];
        $db = DB::getInstance();
        $statement = $db->prepare('SELECT id, peer_id
                                    FROM conversations');
        $statement->execute(array(
        ));
        
        while( $res = $statement->fetch() ){
            $data[] = $res['peer_id'];
        }
        return $data;
    }
    

    /**
     *  Возвращает массив VK ID бесед (peer_id) 
     * @return array массив
     */
    public function get_by_status_messages( $status_messages ){
        $data = [];
        $db = DB::getInstance();
        $statement = $db->prepare('SELECT id, peer_id, date_first_message, response_time, status_messages
                                    FROM conversations
                                    WHERE status_messages = :status_messages
                                    LIMIT 20');
        $statement->execute(array(
            'status_messages' => $status_messages
        ));
        while( $res = $statement->fetch() ){
            $data[] = $res;
        }
        return $data;
    }
        
    /**
     * 
     * @param int $peer_id
     * @param int $date_first_message
     * @param int $date_response
     * @param int $status_messages
     */
    public function update_by_id( $id, $date_first_message, $date_response, $reponse_time, $status_messages ){
        $statement = $db->prepare('UPDATE `vk_db`.`conversations` SET
                                    `response_time` = :response_time,
                                    `date_first_message` = :date_first_message,
                                    `date_response` = :date_response,
                                    `status_messages` = :status_messages 
                                    WHERE `id` = :id
                    ');
        $statement->execute(array(
            'id' => $id,
            'date_first_message' => $date_first_message,
            'date_response' => $date_response,
            'response_time' => $response_time,
            'status_messages' => $status_messages,
        ));
    }
    
    /**
     * Добавляет беседу в БД
     * @param int $peer_id
     * @param int $date_first_message
     * @param int $response_time
     * @param int $status_messages
     */
    public function add( $peer_id, $date_first_message = 0, $response_time = 0, $status_messages = 0){
        // создаем пользователя в БД
        $db = DB::getInstance();

        $statement = $db->prepare('INSERT INTO conversations (peer_id, date_first_message, response_time, status_messages)
            VALUES(:peer_id, :date_first_message, :response_time, :status_messages)');
        $statement->execute(array(
            'peer_id' => $peer_id,
            'date_first_message' => $date_first_message,
            'response_time' => $response_time,
            'status_messages' => $status_messages,
        ));
    }
    
    /**
     *  Возвращает среднее время ответа за указанный период
     * @return array массив
     */
    public function get_avg_time_response( $date_unix_from, $date_unix_to ){
        $db = DB::getInstance();
        $statement = $db->prepare('SELECT AVG(response_time) as avg_response_time
                                    FROM conversations
                                    WHERE date_first_message >= :date_unix_from
                                    AND date_first_message <= :date_unix_to
                                    AND response_time > 0');
        $statement->execute(array(
            'date_unix_from' => $date_unix_from,
            'date_unix_to' => $date_unix_to,
        ));
        return $statement->fetch();
    }

    
    /**
     * Возвращает диалоги, в которых время ответа превышает $max_response_time
     * @param int $date_unix_from Дата от
     * @param int $date_unix_to Дата до
     * @param int $max_response_time Время ответа в секундах
     * @return array диалоги 
     */
    public function get_dialogs( $date_unix_from, $date_unix_to, $max_response_time ){
        $data = [];
        $db = DB::getInstance();
        $statement = $db->prepare('SELECT id, peer_id, response_time
                                    FROM conversations
                                    WHERE date_first_message >= :date_unix_from
                                    AND date_first_message <= :date_unix_to
                                    AND response_time >= :response_time');
        $statement->execute(array(
            'date_unix_from' => $date_unix_from,
            'date_unix_to' => $date_unix_to,
            'response_time' => $max_response_time
        ));
        while( $res = $statement->fetch() ){
            $data[] = $res;
        }
        return $data;
    }
    
    
    /**
     * Возвращает наиболее часто встречающееся время ответа
     * @param int $date_unix_from
     * @param int $date_unix_to
     * @param int $max_response_time
     * @return array
     */
    public function get_statistic_response_time( $date_unix_from, $date_unix_to ){
        $data = [];
        $db = DB::getInstance();
        $statement = $db->prepare('SELECT COUNT( * ) AS `count` , response_time
                                    FROM conversations
                                    WHERE date_first_message >= :date_unix_from
                                        AND date_first_message <= :date_unix_to
                                    GROUP BY response_time
                                    HAVING `count` >1
                                    ORDER BY `count` DESC');
        $statement->execute(array(
            'date_unix_from' => $date_unix_from,
            'date_unix_to' => $date_unix_to,
        ));
        while( $res = $statement->fetch() ){
            $data[] = $res;
        }
        return $data;
    }
}