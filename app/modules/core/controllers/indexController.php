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
 * CORE Index Controller
 * 
 * Startpage and some static pages (imprint, legal stuff, ...)
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class indexController extends \Application\modules\core\controllers\Controller
{

    /**
     * The Startpage
     * 
     * Forwards to login screen or - if user is already logged in - to the wall
     */
    public function indexAction()
    {

        $this->app->view->content['nav_main'] = 'home';
        if ($this->app->session->user_id != 0) {
            $this->forward($this->buildURL('bbs/wall'));
        } else {
            $this->forward($this->buildURL('account/login'));
        }
        
    }

    /**
     * A static page
     */
    public function imprintAction()
    {

        $this->app->view->content['title'] = $this->lang('title_imprint');
        $this->app->view->content['nav_main'] = 'imprint';
        
    }

}

?>
