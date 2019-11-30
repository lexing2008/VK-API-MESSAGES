<?php

namespace Controllers;

use Controllers\AbstractController;
use Models\Vk;
use Models\Conversations;
use VK\Exceptions\Api\VKApiParamException;
use Config\Config;
/**
 * Description of Cron
 *
 * @author Lexing
 */
class Cron extends AbstractController{
    //put your code here
    
    public function p_index(){
       
        $this->render('index.php', $site);
    }
    
    
    /**
     * Добавляет в БД новые беседы VK
     */
    public function p_conversations(){
        
        $conversations_in_db = new Conversations;
        $arr_peer = $conversations_in_db->get_all_peer_id();
        
        $vk = new Vk;
        $conversations_from_vk = $vk->get_conversations($offset, 20);
        
        if( !empty($conversations_from_vk['items']) ){
            foreach ($conversations_from_vk['items'] as $key => $item) {
                $peer_id = $item['conversation']['peer']['id'];
                if( !in_array($peer_id, $arr_peer) ){
                    $conversations_in_db->add($peer_id);
                }
            }
        }
        
        if( count($conversations_from_vk['items']) == 20 ){
            // следующая итерация
            $config = Config::getInstance();
            header('Location: http://' . $config->get('DOMAIN') . '/index.php?controller=cron&action=conversations&offset=' .  ($offset+20));
            die();
        }
    } 
    
    /**
     * Добавляет в БД сообщения беседы
     */
    public function p_messages(){
        // получаем список бесед без загруженных сообщений
        $conversations_in_db = new Conversations;
        $arr_conv = $conversations_in_db->get_by_status_messages( Conversations::STATUS_MESSAGES_DEFAULT );
        
        $vk = new Vk;
        
        $size = count($arr_conv);
        for($i=0; $i<$size; ++$i){
            $messages = $vk->get_messages( $arr_conv[$i]['peer_id'] );
            
            if( !empty($messages['items']) ){
                $from_id = $messages['items'][0]['from_id'];
                $date_first_message = $messages[0]['date'];
                // ищем сообщение от администратора
                $j = 1;
                while( $messages['items'][$j]['from_id'] ==  $from_id ){
                    ++$j;
                }

                if( $j < count($messages) ) {
                    // если имеется ответ администратора
                    $date_response = $messages['items'][$j]['date'];
                    $status = Conversations::STATUS_MESSAGES_PROCESSED;
                } else {
                    // если Администратор не ответил еще
                    $date_response = time();
                    $status = Conversations::STATUS_MESSAGES_DEFAULT;
                }
                $time_response = $date_response - $date_first_message;
                // сохраняем в БД
                $conversations_in_db->update_by_id($arr_conv[$i]['id'], $date_first_message, $date_response, $reponse_time, $status );
            }
            
            echo '<pre>';
            print_r( $messages );
            echo '</pre>';
        }
    }
}
