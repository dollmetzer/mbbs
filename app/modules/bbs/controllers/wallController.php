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
 * BBS Wall Controller
 * 
 * Methods for handling the public wall
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class wallController extends \dollmetzer\zzaplib\Controller
{
 
    protected $accessGroups = array(
        'index'  => array('user'),
        'new'    => array('user')
    );
    
    /**
     * The Startpage
     */
    public function indexAction()
    {
        
        $this->app->view->content['title'] = $this->lang('title_wall');
        $this->app->view->content['nav_main'] = 'home';
        
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $mailList = $mailModel->getMaillist('to', '!wall');
        $this->app->view->content['mails'] = $mailList;
        
    }
    
    /**
     * New entry
     */
    public function newAction() {
        
        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'mailform';
        $form->fields = array(
            'subject' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 80,
            ),
            'message' => array(
                'type' => 'textarea',
                'required' => true,
                'rows' => 8,
                'maxlength' => 4096,
            )
        );

        if ($form->process()) {

            $values = $form->getValues();
            
            $data = array(
                'from' => $this->app->session->user_handle,
                'to' => '!wall',
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message']
            );
            $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
            $mailId = $mailModel->create($data);

        }
        
        $this->app->forward($this->buildURL('bbs/wall' . $id), $this->lang('msg_post_sent'), 'message');
        
    }
    
}
