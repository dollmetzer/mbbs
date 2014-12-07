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
 * CORE Group Administration Controller
 * 
 * Methods for handling usergroups
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class admingroupController extends \dollmetzer\zzaplib\Controller
{

    /**
     * @var type array neccessary access rights
     */
    protected $accessGroups = array(
        'index' => array('administrator'),
        'show' => array('administrator'),
        'edit' => array('administrator'),
        'add' => array('administrator')
    );


    /**
     * List Groups
     */
    public function indexAction()
    {

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        $list = $groupModel->getList();

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_group');
        $this->app->view->content['list'] = $list;
    }


    /**
     * Show Group Details
     */
    public function showAction()
    {

        if (sizeof($this->app->params) == 0) {
            $this->app->forward($this->buildURL('core/adminuser'), $this->lang('error_missing_parameter'), 'error');
        }
        $id = (int) $this->app->params[0];

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        $group = $groupModel->read($id);

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_group');
        $this->app->view->content['group'] = $group;
    }


    /**
     * Add a new group
     */
    public function addAction()
    {

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_groupadd');
        $this->app->view->content['group'] = $group;
    }


    /**
     * Delete a group
     */
    public function deleteAction()
    {

        die('delete action');
    }

}
