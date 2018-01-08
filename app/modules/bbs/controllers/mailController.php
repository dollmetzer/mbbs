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

        $this->app->view->content['title']    = $this->lang('title_mail_in');
        $this->app->view->content['nav_main'] = 'mail';

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username  = $this->app->session->user_handle.'@'.$this->app->config['core']['name'];

        // pagination
        $listEntries = $mailModel->getMaillistEntries('to', $username);
        $listLength  = 10;
        $page        = 0;
        if (sizeof($this->app->params) > 0) {
            $page = (int) $this->app->params[0] - 1;
        }
        $maxPages   = ceil($listEntries / $listLength);
        $firstEntry = $page * $listLength;

        $mailList = $mailModel->getMaillist('to', $username, false, $firstEntry,
            $listLength);

        $pictureModel = new \Application\modules\bbs\models\pictureModel($this->app);
        for ($i = 0; $i < sizeof($mailList); $i++) {
            $mailList[$i]['picture'] = $pictureModel->hasPicture('mail',
                $mailList[$i]['mid']);
        }

        $this->app->view->content['mails']               = $mailList;
        $this->app->view->content['pagination_page']     = $page;
        $this->app->view->content['pagination_maxpages'] = $maxPages;
        $this->app->view->content['pagination_link']     = $this->buildURL('bbs/mail/in/%d');
    }

    /**
     * Show the Mail Outbox
     */
    public function outAction()
    {

        $this->app->view->content['title']    = $this->lang('title_mail_out');
        $this->app->view->content['nav_main'] = 'mail';

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username  = $this->app->session->user_handle.'@'.$this->app->config['core']['name'];

        // pagination
        $listEntries = $mailModel->getMaillistEntries('from', $username, true);
        $listLength  = 10;
        $page        = 0;
        if (sizeof($this->app->params) > 0) {
            $page = (int) $this->app->params[0] - 1;
        }
        $maxPages   = ceil($listEntries / $listLength);
        $firstEntry = $page * $listLength;

        $mailList = $mailModel->getMaillist('from', $username, true,
            $firstEntry, $listLength);

        $pictureModel = new \Application\modules\bbs\models\pictureModel($this->app);
        for ($i = 0; $i < sizeof($mailList); $i++) {
            $mailList[$i]['picture'] = $pictureModel->hasPicture('mail',
                $mailList[$i]['mid']);
        }

        $this->app->view->content['mails']               = $mailList;
        $this->app->view->content['pagination_page']     = $page;
        $this->app->view->content['pagination_maxpages'] = $maxPages;
        $this->app->view->content['pagination_link']     = $this->buildURL('bbs/mail/out/%d');
    }

    /**
     * Show a single mail
     */
    public function readAction()
    {
        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username  = $this->app->session->user_handle.'@'.$this->app->config['core']['name'];
        $mail      = $mailModel->read($id);

        if (empty($mail)) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_data_not_found'), 'error');
        }
        if ((strtolower($mail['to']) != strtolower($username) ) && (strtolower($mail['from'])
            != strtolower($username))) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }

        if ($mail['read'] == '0000-00-00 00:00:00') {
            $mailModel->markRead($mail['id']);
        }

        if (strtolower($mail['from']) == strtolower($username)) {
            $this->app->view->content['title'] = $this->lang('title_mail_read_outgoing');
        } else {
            $this->app->view->content['title'] = $this->lang('title_mail_read_incoming');
        }

        $this->app->view->content['nav_main'] = 'mail';
        $this->app->view->content['username'] = $username;
        $this->app->view->content['mail']     = $mail;
        $pictureModel                         = new \Application\modules\bbs\models\pictureModel($this->app);
        $this->app->view->content['picture']  = $pictureModel->hasPicture('mail',
            $mail['mid']);
    }

    /**
     * Input form for a new mail
     */
    public function newAction()
    {

        $receiver = '';
        if (sizeof($this->app->params) > 0) {
            // try to determine receiver
            $userModel = new \Application\modules\core\models\userModel($this->app);
            $user      = $userModel->getByHandle($this->app->params[0]);
            if (!empty($user)) {
                $receiver = $user['handle'];
            }
        }

        $form         = new \dollmetzer\zzaplib\Form($this->app);
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

            $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
            $from      = $this->app->session->user_handle.'@'.$this->app->config['core']['name'];
            $to        = $values['to'];
            if (strpos($to, '@') === false) {
                $to .= '@'.$this->app->config['core']['name'];
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
                $pictureModel = new \Application\modules\bbs\models\pictureModel($this->app);
                $pictureModel->saveEncodedPicture('mail', $mail['mid'], $values['image']);
            }

            $this->app->forward($this->buildURL('bbs/mail/out'),
                $this->lang('msg_mail_sent'), 'message');
        }
        $this->app->view->content['form']     = $form->getViewdata();
        $this->app->view->content['title']    = $this->lang('title_mail_new');
        $this->app->view->content['nav_main'] = 'mail';
    }

    /**
     * Delete a mail
     */
    public function deleteAction()
    {

        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        // test, if mail is available and owned by the user
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username  = $this->app->session->user_handle.'@'.$this->app->config['core']['name'];
        $mail      = $mailModel->read($id);
        if (empty($mail)) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_data_not_found'), 'error');
        }
        if (strtolower($mail['to']) != strtolower($username)) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }

        $mailModel->delete($id);

        $this->app->forward($this->buildURL('bbs/mail'),
            $this->lang('msg_mail_deleted'), 'message');
    }

    /**
     * Write a reply mail
     */
    public function replyAction()
    {

        // check if mail id exists
        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        // test, if mail is available and owned by the user
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username  = $this->app->session->user_handle.'@'.$this->app->config['core']['name'];
        $mail      = $mailModel->read($id);

        if (empty($mail)) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_data_not_found'), 'error');
        }
        if (strtolower($mail['to']) != strtolower($username)) {
            $this->app->forward($this->buildURL('/bbs/mail'),
                $this->lang('error_access_denied'), 'error');
        }

        $message = sprintf($this->lang('txt_reply_header'), $mail['from'],
                $mail['written']).$mail['message'];

        $form         = new \dollmetzer\zzaplib\Form($this->app);
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

            $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
            $from      = $this->app->session->user_handle.'@'.$this->app->config['core']['name'];
            $to        = $values['to'];
            if (strpos($to, '@') === false) {
                $to .= '@'.$this->app->config['core']['name'];
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
            $this->app->forward($this->buildURL('bbs/mail/out'),
                $this->lang('msg_mail_sent'), 'message');
        }
        $this->app->view->template            = 'modules/bbs/views/frontend/mail/new.php';
        $this->app->view->content['form']     = $form->getViewdata();
        $this->app->view->content['title']    = $this->lang('title_mail_reply');
        $this->app->view->content['nav_main'] = 'mail';
    }

    /**
     * returns an image for a given wall entry - or a 404 error
     */
    public function imgAction()
    {

        if (empty($this->app->params)) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
        $id = (int) $this->app->params[0];

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $mail      = $mailModel->read($id);
        if (empty($mail)) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        $pictureModel = new \Application\modules\bbs\models\pictureModel($this->app);
        $pictureModel->download('mail', $mail['mid']);
    }
}
?>
