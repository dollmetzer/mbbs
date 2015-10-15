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
 * Base for all application controllers. 
 * Search for number of new mails to show in the navigation.
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class Controller extends \dollmetzer\zzaplib\Controller
{

    /**
     * Search for number of new mails to show in the navigation.
     */
    public function preAction()
    {

        $recipient                            = $this->app->session->user_handle.'@'.$this->app->config['core']['name'];
        $mailModel                            = new \Application\modules\bbs\models\mailModel($this->app);
        $newMails                             = $mailModel->getNewMailCount($recipient);
        $this->app->view->content['newMails'] = $mailModel->getNewMailCount($recipient);

        if ($this->app->config['core']['tracking']['session'] === true) {
            $this->app->session->track($this->app->moduleName.'/'.$this->app->controllerName.'/'.$this->app->actionName);
        }
    }
}