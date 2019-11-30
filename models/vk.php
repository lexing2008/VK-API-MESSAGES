<?php


namespace Models;
use Config\Config;
use \VK\Client\VKApiClient;

/**
 * Класс Модель vk
 *
 * @author Lexing
 */
class Vk {
    protected $vk;
    
    public function __construct(){
        $config = Config::getInstance();
        $this->vk = new VKApiClient( $config->get('VK_API_VERSION') );        
    }
    
    /**
     * Возвращает беседы Вконтакте
     * @param int $offset смещение
     * @param int $count Количество бесед
     * @return array массив бесед
     */
    public function get_conversations( $offset, $count){
        $config = Config::getInstance();
        return $this->vk->messages()->getConversations( $config->get('VK_ACCESS_TOKEN') , array(
                'offset' => 0,
                'count' => 20,
                'group_id' => $config->get('VK_GROUP_ID'),
            ));
    }
    
    /**
     * Возвращает 30 первых сообщений в беседе с $user_id
     * @param int $user_id идентификатор пользователя с которым идет беседа
     * @return array массив бесед
     */
    public function get_messages( $user_id ){
        $config = Config::getInstance();
        return $this->vk->messages()->getHistory( $config->get('VK_ACCESS_TOKEN') , array(
            'user_id' => $user_id, // id пользователя сообщения переписки с которым нужно вернуть
            'start_message_id' => 0, // начиная с 0 сообщения вернуть
            'count' => 30,
        ));
    }
}
