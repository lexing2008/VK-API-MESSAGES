<?php

namespace Controllers;

use Models\User;
use Config\Config;
use Core\AntiCSRF;
use Core\Lang\Lang;
use DB\DB;
use Models\EntranceForm;
use Models\RegistrationForm;

/**
 * Контроллер Site
 *
 * @author Алексей Согоян
 */
class Site extends AbstractController {

    
    /**
     * Главная страница
     */
    public function p_index(){
       
        $this->render('index.php', $site);
    }
}
