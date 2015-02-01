<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\modules\bbs\controllers;

/**
 * Description of usersController
 *
 * @author dirk
 */
class usersController extends \dollmetzer\zzaplib\Controller {
    
    /**
     * @var array $accessGroups
     */
    protected $accessGroups = array(
        'index' => array('user', 'operator', 'administrator', 'moderator'),
    );
    
    /**
     * Show a list of basic users, that are active
     */
    public function indexAction() {
        
        $usersModel = new \Application\modules\core\models\userModel($this->app);
        $users = $usersModel->getListByGroup(4);

        $this->app->view->content['nav_main'] = 'users';
        $this->app->view->content['title'] = $this->lang('title_users');
        $this->app->view->content['users'] = $users;

    }
    
}
