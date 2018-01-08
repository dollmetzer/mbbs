<?php
/**
 * z z a p   a p p   e x a m p l e   a p p l i c a t i o n
 * =======================================================
 *
 * This is a base application using the zzaplib web applications mini framework
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 3 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses/>.
 */

namespace Application\modules\users\controllers;

/**
 * Class accountController
 * Actions around the users account
 *
 * @author Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @copyright 2016-2017 Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @package zzap_app
 * @subpackage users
 */
class accountController extends \Application\modules\core\controllers\Controller
{

    /**
     * @var array $accessGroups For every action name is an array of allowed user groups
     */
    public $accessGroups = array(
        'login' => 'guest',
        'logout' => 'user',
        'register' => 'guest',
        'confirm' => 'guest',
        'pwdreset' => 'guest',
        'settings' => 'user',
    );


    /**
     * Show details of the user account
     */
    public function indexAction()
    {

    }

    /**
     * Show and process login form
     */
    public function loginAction()
    {

        $form = new \dollmetzer\zzaplib\Form($this->request, $this->view);
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

            $values = $form->getValues();

            $userModel = new \Application\modules\users\models\userModel($this->config);
            $user = $userModel->getByLogin($values['handle'], $values['password']);

            if (!empty($user)) {
                if (!empty($user['active'])) {

                    $groupModel = new \Application\modules\users\models\groupModel($this->config);
                    $groups = $groupModel->getUserGroups($user['id']);
                    $this->session->login($user, $groups);
                    $userModel->setLastlogin($user['id']);
                    $this->request->forward($this->buildURL(''), $this->lang('msg_users_loginsuccess'), 'message');

                }
            } else {
                $this->request->forward($this->buildURL('users/account/login'), $this->lang('error_users_loginfailed'),
                    'error');
            }

        }

        $this->view->content['form'] = $form->getViewdata();
        $this->view->content['title'] = $this->lang('title_users_login');

    }

    /**
     * logout and forward to the start page
     */
    public function logoutAction()
    {

        $this->session->destroy();
        $this->request->forward($this->buildURL(''), $this->lang('msg_users_logoutsuccess'), 'message');

    }

    /**
     * Show and process the register form
     */
    public function registerAction()
    {

        // if self registration is not allowed, forward to startpage
        if ($this->config['register']['selfregister'] !== true) {
            $this->request->forward($this->buildURL(''), $this->lang('error_core_accessdenied'), 'error');
        }

        $languages = array();
        for ($i = 0; $i < sizeof($this->config['languages']); $i++) {
            $languages[$this->config['languages'][$i]] = $this->lang('language_' . $this->config['languages'][$i]);
        }

        $form = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name = 'registerform';
        if($this->config['register']['separate_handle'] === true) {
            $form->fields['handle'] = array(
                'type' => 'text',
                'required' => true,
                'pattern' => '/^[a-z0-9_\-]*$/i',
                'minlength' => 6,
                'maxlength' => 32,
                'help' => $this->lang('form_help_registerform_handle'),
            );
        }

        if ($this->config['register']['mailcheck'] === true) {
            $form->fields['email'] = array(
                'type' => 'email',
                'required' => true,
                'maxlength' => 255,
            );
        }

        $form->fields['password'] = array(
            'type' => 'password',
            'required' => true,
            'minlength' => 8,
            'maxlength' => 32,
            'help' => $this->lang('form_help_registerform_password'),
        );
        $form->fields['password2'] = array(
            'type' => 'password',
            'required' => true,
            'minlength' => 8,
            'maxlength' => 32,
        );
        $form->fields['language'] = array(
            'type' => 'select',
            'required' => true,
            'options' => $languages,
            'value' => $this->session->user_language,
        );
        $form->fields['submit'] = array(
            'type' => 'submit',
            'value' => 'login',
        );

        if ($form->process()) {

            $values = $form->getValues();

            if($this->config['register']['separate_handle'] !== true) {
                $values['handle'] = $values['email'];
            }

            // test, if username is already in use
            $userModel = new \Application\modules\users\models\userModel($this->config);
            $user = $userModel->getByHandle($values['handle']);
            if (!empty($user)) {
                if($this->config['register']['separate_handle'] === true) {
                    $form->fields['handle']['error'] = $this->lang('error_users_handleexists');
                } else {
                    $form->fields['email']['error'] = $this->lang('error_users_emailexists');
                }
                $form->hasErrors = true;
            }

            // test, if first password matches the second password
            if ($values['password'] != $values['password2']) {
                $form->fields['password2']['error'] = $this->lang('error_users_passwordmismatch');
                $form->hasErrors = true;
            }

            if ($form->hasErrors != true) {

                $created = strftime('%Y-%m-%d %H:%H:%S');

                // set confirmed value only, if no mailconfirm is set
                if ($this->config['register']['mailcheck'] === true) {
                    $confirmed = '';
                    $active = 0;
                } else {
                    $confirmed = $created;
                    $active = 1;
                }

                $confirmcode = substr(md5($values['handle'] . $values['password'] . $values['language'] . time()), 8);
                $uid = $userModel->create(
                    $values['handle'],
                    $values['password'],
                    $values['language'],
                    $active,
                    $values['email'],
                    $confirmcode,
                    $created,
                    $confirmed
                );

                // attach standard user group to new user
                $groupModel = new \Application\modules\users\models\groupModel($this->config);
                $group = $groupModel->getByName('user');
                if (!empty($group)) {
                    $groupModel->addUserGroup($uid, $group['id']);
                }

                // send mail
                if ($this->config['register']['mailcheck'] === true) {
                    if ($this->sendRegistrationMail($uid) === false) {
                        $this->request->log('Sending registration of user ' . $values['handle'] . ' failed!');
                    }
                }

                $this->request->forward($this->buildURL('users/account/confirm'), $this->lang('msg_users_registersuccess'),
                    'notice');

            }
        }

        $this->view->content['form'] = $form->getViewdata();
        $this->view->content['title'] = $this->lang('title_users_register');

    }

    /**
     * show and process register confirmation form
     */
    public function confirmAction()
    {

        $confirmcode = '';
        if (sizeof($this->request->params) > 0) {
            $confirmcode = $this->request->params[0];
        }

        $form = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->action = $this->buildUrl('users/account/confirm');
        $form->name = 'confirmform';
        $form->fields = array(
            'confirmcode' => array(
                'type' => 'text',
                'required' => true,
                'pattern' => '/^[a-z0-9]{8}$/i',
                'maxlength' => 8,
                'help' => $this->lang('form_help_confirmcode'),
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => 'confirm'
            ),
        );

        if (empty($confirmcode)) {
            if ($form->process()) {

                $values = $form->getValues();
                $confirmcode = $values['confirmcode'];

            }
        }

        // try to confirm registration, if code is present
        if (!empty($confirmcode)) {

            $userModel = new \Application\modules\users\models\userModel($this->config);
            $user = $userModel->getByConfirmcode($confirmcode);
            if (!empty($user)) {
                $data = array(
                    'active' => 1,
                    'confirmcode' => '',
                    'confirmed' => strftime('%Y-%m-%d %H:%M:%S')
                );
                $userModel->update($user['id'], $data);

                // send confirmation mail
                if ($this->sendConfirmationMail($user['id']) === false) {
                    $this->request->log('Sending confirmationmail for user ' . $values['handle'] . ' failed!');
                }

                $this->forward($this->buildURL(''), $this->lang('msg_users_confirmsuccess'), 'notice');
            } else {
                $form->fields['confirmcode']['error'] = $this->lang('form_error_illegal_confirmcode');
            }


        }

        $this->view->content['form'] = $form->getViewdata();
        $this->view->content['title'] = $this->lang('title_users_confirm');

    }

    /**
     * Show and process the password reset page
     */
    public function pwdresetAction()
    {

        $form = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name = 'pwdresetform';
        $form->fields = array(
            'handle' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => 'reset'
            ),
        );


        if ($form->process()) {

            $values = $form->getValues();

            $userModel = new \Application\modules\users\models\userModel($this->config);
            $user = $userModel->getByHandle($values['handle']);

            if (empty($user)) {
                $form->fields['handle']['error'] = $this->lang('form_error_handle_unknown');
            } else {

                $user['newpwd'] = substr(uniqid(time()), 8);
                $userModel->setPassword($user['id'], $user['newpwd']);

                $mail = new \dollmetzer\zzaplib\Mail($this->config, $this->session, $this->request);
                $mail->send(
                    'modules/users/views/frontend/_mail/resetpwd_' . $this->session->user_language . '.php',
                    $user,
                    $this->lang('mailsubject_users_resetpwd'),
                    $user['email']
                );

                $this->request->forward($this->buildURL('users/account/login'), $this->lang('msg_users_resetpwdsuccess'), 'notice');

            }
        }

        $this->view->content['form'] = $form->getViewdata();
        $this->view->content['title'] = $this->lang('title_users_pwdreset');

    }


    public function settingsAction()
    {

        $languages = array();
        for ($i = 0; $i < sizeof($this->config['languages']); $i++) {
            $languages[$this->config['languages'][$i]] = $this->lang('language_' . $this->config['languages'][$i]);
        }

        $userModel = new \Application\modules\users\models\userModel($this->config);
        $user = $userModel->read($this->session->user_id);

        $form = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name = 'settingsform';

        $form->fields['email'] = array(
            'type' => 'email',
            'required' => true,
            'maxlength' => 255,
            'value' => $user['email'],
        );
        $form->fields['password'] = array(
            'type' => 'password',
            'minlength' => 8,
            'maxlength' => 32,
            'help' => $this->lang('form_help_registerform_password'),
        );
        $form->fields['password2'] = array(
            'type' => 'password',
            'minlength' => 8,
            'maxlength' => 32,
        );
        $form->fields['language'] = array(
            'type' => 'select',
            'required' => true,
            'options' => $languages,
            'value' => $user['language'],
        );

        $form->fields['submit'] = array(
            'type' => 'submit',
        );

        if ($form->process()) {

            $values = $form->getValues();

            // test, if first password matches the second password
            if ($values['password'] != $values['password2']) {
                $form->fields['password2']['error'] = $this->lang('error_users_passwordmismatch');
                $form->hasErrors = true;
            }

            if ($form->hasErrors === false) {

                // update normal data
                $data = array(
                    'email' => $values['email'],
                    'language' => $values['language'],
                );
                $userModel->update($user['id'], $data);

                // set password?
                if (!empty($values['password'])) {
                    $userModel->setPassword($user['id'], $values['password']);
                }

                $this->request->forward($this->buildURL(''), $this->lang('msg_users_settingssaved'), 'message');

            }

        }

        $this->view->content['form'] = $form->getViewdata();
        $this->view->content['title'] = sprintf($this->lang('title_users_settings'), $user['handle']);

    }



    protected function sendRegistrationMail($_uid)
    {

        $userModel = new \Application\modules\users\models\userModel($this->config);
        $user = $userModel->read((int)$_uid);
        if (empty($user)) {
            return false;
        }

        $mail = new \dollmetzer\zzaplib\Mail($this->config, $this->session, $this->request);
        return $mail->send(
            'modules/users/views/frontend/_mail/register_' . $this->session->user_language . '.php',
            $user,
            $this->lang('mailsubject_users_register'),
            $user['email']
        );

    }

    protected function sendConfirmationMail($_uid)
    {

        $userModel = new \Application\modules\users\models\userModel($this->config);
        $user = $userModel->read((int)$_uid);
        if (empty($user)) {
            return false;
        }

        $mail = new \dollmetzer\zzaplib\Mail($this->config, $this->session, $this->request);
        return $mail->send(
            'modules/users/views/frontend/_mail/confirm_' . $this->session->user_language . '.php',
            $user,
            $this->lang('mailsubject_users_confirm'),
            $user['email']
        );

    }


}