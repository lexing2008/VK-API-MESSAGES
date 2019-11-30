<?php

namespace Controllers;

use Controllers\AbstractController;
use Core\Helpers\Helper;
use Models\Conversations;
use Config\Config;

/**
 * Description of Statistic
 *
 * @author Lexing
 */
class Statistic extends AbstractController{
    //put your code here
    
    public function p_index(){
        $config = Config::getInstance();
        
        if( empty($_GET['date']) ){
            $date_unix_from = time();
        } else {
            $date_unix_from = Helper::date_to_unixtime($_GET['date']);
        }
        $date_unix_to = $date_unix_from + 24*60*60;
        
        $conv = new Conversations();
        // среднее время ответа
        $avg_response_time = $conv->get_avg_time_response($date_unix_from, $date_unix_to);

        $site['avg_response_time'] = $avg_response_time['avg_response_time'];
        // получаем диалоги, в которых время ответа превышает 15 минут
        $site['dialogs'] = $conv->get_dialogs($date_unix_from, $date_unix_to, 15*60);
        $site['vk_group_id'] = $config->get('VK_GROUP_ID');
        
        $site['stat_response'] = $conv->get_statistic_response_time($date_unix_from, $date_unix_to);
                
        $this->render('index.php', $site);
    }
}