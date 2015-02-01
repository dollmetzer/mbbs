<?php

/**
 * BBS - Bulletin Board System
 * 
 * A small BBS package for mobile use
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */

namespace Application\modules\bbs\controllers;

/**
 * BBS Users Controller
 * 
 * Methods for handling the users list
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class usersController extends \Application\modules\core\controllers\Controller
{

    /**
     * @var array $accessGroups
     */
    protected $accessGroups = array(
        'index' => array('user', 'operator', 'administrator', 'moderator'),
    );


    /**
     * Show a list of basic users, that are active
     */
    public function indexAction()
    {

        $usersModel = new \Application\modules\core\models\userModel($this->app);
        $users = $usersModel->getListByGroup(4);

        $this->app->view->content['nav_main'] = 'users';
        $this->app->view->content['title'] = $this->lang('title_users');
        $this->app->view->content['users'] = $users;
    }

}
