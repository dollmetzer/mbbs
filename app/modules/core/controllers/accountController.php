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
 * Methods for account handling (login, logout, register, ...)
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class accountController extends \dollmetzer\zzaplib\Controller
{

    /**
     * @var type array neccessary access rights
     */
    protected $accessGroups = array(
        'login'         => array('guest'),
        'register'      => array('guest'),
        'logout'        => array('user','operator','administrator','moderator'),
        'resetpassword' => array('user','operator','administrator','moderator'),
        'settings'      => array('user','operator','administrator','moderator')
    );
    
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
        $this->app->view->content['title'] = $this->lang('title_login');

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
        die('Not yet implemented');
    }


    /**
     * Not yet implemented
     */
    public function registerAction()
    {
        
        // exit, if self register is not allowed
        if($this->app->config['register']['selfregister'] !== true) {
            $this->app->forward($this->buildURL('/'));
        }

        $languages = array();
        foreach($this->app->config['languages'] as $lang) {
            $languages[$lang] = $this->lang('txt_lang_'.$lang);
        }
        
        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'loginform';
        $form->fields = array(
            'handle' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
            ),
            'language' => array(
                'type' => 'select',
                'options' => $languages,
                'required' => true,
                'value' => $this->app->session->user_language
            ),
            'password' => array(
                'type' => 'password',
                'required' => true,
                'maxlength' => 32,
            ),
            'password2' => array(
                'type' => 'password',
                'required' => true,
                'maxlength' => 32,
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => 'register'
            ),
        );

        if ($form->process()) {

            $values = $form->getValues();
            
            if($values['password'] != $values['password2']) {
                $form->fields['password']['error'] = $this->lang('form_error_not_identical');
            } else {
                
                $userModel = new \Application\modules\core\models\userModel($this->app);
                $user = $userModel->getByHandle($values['handle']);
                if(!empty($user)) {
                    $form->fields['handle']['error'] = $this->lang('form_error_handle_exists');
                } else {
                    $data = array(
                        'active' => 1,
                        'handle' => $values['handle'],
                        'password' => sha1($values['password']),
                        'language' => $values['language'],
                        'created' => strftime('%Y-%m-%d %H:%M:%S', time())
                    );
                    $id = $userModel->create($data);
                    
                    // ...and now login
                    $userModel->setLastlogin($id);
                    $this->app->session->user_id = $id;
                    $this->app->session->user_handle = $values['handle'];
                    $this->app->session->user_lastlogin = strftime('%Y-%m-%d %H:%M:%S', time());
                    $this->app->session->user_language = $values['language'];

                    // add user to standard user group (5)
                    $groupModel = new \Application\modules\core\models\groupModel($this->app);
                    $group = $groupModel->getByName('user');
                    $groupModel->setUserGroup($id, $group['id']);
                    $sessionGroups[$group['id']] = $group['name'];
                    $this->app->session->groups = $sessionGroups;
                    
                    $this->app->forward($this->buildURL('/'), $this->lang('msg_logged_in'));
            
                }
            }
        }
        
        $this->app->view->content['form'] = $form->getViewdata();
        $this->app->view->content['nav_main'] = 'settings';
        
    }

    /**
     * Basic settings
     */
    public function settingsAction() {
        
        $languages = array();
        foreach($this->app->config['languages'] as $lang) {
            $languages[$lang] = $this->lang('txt_lang_'.$lang);
        }
        
        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'loginform';
        $form->fields = array(
            'language' => array(
                'type' => 'select',
                'required' => true,
                'options' => $languages,
                'value' => $this->app->session->user_language
            ),
            'password' => array(
                'type' => 'password',
                'maxlength' => 32,
            ),
            'password2' => array(
                'type' => 'password',
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
            
            if($values['password'] != $values['password2']) {
                $form->fields['password']['error'] = $this->lang('form_error_not_identical');
                $form->fields['password2']['error'] = $this->lang('form_error_not_identical');
            } else {
                
                $dbVal = array('language' => $values['language']);
                if(!empty($values['password'])) {
                    $dbVal['password'] = sha1($values['password']);
                }                
                $userModel = new \Application\modules\core\models\userModel($this->app);
                $userModel->update($this->app->session->user_id, $dbVal);
                
                $this->app->forward($this->buildURL('/'), $this->lang('msg_settings_saved'));
                
            }
                        
        }
        
        $this->app->view->content['form'] = $form->getViewdata();
        $this->app->view->content['nav_main'] = 'settings';
        $this->app->view->content['title'] = $this->lang('title_settings');
    
    }
    
}

?>
