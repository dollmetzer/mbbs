<?php

/**
 * BBS - Bulletin Board System
 * 
 * A small BBS package for mobile use
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
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
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class wallController extends \Application\modules\core\controllers\Controller
{

    protected $accessGroups = array(
        'index' => array('user', 'operator', 'administrator', 'moderator'),
        'new' => array('user', 'operator', 'administrator', 'moderator'),
        'read' => array('user', 'operator', 'administrator', 'moderator')
    );


    /**
     * The Startpage
     */
    public function indexAction()
    {

        $this->app->view->content['title'] = $this->lang('title_wall');
        $this->app->view->content['nav_main'] = 'wall';

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        
        // pagination
        $listEntries = $mailModel->getMaillistEntries('to', '!wall');
        $listLength = 10;
        $page = 0;
        if(sizeof($this->app->params)>0) {
            $page = (int)$this->app->params[0]-1;
        }
        $maxPages = ceil($listEntries / $listLength);
        $firstEntry = $page * $listLength;
        
        $mailList = $mailModel->getMaillist('to', '!wall', false, $firstEntry, $listLength);
        
        $this->app->view->content['mails'] = $mailList;
        $this->app->view->content['pagination_page'] = $page;
        $this->app->view->content['pagination_maxpages'] = $maxPages;
        $this->app->view->content['pagination_link'] = $this->buildURL('bbs/wall/index/%d');

    }


    /**
     * Show a single mail
     */
    public function readAction()
    {
        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/wall'), $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
        $mail = $mailModel->read($id);

        if (empty($mail)) {
            $this->app->forward($this->buildURL('/bbs/wall'), $this->lang('error_data_not_found'), 'error');
        }

        if ($mail['read'] == '0000-00-00 00:00:00') {
            $mailModel->markRead($mail['id']);
        }

        $this->app->view->content['title'] = $this->lang('title_mail_read');
        $this->app->view->content['nav_main'] = 'wall';
        $this->app->view->content['mail'] = $mail;
    }


    /**
     * New entry
     */
    public function newAction()
    {

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

        $this->app->view->content['nav_main'] = 'wall';
        $this->app->forward($this->buildURL('bbs/wall'), $this->lang('msg_post_sent'), 'message');
    }

}
