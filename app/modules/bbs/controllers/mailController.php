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
 * BBS Mail Controller
 * 
 * Methods for Mail handling
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class mailController extends \Application\modules\core\controllers\Controller
{
    protected $accessGroups = array(
        'in' => array('user', 'operator', 'administrator', 'moderator'),
        'out' => array('user', 'operator', 'administrator', 'moderator'),
        'read' => array('user', 'operator', 'administrator', 'moderator'),
        'new' => array('user', 'operator', 'administrator', 'moderator'),
        'reply' => array('user', 'operator', 'administrator', 'moderator'),
        'delete' => array('user', 'operator', 'administrator', 'moderator'),
        'img' => array('user', 'operator', 'administrator', 'moderator')
    );

    /**
     * Show the Mail Inbox
     */
    public function inAction()
    {

        $this->view->content['title']    = $this->lang('title_mail_in');
        $this->view->content['nav_main'] = 'mail';

        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        $username  = $this->session->user_handle.'@'.$this->config['name'];

        // pagination
        $listEntries = $mailModel->getMaillistEntries('to', $username);
        $listLength  = 10;
        $page        = 0;
        if (sizeof($this->request->params) > 0) {
            $page = (int) $this->request->params[0] - 1;
        }
        $maxPages   = ceil($listEntries / $listLength);
        $firstEntry = $page * $listLength;

        $mailList = $mailModel->getMaillist('to', $username, false, $firstEntry,
            $listLength);

        $pictureModel = new \Application\modules\bbs\models\pictureModel($this->config);
        for ($i = 0; $i < sizeof($mailList); $i++) {
            $mailList[$i]['picture'] = $pictureModel->hasPicture('mail',
                $mailList[$i]['mid']);
        }

        $this->view->content['mails']               = $mailList;
        $this->view->content['pagination_page']     = $page;
        $this->view->content['pagination_maxpages'] = $maxPages;
        $this->view->content['pagination_link']     = $this->buildURL('bbs/mail/in/%d');
    }

    /**
     * Show the Mail Outbox
     */
    public function outAction()
    {

        $this->view->content['title']    = $this->lang('title_mail_out');
        $this->view->content['nav_main'] = 'mail';

        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        $username  = $this->session->user_handle.'@'.$this->config['name'];

        // pagination
        $listEntries = $mailModel->getMaillistEntries('from', $username, true);
        $listLength  = 10;
        $page        = 0;
        if (sizeof($this->request->params) > 0) {
            $page = (int) $this->request->params[0] - 1;
        }
        $maxPages   = ceil($listEntries / $listLength);
        $firstEntry = $page * $listLength;

        $mailList = $mailModel->getMaillist('from', $username, true,
            $firstEntry, $listLength);

        $pictureModel = new \Application\modules\bbs\models\pictureModel($this->config);
        for ($i = 0; $i < sizeof($mailList); $i++) {
            $mailList[$i]['picture'] = $pictureModel->hasPicture('mail',
                $mailList[$i]['mid']);
        }

        $this->view->content['mails']               = $mailList;
        $this->view->content['pagination_page']     = $page;
        $this->view->content['pagination_maxpages'] = $maxPages;
        $this->view->content['pagination_link']     = $this->buildURL('bbs/mail/out/%d');
    }

    /**
     * Show a single mail
     */
    public function readAction()
    {
        if (empty($this->request->params)) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->request->params[0];

        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        $username  = $this->session->user_handle.'@'.$this->config['name'];
        $mail      = $mailModel->read($id);

        if (empty($mail)) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_data_not_found'), 'error');
        }
        if ((strtolower($mail['to']) != strtolower($username) ) && (strtolower($mail['from'])
            != strtolower($username))) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }

        if (!$mail['read']) {
            $mailModel->markRead($mail['id']);
        }

        if (strtolower($mail['from']) == strtolower($username)) {
            $this->view->content['title'] = $this->lang('title_mail_read_outgoing');
        } else {
            $this->view->content['title'] = $this->lang('title_mail_read_incoming');
        }

        $this->view->content['nav_main'] = 'mail';
        $this->view->content['username'] = $username;
        $this->view->content['mail']     = $mail;
        $pictureModel                         = new \Application\modules\bbs\models\pictureModel($this->config);
        $this->view->content['picture']  = $pictureModel->hasPicture('mail',
            $mail['mid']);
    }

    /**
     * Input form for a new mail
     */
    public function newAction()
    {

        $receiver = '';
        if (sizeof($this->request->params) > 0) {
            // try to determine receiver
            $userModel = new \Application\modules\core\models\userModel($this->config);
            $user      = $userModel->getByHandle($this->request->params[0]);
            if (!empty($user)) {
                $receiver = $user['handle'];
            }
        }

        $form         = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name   = 'mailform';
        $form->fields = array(
            'image' => array(
                'type' => 'hidden'
            ),
            'to' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
                'value' => $receiver
            ),
            'subject' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 80,
            ),
            'message' => array(
                'type' => 'textarea',
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
        if (!empty($receiver)) {
            $form->fields['subject']['focus'] = true;
        }

        if ($form->process()) {

            // get user
            $values = $form->getValues();

            $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
            $from      = $this->session->user_handle.'@'.$this->config['name'];
            $to        = $values['to'];
            if (strpos($to, '@') === false) {
                $to .= '@'.$this->config['name'];
            }
            $data = array(
                'from' => $from,
                'to' => $to,
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message']
            );
            $id   = $mailModel->create($data);

            if (!empty($values['image'])) {
                $mail         = $mailModel->read($id);
                $pictureModel = new \Application\modules\bbs\models\pictureModel($this->config);
                $pictureModel->saveEncodedPicture('mail', $mail['mid'], $values['image']);
            }

            $this->forward($this->buildURL('bbs/mail/out'),
                $this->lang('msg_mail_sent'), 'message');
        }
        $this->view->content['form']     = $form->getViewdata();
        $this->view->content['title']    = $this->lang('title_mail_new');
        $this->view->content['nav_main'] = 'mail';
    }

    /**
     * Delete a mail
     */
    public function deleteAction()
    {

        if (empty($this->request->params)) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->request->params[0];

        // test, if mail is available and owned by the user
        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        $username  = $this->session->user_handle.'@'.$this->config['name'];
        $mail      = $mailModel->read($id);
        if (empty($mail)) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_data_not_found'), 'error');
        }
        if (strtolower($mail['to']) != strtolower($username)) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }

        $mailModel->delete($id);

        $this->forward($this->buildURL('bbs/mail'),
            $this->lang('msg_mail_deleted'), 'message');
    }

    /**
     * Write a reply mail
     */
    public function replyAction()
    {

        // check if mail id exists
        if (empty($this->request->params)) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->request->params[0];

        // test, if mail is available and owned by the user
        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        $username  = $this->session->user_handle.'@'.$this->config['name'];
        $mail      = $mailModel->read($id);

        if (empty($mail)) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_data_not_found'), 'error');
        }
        if (strtolower($mail['to']) != strtolower($username)) {
            $this->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }

        $message = sprintf($this->lang('txt_reply_header'), $mail['from'],
                $mail['written']).$mail['message'];

        $form         = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name   = 'mailform';
        $form->action = "";
        $form->fields = array(
            'to' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
                'value' => $mail['from']
            ),
            'subject' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 80,
                'value' => 'RE: '.$mail['subject']
            ),
            'message' => array(
                'type' => 'textarea',
                'maxlength' => 4096,
                'rows' => 8,
                'value' => $message
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => 'send'
            ),
        );

        if ($form->process()) {

            // get user
            $values = $form->getValues();

            $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
            $from      = $this->session->user_handle.'@'.$this->config['name'];
            $to        = $values['to'];
            if (strpos($to, '@') === false) {
                $to .= '@'.$this->config['name'];
            }
            $data = array(
                'from' => $from,
                'to' => $to,
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message'],
                'parent_mid' => $mail['mid'],
                'origin_mid' => $mail['origin_mid']
            );

            $id = $mailModel->create($data);
            $this->forward($this->buildURL('bbs/mail/out'),
                $this->lang('msg_mail_sent'), 'message');
        }
        $this->view->template            = 'modules/bbs/views/frontend/mail/new.php';
        $this->view->content['form']     = $form->getViewdata();
        $this->view->content['title']    = $this->lang('title_mail_reply');
        $this->view->content['nav_main'] = 'mail';
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
        $pictureModel->download('mail', $mail['mid']);
    }
}
?>
