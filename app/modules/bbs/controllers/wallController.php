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
        'read' => array('user', 'operator', 'administrator', 'moderator'),
        'img' => array('user', 'operator', 'administrator', 'moderator'),
    );

    /**
     * The Startpage
     */
    public function indexAction()
    {

        $this->view->content['title']    = $this->lang('title_wall');
        $this->view->content['nav_main'] = 'wall';

        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);

        // TODO: Pagination via Table object!!!

        // pagination (not working)
        $listEntries = $mailModel->getMaillistEntries('to', '!wall');
        $listLength  = 10;
        $page        = 0;
        if (sizeof($this->request->params) > 0) {
            $page = (int) $this->request->params[0] - 1;
        }
        $maxPages   = ceil($listEntries / $listLength);
        $firstEntry = $page * $listLength;

        $mailList = $mailModel->getMaillist('to', '!wall', false, $firstEntry,
            $listLength);

        $pictureModel = new \Application\modules\bbs\models\pictureModel($this->config);
        for ($i = 0; $i < sizeof($mailList); $i++) {
            $mailList[$i]['picture'] = $pictureModel->hasPicture('wall',
                $mailList[$i]['mid']);
        }

        $this->view->content['mails']               = $mailList;
        $this->view->content['pagination_page']     = $page;
        $this->view->content['pagination_maxpages'] = $maxPages;
        $this->view->content['pagination_link']     = $this->buildURL('bbs/wall/index/%d');
    }

    /**
     * Show a single mail
     */
    public function readAction()
    {
        if (empty($this->request->params)) {
            $this->forward($this->buildURL('/bbs/wall'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->request->params[0];

        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        $username  = $this->session->user_handle.'@'.$this->config['name'];
        $mail      = $mailModel->read($id);

        if (empty($mail)) {
            $this->forward($this->buildURL('/bbs/wall'),
                $this->lang('error_data_not_found'), 'error');
        }

        if (!$mail['read']) {
            $mailModel->markRead($mail['id']);
        }

        $this->view->content['title']    = $this->lang('title_mail_read');
        $this->view->content['nav_main'] = 'wall';
        $this->view->content['mail']     = $mail;
        $pictureModel                         = new \Application\modules\bbs\models\pictureModel($this->config);
        $this->view->content['picture']  = $pictureModel->hasPicture('wall',
            $mail['mid']);
    }

    /**
     * New entry
     */
    public function newAction()
    {

        $form         = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name   = 'mailform';
        $form->fields = array(
            'image' => array(
                'type' => 'hidden'
            ),
            'subject' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 80,
            ),
            'message' => array(
                'type' => 'textarea',
                //'required' => true,
                'rows' => 8,
                'maxlength' => 4096,
            )
        );

        $this->view->content['nav_main'] = 'wall';

        if ($form->process()) {

            $values = $form->getValues();
            $data      = array(
                'mid' => $this->config['name'].'_board_'.time(),
                'from' => $this->session->user_handle,
                'to' => '!wall',
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message']
            );
            $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
            $mailId    = $mailModel->create($data);

            // Process File upload
            if (!empty($values['image'])) {
                $mail         = $mailModel->read($mailId);
                $pictureModel = new \Application\modules\bbs\models\pictureModel($this->config);
                $pictureModel->saveEncodedPicture('wall', $mail['mid'],
                    $values['image']);
            }
        }

        $this->forward($this->buildURL('bbs/wall'),
            $this->lang('msg_post_sent'), 'message');
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
        $pictureModel->download('wall', $mail['mid']);

    }
}