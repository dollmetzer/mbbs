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
 * CORE User Administration Controller
 * 
 * Methods for handling useraccounts
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class adminuserController extends \dollmetzer\zzaplib\Controller
{

    /**
     * @var type array neccessary access rights
     */
    protected $accessGroups = array(
        'index' => array('administrator')
    );

    public function indexAction()
    {

        $userModel = new \Application\modules\core\models\userModel($this->app);
        $list = $userModel->getList();

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_user');
        $this->app->view->content['list'] = $list;
    }

    public function showAction()
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

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_user');
        $this->app->view->content['user'] = $user;
    }

}
