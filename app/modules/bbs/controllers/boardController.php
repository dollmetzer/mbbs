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
        'reply' => array('user', 'operator', 'administrator', 'moderator'),
        'img' => array('user', 'operator', 'administrator', 'moderator')
    );

    /**
     * Show a list of boards
     */
    public function indexAction()
    {

        $id = 0;
        if (!empty($this->request->params)) {
            $id = (int) $this->request->params[0];
        }

        // Get Path and List of the Themes 
        $boardModel = new \Application\modules\bbs\models\boardModel($this->config);
        if (!empty($id)) {
            $board = $boardModel->read($id);
        } else {
            $board = array(
                'description' => $this->lang('txt_default_board_description')
            );
        }

        $path   = $boardModel->getPath($id);
        $themes = $boardModel->getList($id, true);

        if ($id != 0) {

            // Get Messages for the current Theme
            $theme     = $boardModel->read($id);
            $username  = '#'.$theme['name'];
            $mailModel = new \Application\modules\bbs\models\mailModel($this->config);

            // pagination
            $listEntries = $mailModel->getMaillistEntries('to', $username);
            $listLength  = 10;
            $page        = 0;
            if (sizeof($this->request->params) > 1) {
                $page = (int) $this->request->params[1] - 1;
            }
            $maxPages   = ceil($listEntries / $listLength);
            $firstEntry = $page * $listLength;

            $mailList = $mailModel->getMaillist('to', $username, false, $firstEntry, $listLength);

            $pictureModel = new \Application\modules\bbs\models\pictureModel($this->config);
            for ($i = 0; $i < sizeof($mailList); $i++) {
                $mailList[$i]['picture'] = $pictureModel->hasPicture('board', $mailList[$i]['mid']);
            }

        } else {
            $theme    = array();
            $mailList = array();
        }

        if (empty($board['name'])) {
            $this->view->content['title'] = $this->lang('title_board_top');
        } else {
            $this->view->content['title'] = sprintf($this->lang('title_board'),
                $board['name']);
        }
        $this->view->template                       = 'modules/bbs/views/frontend/board/index.php';
        $this->view->content['nav_main']            = 'board';
        $this->view->content['board']               = $board;
        $this->view->content['id']                  = $id;
        $this->view->content['path']                = $path;
        $this->view->content['themes']              = $themes;
        $this->view->content['mails']               = $mailList;
        $this->view->content['pagination_page']     = $page;
        $this->view->content['pagination_maxpages'] = $maxPages;
        $this->view->content['pagination_link']     = $this->buildURL('bbs/board/list/'.$id.'/%d');
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

        if (empty($this->request->params)) {
            $this->forward($this->buildURL('/bbs/board'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->request->params[0];

        // Get Messages for the current Theme
        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        //$username = '#' . $theme['name'];
        $mail      = $mailModel->read($id);

        if (empty($mail)) {
            $this->forward($this->buildURL('/bbs/board'),
                $this->lang('error_data_not_found'), 'error');
        }

        $this->view->content['title']    = $this->lang('title_board_read');
        $this->view->content['nav_main'] = 'board';
        $this->view->content['mail']     = $mail;
        $pictureModel                    = new \Application\modules\bbs\models\pictureModel($this->config);
        $this->view->content['picture']  = $pictureModel->hasPicture('board', $mail['mid']);
    }

    /**
     * Create a new mail
     */
    public function newAction()
    {

        if (empty($this->request->params)) {
            $this->forward($this->buildURL('/bbs/board'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->request->params[0];

        $boardModel = new \Application\modules\bbs\models\boardModel($this->config);
        $board      = $boardModel->read($id);
        if (empty($board)) {
            $this->forward($this->buildURL('/bbs/board'),
                $this->lang('error_illegal_parameter'), 'error');
        }
        if (empty($board['content'])) {
            $this->forward($this->buildURL('/bbs/board'),
                $this->lang('error_not_allowed'), 'error');
        }

        $path      = $boardModel->getPath($id);
        $boardPath = 'main';
        foreach ($path as $step) {
            $boardPath .= ' / '.$step['name'];
        }

        $to = '#'.$board['name'];

        $form         = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name   = 'boardentryform';
        $form->fields = array(
            'image' => array(
                'type' => 'hidden'
            ),
            'board' => array(
                'type' => 'static',
                'value' => $boardPath.'<br />'.$board['description']
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
            'picture' => array(
                'type' => 'file',
                'accept' => 'image/*',
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => 'send'
            ),
        );

        if ($form->process()) {

            $values = $form->getValues();
            $from   = $this->session->user_handle.'@'.$this->config['name'];

            $data      = array(
                'from' => $from,
                'to' => $to,
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message']
            );
            $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
            $mailId    = $mailModel->create($data);

            if (!empty($values['image'])) {
                $mail         = $mailModel->read($mailId);
                $pictureModel = new \Application\modules\bbs\models\pictureModel($this->config);
                $pictureModel->saveEncodedPicture('board', $mail['mid'], $values['image']);
            }

            $this->forward($this->buildURL('bbs/board/list/'.$id),
                $this->lang('msg_post_sent'), 'message');
        }

        $this->view->content['title']    = $this->lang('title_board_write');
        $this->view->content['nav_main'] = 'board';
        $this->view->content['form']     = $form->getViewdata();
    }

    /**
     * reply to a mail
     */
    public function replyAction()
    {

        // check if mail id exists
        if (empty($this->request->params)) {
            $this->forward($this->buildURL('/bbs/board'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->request->params[0];

        // Get Messages for the current Theme
        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        //$username = '#' . $theme['name'];
        $mail      = $mailModel->read($id);

        // get board ID
        $to         = preg_replace('/^#/', '', $mail['to']);
        $boardModel = new \Application\modules\bbs\models\boardModel($this->config);
        $board      = $boardModel->getByName($to);

        $message = sprintf($this->lang('txt_reply_header'), $mail['from'],
                $mail['written']).$mail['message'];

        $form         = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name   = 'mailform';
        $form->action = $this->buildURL('bbs/board/new/'.$board['id']);
        $form->fields = array(
            'subject' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 80,
                'value' => 'RE: '.$mail['subject']
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
            $from   = $this->session->user_handle.'@'.$this->config['name'];

            $data      = array(
                'from' => $from,
                'to' => '#'.$to,
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message']
            );
            $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
            $mailId    = $mailModel->create($data);

            $this->forward($this->buildURL('bbs/board/list/'.$board['id']),
                $this->lang('msg_post_sent'), 'message');
        }
        $this->view->template            = 'modules/bbs/views/frontend/board/new.php';
        $this->view->content['form']     = $form->getViewdata();
        $this->view->content['title']    = $this->lang('title_board_reply');
        $this->view->content['nav_main'] = 'board';
    }

    protected function processPicture($_files, $_id)
    {

        // error_log("process picture $_id" . print_r($_files, true));

        echo "<pre>";
        print_r($_files);
        die("Save to ".$targetFile);

// check type
        if (!in_array($_files['type'], array('image/jpeg'))) {
            return 1;
        }

        // check size
        // check error
        // check ist upload
        $targetFile = PATH_DATA.'picture/mail/';
        if (!is_dir($targetFile)) {
            mkdir($targetFile);
            chmod($targetFile, 0775);
        }
        $temp = explode('.', $_files['name']);
        $targetFile .= $_id.'.'.array_pop($temp);
        if (!move_uploaded_file($_files['tmp_name'], $targetFile)) {
            return 4;
        }

        echo "<pre>";
        print_r($_files);
        die("Save to ".$targetFile);
    }

    /**
     * returns an image for a given wall entry - or a 404 error
     */
    public function imgAction()
    {

        if (empty($this->request->params)) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
        $id = (int) $this->request->params[0];

        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        $mail      = $mailModel->read($id);
        if (empty($mail)) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        $pictureModel = new \Application\modules\bbs\models\pictureModel($this->config);
        $pictureModel->download('board', $mail['mid']);
    }

}
?>
