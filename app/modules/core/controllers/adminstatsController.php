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
        $then = strftime('%Y-%m-%d 00:00:00', time()-86400*$days);
        
        $sessionModel = new \Application\modules\core\models\sessionModel($this->app);
        $sessionInfo = $sessionModel->getInfo($then);
        echo "Session Info<pre>\n";
        print_r($sessionInfo);
        echo "\nUser Agents:\n";
        $userAgents = $sessionModel->getUseragents($then);
        print_r($userAgents);
        die();
        
        
    }
    
}
