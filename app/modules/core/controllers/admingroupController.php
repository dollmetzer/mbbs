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
        'index' => array('administrator')
    );

    public function indexAction()
    {

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        $list = $groupModel->getList();

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title'] = $this->lang('title_admin_group');
        $this->app->view->content['list'] = $list;
    }

}
