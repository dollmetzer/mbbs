<?php

/**
 * CORE - Web Application Core Elements
 * 
 * Typical Elements for every Web Application
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */

namespace Application\modules\core\controllers;

/**
 * CORE Account Controller
 * 
 * Methods fpr Account Handling (login, logout, register, ...)
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class accountController extends \dollmetzer\zzaplib\Controller
{


    /**
     * Login form processing.
     * 
     * After successful login, jump to the startpage
     */
    public function loginAction()
    {

        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'loginform';
        $form->fields = array(
            'handle' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
            ),
            'password' => array(
                'type' => 'password',
                'required' => true,
                'maxlength' => 32,
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => 'login'
            ),
        );

        if ($form->process()) {

            // get user
            $values = $form->getValues();
            $userModel = new \Application\modules\core\models\userModel($this->app);
            $user = $userModel->getByLogin($values['handle'], $values['password']);
            if (!$user) {
                $this->app->forward($this->buildURL('account/login'), $this->lang('error_login_failed'), 'error');
            }

            // process user
            $userModel->setLastlogin($user['id']);
            $this->app->session->user_id = $user['id'];
            $this->app->session->user_handle = $user['handle'];
            $this->app->session->user_lastlogin = $user['lastlogin'];
            $this->app->session->user_language = $user['language'];

            // process user groups
            $groupModel = new \Application\modules\core\models\groupModel($this->app);
            $groups = $groupModel->getUserGroups($user['id']);
            $sessionGroups = array();
            for ($i = 0; $i < sizeof($groups); $i++) {
                $sessionGroups[$groups[$i]['id']] = $groups[$i]['name'];
            }
            $this->app->session->groups = $sessionGroups;

            $this->app->forward($this->buildURL('/'), $this->lang('msg_logged_in'));
        }
        $this->app->view->content['form'] = $form->getViewdata();

        $this->app->view->content['nav_main'] = 'login';
    }


    /**
     * Destroys the Session and jumps to the startpage
     */
    public function logoutAction()
    {

        $this->app->session->destroy();
        $this->app->forward($this->buildURL('/'), $this->lang('msg_logged_out'));
    }


    /**
     * Not yet implemented
     */
    public function resetpasswordAction()
    {
        
    }


    /**
     * Not yet implemented
     */
    public function registerAction()
    {
        
    }

}

?>
