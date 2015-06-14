<?php

/**
 * CORE - Web Application Core Elements
 * 
 * Typical Elements for every Web Application
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */

namespace Application\modules\core\controllers;

/**
 * CORE User Administration Controller
 * 
 * Methods for handling useraccounts
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class adminuserController extends \Application\modules\core\controllers\Controller
{

    /**
     * @var type array neccessary access rights
     */
    protected $accessGroups = array(
        'index' => array('administrator'),
        'edit' => array('administrator'),
        'show' => array('administrator'),
        'add' => array('administrator'),
        'delete' => array('administrator'),
        'addgroup' => array('administrator'),
        'deletegroup' => array('administrator')
    );


    /**
     * Show a listof user
     */
    public function indexAction()
    {

        $userModel = new \Application\modules\core\models\userModel($this->app);
        
        // pagination
        $listEntries = $userModel->getListEntries();
        $listLength = 10;
        $page = 0;
        if(sizeof($this->app->params)>0) {
            $page = (int)$this->app->params[0]-1;
        }
        $maxPages = ceil($listEntries / $listLength);
        $firstEntry = $page * $listLength;
        
        $list = $userModel->getList($firstEntry, $listLength);

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_user');
        $this->app->view->content['list'] = $list;
        $this->app->view->content['pagination_page'] = $page;
        $this->app->view->content['pagination_maxpages'] = $maxPages;
        $this->app->view->content['pagination_link'] = $this->buildURL('core/adminuser/index/%d');
        
    }


    /**
     * Show user details
     */
    public function showAction()
    {

        if (sizeof($this->app->params) == 0) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_missing_parameter'), 'error');
        }
        $id = (int) $this->app->params[0];
        $userModel = new \Application\modules\core\models\userModel($this->app);
        $user = $userModel->read($id);

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        $groups = $groupModel->getUserGroups($id);

        if (empty($user)) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_illegal_parameter'), 'error');
        }

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_user');
        $this->app->view->content['user'] = $user;
        $this->app->view->content['groups'] = $groups;
    }


    /**
     * Edit user
     */
    public function editAction()
    {

        if (sizeof($this->app->params) == 0) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_missing_parameter'), 'error');
        }
        $id = (int) $this->app->params[0];
        $userModel = new \Application\modules\core\models\userModel($this->app);
        $user = $userModel->read($id);

        if (empty($user)) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_illegal_parameter'), 'error');
        }

        $languages = array();
        foreach ($this->app->config['languages'] as $lang) {
            $languages[$lang] = $this->lang('txt_lang_' . $lang);
        }

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        $groups = $groupModel->getUserGroups($id);
        $allGroups = $groupModel->getList();

        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'edituser';
        $form->fields = array(
            'handle' => array(
                'type' => 'static',
                'value' => $user['handle']
            ),
            'active' => array(
                'type' => 'checkbox',
                'value' => $user['active']
            ),
            'language' => array(
                'type' => 'select',
                'required' => true,
                'options' => $languages,
                'value' => $user['language']
            ),
            'created' => array(
                'type' => 'static',
                'value' => $this->app->view->toDatetime($user['created'], false)
            ),
            'lastlogin' => array(
                'type' => 'static',
                'value' => $this->app->view->toDatetime($user['lastlogin'], false)
            ),
            'change' => array(
                'type' => 'submit',
                'value' => 'change'
            ),
        );

        if ($form->process()) {

            // get user
            $values = $form->getValues();

            $newValues = array(
                'active' => 0,
                'language' => $values['language']
            );
            if (!empty($values['active']))
                $newValues['active'] = 1;

            $userModel->update($id, $newValues);
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('msg_user_changed'), 'notice');
        }

        $this->app->view->content['form'] = $form->getViewdata();
        $this->app->view->content['user'] = $user;
        $this->app->view->content['groups'] = $groups;
        $this->app->view->content['allgroups'] = $allGroups;
        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_user');
    }


    /**
     * Add a new user
     */
    public function addAction()
    {

        $languages = array();
        foreach ($this->app->config['languages'] as $lang) {
            $languages[$lang] = $this->lang('txt_lang_' . $lang);
        }

        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'adduser';
        $form->fields = array(
            'handle' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
            ),
            'password' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
            ),
            'active' => array(
                'type' => 'checkbox',
                'value' => true
            ),
            'language' => array(
                'type' => 'select',
                'required' => true,
                'options' => $languages
            ),
            'add' => array(
                'type' => 'submit',
                'value' => 'add'
            ),
        );

        if ($form->process()) {

            // get user
            $values = $form->getValues();

            $userModel = new \Application\modules\core\models\userModel($this->app);
            $user = $userModel->getByHandle($values['handle']);
            if (empty($user)) {

                $active = 0;
                if (!empty($values['active']))
                    $active = 1;
                $newValues = array(
                    'active' => $active,
                    'handle' => $values['handle'],
                    'password' => sha1($values['password']),
                    'language' => $values['language'],
                    'created' => strftime('%Y-%m-%d %H:%M:%S', time())
                );
                $uid = $userModel->create($newValues);
                
                // add user to standard user group
                $groupModel = new \Application\modules\core\models\groupModel($this->app);
                $group = $groupModel->getByName('user');
                $groupModel->setUserGroup($uid, $group['id']);
                
                $this->app->forward($this->buildURL('core/adminuser'), $this->lang('msg_user_added'), 'notice');
            } else {
                $form->fields['handle']['error'] = $this->lang('form_error_handle_exists');
            }
        }

        $this->app->view->content['form'] = $form->getViewdata();
        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_useradd');
    }


    /**
     * Delete user
     */
    public function deleteAction()
    {

        if (sizeof($this->app->params) == 0) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_missing_parameter'), 'error');
        }
        $id = (int) $this->app->params[0];
        if ($this->app->session->user_id == $id) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_user_delete_yourself'), 'error');
        }
        die('trapped');

        $userModel = new \Application\modules\core\models\userModel($this->app);
        $user = $userModel->read($id);

        if (empty($user)) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_illegal_parameter'), 'error');
        }

        // only delete, if no mails from or to user exists
        $username = $user['handle'] . '@' . $this->app->config['systemname'];
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $mails = $mailModel->getMaillist('from', $username);
        if (!empty($mails)) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_user_delete'), 'error');
        }
        $mails = $mailModel->getMaillist('to', $username);
        if (!empty($mails)) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_user_delete'), 'error');
        }

        $userModel->delete($user['id']);
        $this->app->forward($this->buildURL('core/adminuser'), $this->lang('msg_user_deleted'), 'message');
    }


    /**
     * Add a new group
     */
    public function addgroupAction()
    {

        if (sizeof($this->app->params) < 2) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_missing_parameter'), 'error');
        }
        $gid = (int) $this->app->params[1];
        $uid = (int) $this->app->params[0];

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        $groupModel->addUserGroup($uid, $gid);

        $this->app->forward($this->buildURL('core/adminuser/edit/' . $uid), $this->lang('msg_user_groupadd'), 'message');
    }


    /**
     * Delete a group
     */
    public function deletegroupAction()
    {

        if (sizeof($this->app->params) < 2) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_missing_parameter'), 'error');
        }
        $gid = (int) $this->app->params[1];
        $uid = (int) $this->app->params[0];

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        // check, if there is at least one group left after deleting.
        if(sizeof($groupModel->getUserGroups($uid)) < 2) {
            $this->app->forward($this->buildURL('core/adminuser/edit/' . $uid), $this->lang('error_group_delete'), 'error');
        }
        
        $groupModel->deleteUserGroup($uid, $gid);

        $this->app->forward($this->buildURL('core/adminuser/edit/' . $uid), $this->lang('msg_user_groupdelete'), 'message');
    }

}
