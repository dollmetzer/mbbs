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
 * CORE Statistics Administration Controller
 * 
 * Methods for simple user statistics
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class adminstatsController extends \Application\modules\core\controllers\Controller {

    /**
     * @var type array neccessary access rights
     */
    protected $accessGroups = array(
        'index' => array('administrator'),
    );
    
    /**
     * Display some basic statistics
     */
    public function indexAction() {
        
        $days = 7;
        $from = strftime('%Y-%m-%d 00:00:00', time()-86400*$days);
        $until = strftime('%Y-%m-%d 23:59:59', time());
        
        $sessionModel = new \Application\modules\core\models\sessionModel($this->app);
        $sessionInfo = $sessionModel->getInfo($from);
        $userAgents = $sessionModel->getUseragents($from);

        $this->app->view->content['nav_main'] = 'statistics';
        $this->app->view->content['title'] = $this->lang('title_admin_stats');
        $this->app->view->content['from']= $from;
        $this->app->view->content['until']= $until;
        $this->app->view->content['session_info'] = $sessionInfo;
        $this->app->view->content['user_agents'] = $userAgents;
        
    }
    
}
