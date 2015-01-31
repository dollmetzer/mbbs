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
 * Methods for Mail handling
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class mailController extends \dollmetzer\zzaplib\Controller
{

    protected $accessGroups = array(
        'in' => array('user', 'operator', 'administrator', 'moderator'),
        'out' => array('user', 'operator', 'administrator', 'moderator'),
        'read' => array('user', 'operator', 'administrator', 'moderator'),
        'new' => array('user', 'operator', 'administrator', 'moderator'),
        'reply' => array('user', 'operator', 'administrator', 'moderator'),
        'delete' => array('user', 'operator', 'administrator', 'moderator')
    );

    /**
     * Show the Mail Inbox
     */
    public function inAction()
    {

        $this->app->view->content['title'] = $this->lang('title_mail_in');
        $this->app->view->content['nav_main'] = 'mail';

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
        $mailList = $mailModel->getMaillist('to', $username);
        $this->app->view->content['mails'] = $mailList;
    }

    /**
     * Show the Mail Outbox
     */
    public function outAction()
    {

        $this->app->view->content['title'] = $this->lang('title_mail_out');
        $this->app->view->content['nav_main'] = 'mail';

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
        $mailList = $mailModel->getMaillist('from', $username, true);
        $this->app->view->content['mails'] = $mailList;
    }

    /**
     * Show a single mail
     */
    public function readAction()
    {

        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
        $mail = $mailModel->read($id);

        if (empty($mail)) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_data_not_found'), 'error');
        }
        if (($mail['to'] != $username) && ($mail['from'] != $username)) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_access_denied'), 'error');
        }

        if ($mail['read'] == '0000-00-00 00:00:00') {
            $mailModel->markRead($mail['id']);
        }

        $this->app->view->content['title'] = $this->lang('title_mail_read');
        $this->app->view->content['nav_main'] = 'mail';
        $this->app->view->content['mail'] = $mail;
    }

    /**
     * Input form for a new mail
     */
    public function newAction()
    {

        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'mailform';
        $form->fields = array(
            'to' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
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
            'submit' => array(
                'type' => 'submit',
                'value' => 'send'
            ),
        );

        if ($form->process()) {

            // get user
            $values = $form->getValues();

            $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
            $from = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
            $to = $values['to'];
            if (strpos($to, '@') === false) {
                $to .= '@' . $this->app->config['systemname'];
            }
            $data = array(
                'from' => $from,
                'to' => $to,
                'written' => strftime('%Y-%m-%d %H:%M:%S', time()),
                'subject' => $values['subject'],
                'message' => $values['message']
            );
            $id = $mailModel->create($data);

            $this->app->forward($this->buildURL('bbs/mail/out'), $this->lang('msg_mail_sent'), 'message');
        }
        $this->app->view->content['form'] = $form->getViewdata();
        $this->app->view->content['title'] = $this->lang('title_mail_new');
        $this->app->view->content['nav_main'] = 'mail';
    }

    public function deleteAction()
    {

        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        // test, if mail is available and owned by the user
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
        $mail = $mailModel->read($id);
        if (empty($mail)) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_data_not_found'), 'error');
        }
        if ($mail['to'] != $username) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_access_denied'), 'error');
        }

        $mailModel->delete($id);

        $this->app->forward($this->buildURL('bbs/mail'), $this->lang('msg_mail_deleted'), 'message');
    }

    public function replyAction()
    {

        // check if mail id exists
        if (empty($this->app->params)) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_access_denied'), 'error');
        }
        $id = (int) $this->app->params[0];

        // test, if mail is available and owned by the user
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $username = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
        $mail = $mailModel->read($id);

        if (empty($mail)) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_data_not_found'), 'error');
        }
        if ($mail['to'] != $username) {
            $this->app->forward($this->buildURL('/bbs/mail'), $this->lang('error_access_denied'), 'error');
        }

        $message = sprintf($this->lang('txt_reply_header'), $mail['from'], $mail['written']) . $mail['message'];

        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'mailform';
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
                'value' => 'RE: ' . $mail['subject']
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
            $from = $this->app->session->user_handle . '@' . $this->app->config['systemname'];
            $to = $values['to'];
            if (strpos($to, '@') === false) {
                $to .= '@' . $this->app->config['systemname'];
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
            $this->app->forward($this->buildURL('bbs/mail/out'), $this->lang('msg_mail_sent'), 'message');
        }
        $this->app->view->template = 'modules/bbs/views/web/mail/new.php';
        $this->app->view->content['form'] = $form->getViewdata();
        $this->app->view->content['title'] = $this->lang('title_mail_reply');
        $this->app->view->content['nav_main'] = 'mail';
    }

}

?>
