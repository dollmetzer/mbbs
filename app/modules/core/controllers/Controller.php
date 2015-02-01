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
 * CORE Controller
 * 
 * Base for all application controllers
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class Controller extends \dollmetzer\zzaplib\Controller {
    
    public function preAction() {
        
        $recipient = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $newMails = $mailModel->getNewMailCount($recipient);
        $this->app->view->content['newMails'] = $mailModel->getNewMailCount($recipient);
        
    }
    
}
