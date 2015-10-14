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
 * BBS Board Controller
 * 
 * Methods for Bulletion Board handling
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class boardController extends \Application\modules\core\controllers\Controller
{

    /**
     * @var array $accessGroups
     */
    protected $accessGroups = array(
        'index' => array('user', 'operator', 'administrator', 'moderator'),
        'list' => array('user', 'operator', 'administrator', 'moderator'),
        'read' => array('user', 'operator', 'administrator', 'moderator'),
        'new' => array('user', 'operator', 'administrator', 'moderator'),
        'reply' => array('user', 'operator', 'administrator', 'moderator')
    );


    /**
     * Show a list of boards
     */
    public function indexAction()
    {

        $id = 0;
        if (!empty($this->app->params)) {
            $id = (int) $this->app->params[0];
        }

        // Get Path and List of the Themes 
        $boardModel = new \Application\modules\bbs\models\boardModel($this->app);
        if (!empty($id)) {
            $board = $boardModel->read($id);
        } else {
            $board = array(
                'description' => $this->lang('txt_default_board_description')
            );
        }

        $path = $boardModel->getPath($id);
        $themes = $boardModel->getList($id, true);

        if ($id != 0) {
            
            // Get Messages for the current Theme
            $theme = $boardModel->read($id);
            $username = '#' . $theme['name'];
            $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
            
            // pagination
            $listEntries = $mailModel->getMaillistEntries('to', $username);
            $listLength = 10;
            $page = 0;
            if(sizeof($this->app->params)>1) {
                $page = (int)$this->app->params[1]-1;
            }
            $maxPages = ceil($listEntries / $listLength);
            $firstEntry = $page * $listLength;

            $mailList = $mailModel->getMaillist('to', $username, false, $firstEntry, $listLength);
            
        } else {
            $theme = array();
            $mailList = array();
        }

        if (empty($board['name'])) {
            $this->app->view->content['title'] = $this->lang('title_board_top');
        } else {
            $this->app->view->content['title'] = sprintf($this->lang('title_board'), $board['name']);
        }
        $this->app->view->template = 'modules/bbs/views/web/board/index.php';
        $this->app->view->content['nav_main'] = 'board';
        $this->app->view->content['board'] = $board;
        $this->app->view->content['id'] = $id;
        $this->app->view->content['path'] = $path;
        $this->app->view->content['themes'] = $themes;
        $this->app->view->content['mails'] = $mailList;
        $this->app->view->content['pagination_page'] = $page;
        $this->app->view->content['pagination_maxpages'] = $maxPages;
        $this->app->view->content['pagination_link'] = $this->buildURL('bbs/board/list/'.$id.'/%d');

    }


    /**
     * Show a list of boards (alias of index)
     * 
     * @return type
     */
    public function listAction()
    {
        return $this->indexAction();
    }


    /**
     * Show a single mail
     */
    public function readAction()
    {

        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        // Get Messages for the current Theme
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        //$username = '#' . $theme['name'];
        $mail = $mailModel->read($id);

        if (empty($mail)) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_data_not_found'), 'error');
        }

        $this->app->view->content['title'] = $this->lang('title_board_read');
        $this->app->view->content['nav_main'] = 'board';
        $this->app->view->content['mail'] = $mail;
    }


    /**
     * Create a new mail
     */
    public function newAction()
    {

        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        $boardModel = new \Application\modules\bbs\models\boardModel($this->app);
        $board = $boardModel->read($id);
        if (empty($board)) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_illegal_parameter'), 'error');
        }
        if (empty($board['content'])) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_not_allowed'), 'error');
        }

        $path = $boardModel->getPath($id);
        $boardPath = 'main';
        foreach ($path as $step) {
            $boardPath .= ' / ' . $step['name'];
        }

        $to = '#' . $board['name'];

        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'mailform';
        $form->fields = array(
            'board' => array(
                'type' => 'static',
                'value' => $boardPath . '<br />' . $board['description']
            ),
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
            ),
            /**
            'picture' => array(
                'type' => 'file',
                'mimetype' => 'image/jpeg',
                'maxsize' => ini_get('upload_max_filesize'),
                'targetdir' => PATH_DATA.'board/'.$id
            ),
             */
            'submit' => array(
                'type' => 'submit',
                'value' => 'send'
            ),
        );

        if ($form->process()) {

            $values = $form->getValues();
            $from = $this->app->session->user_handle . '@' . $this->app->config['core']['name'];

            $data = array(
                'from' => $from,
                'to' => $to,
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message']
            );
            $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
            $mailId = $mailModel->create($data);
            
            if(!empty($_FILES['picture']['type'])) {
                $this->processPicture($_FILES['picture'], $mailId);
            }
            


            $this->app->forward($this->buildURL('bbs/board/list/' . $id), $this->lang('msg_post_sent'), 'message');
        }

        $this->app->view->content['title'] = $this->lang('title_board_write');
        $this->app->view->content['nav_main'] = 'board';
        $this->app->view->content['form'] = $form->getViewdata();
    }


    /**
     * reply to a mail
     */
    public function replyAction()
    {

        // check if mail id exists
        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        // Get Messages for the current Theme
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        //$username = '#' . $theme['name'];
        $mail = $mailModel->read($id);

        // get board ID
        $to = preg_replace('/^#/', '', $mail['to']);
        $boardModel = new \Application\modules\bbs\models\boardModel($this->app);
        $board = $boardModel->getByName($to);

        $message = sprintf($this->lang('txt_reply_header'), $mail['from'], $mail['written']) . $mail['message'];

        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'mailform';
        $form->action = $this->buildURL('bbs/board/new/' . $board['id']);
        $form->fields = array(
            'subject' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 80,
                'value' => 'RE: ' . $mail['subject']
            ),
            'message' => array(
                'type' => 'textarea',
                'required' => true,
                'maxlength' => 4096,
                'rows' => 8,
                'value' => $message
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => $this->lang('link_send')
            ),
        );

        if ($form->process()) {

            // get user
            $values = $form->getValues();
            $from = $this->app->session->user_handle . '@' . $this->app->config['core']['name'];

            $data = array(
                'from' => $from,
                'to' => '#' . $to,
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message']
            );
            $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
            $mailId = $mailModel->create($data);

            $this->app->forward($this->buildURL('bbs/board/list/' . $board['id']), $this->lang('msg_post_sent'), 'message');
        }
        $this->app->view->template = 'modules/bbs/views/web/board/new.php';
        $this->app->view->content['form'] = $form->getViewdata();
        $this->app->view->content['title'] = $this->lang('title_board_reply');
        $this->app->view->content['nav_main'] = 'board';
    }

    
    protected function processPicture($_files, $_id) {
        
        // error_log("process picture $_id" . print_r($_files, true));
        
        echo "<pre>";
        print_r($_files);
        die("Save to ".$targetFile);
        
// check type
        if(!in_array($_files['type'], array('image/jpeg'))) {
            return 1;
        }
        
        // check size
        
        // check error
        
        // check ist upload
        $targetFile = PATH_DATA.'picture/mail/';
        if(!is_dir($targetFile)) {
            mkdir($targetFile);
            chmod($targetFile, 0775);
        }
        $temp = explode('.', $_files['name']);
        $targetFile .= $_id . '.' . array_pop($temp);
        if(!move_uploaded_file($_files['tmp_name'], $targetFile)) {
            return 4;
        }
        
        echo "<pre>";
        print_r($_files);
        die("Save to ".$targetFile);
    }
    
}

?>
