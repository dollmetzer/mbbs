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

    
    /**
     * Show a page for selecting export files
     */
    public function exportAction()
    {

        $hostModel = new \Application\modules\bbs\models\hostModel($this->app);
        $list = $hostModel->getList();

        $this->app->view->content['title'] = $this->lang('title_export');
        $this->app->view->content['nav_main'] = 'board';
        $this->app->view->content['list'] = $list;
    }


    public function importAction()
    {

        if(!empty($_FILES['mails'])) {
            
            // check filename
            $temp = explode('_', $_FILES['mails']['name']);
            if(sizeof($temp) != 4) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_illegal_filename'), 'error');
            }
            
            // check source and target system
            
            
            print_r($_FILES);
            print_r($temp);
            
            exit;
        }
        $this->app->view->content['title'] = $this->lang('title_import');
        $this->app->view->content['nav_main'] = 'board';
    }

    
    /**
     * Create an export file for the message transfer to another host
     */
    public function exportfileAction()
    {
        
        if(sizeof($this->app->params) < 1) {
            $this->forward($this->buildURL('bbs/operation/export'), $this->lang('error_missing_parameter'), 'error');
        }
        
        // find host
        $id = (int)$this->app->params[0];
        $hostModel = new \Application\modules\bbs\models\hostModel($this->app);
        $host = $hostModel->read($id);
        if(empty($host)) {
            $this->forward($this->buildURL('bbs/operation/export'), $this->lang('error_illegal_parameter'), 'error');
        }
        
        // fetch messages
        $now = time();
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $exportMails = $mailModel->collectExport($host['name'], $host['lastexport']);
        
        $content = array(
            'fromHost' => $this->app->config['systemname'],
            'toHost' => $host['name'],
            'exportDate' => strftime('%Y-%m-%d %H:%M:%S'),
            'mails' => $exportMails
        );
        
        // send response
        $filename = $host['name'].'_'.$this->app->config['systemname'].strftime('_%Y%m%d_%H%M%S.json');
        $json = json_encode($content);
        
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Content-Length: '.strlen($json));
        echo $json;
        exit;
        
        // todo: mark last export in DB
        
    }

}
