<?php

/**
 * BBS - Bulletin Board System
 * 
 * A small BBS package for mobile use
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */

namespace Application\modules\bbs\controllers;

/**
 * BBS Mail Controller
 * 
 * Methods for handling data exchange
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class operationController extends \dollmetzer\zzaplib\Controller
{

    /**
     * @var array $accessGroups
     */
    protected $accessGroups = array(
        'export' => array('operator'),
        'import' => array('operator')
    );

    public function exportAction()
    {

        $this->app->view->content['title'] = $this->lang('title_export');
        $this->app->view->content['nav_main'] = 'board';
    }

    public function importAction()
    {

        $this->app->view->content['title'] = $this->lang('title_import');
        $this->app->view->content['nav_main'] = 'board';
    }

}
