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

    /**
     * Cтраница профайла
     */
    public function p_profile(){
        // получаем информацию о текущем пользователе
        $site['profile'] = User::get_user( User::user_id() );

        $this->render('profile.php', $site);
    }
    
    /**
     * Страница регистрации
     */
    public function p_registration(){

        
        $form = new RegistrationForm();
        $form->set_fields_values($_POST);
        $form->validation();
        
        if( $form->is_form_submit() && $form->is_valid() ){
            // создаем пользователя в БД
            User::insert_into_database($form->get('surname'), $form->get('name'), $form->get('phone'), 
                                        $form->get('email'), $form->get('password'), $form->get('about'), 
                                        $form->get('file_name') );

            if( User::login( $form->get('email'), $form->get('password') ) ){
                header('Location: index.php?controller=site&action=profile');    
                die();
            }
        }

        $site['form'] = $form->get_form();

        $this->render('registration.php', $site);
    }

    /**
     * Страница входа для администратора
     */
    public function p_entrance(){
        $site = array();
        // массив ошибок заполнения формы
        
        $form = new EntranceForm();
        $form->set_fields_values($_POST);

        if( $form->is_form_submit() && $form->validation() ){
            if( !User::login( $form->get('email'), $form->get('password') ) )
                $form->add_field_error( __('Некорректные "Email" или "Пароль"') );
            else {
                header('Location: index.php?controller=site&action=profile');
                die();
            }
        }
        
        $site['form'] = $form->get_form();
        
        $this->render('entrance.php', $site);
    }


    /**
     * Страница выхода
     */
    public function p_exit(){
        unset( $_SESSION['user'] );
        $this->goto_home();
    }
}
