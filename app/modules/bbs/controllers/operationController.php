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
 * Methods for handling data exchange
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class operationController extends \Application\modules\core\controllers\Controller
{

    /**
     * @var array $accessGroups
     */
    protected $accessGroups = array(
        'hosts' => array('operator'),
        'addhost' => array('operator'),
        'deletehost' => array('operator'),
        'export' => array('operator'),
        'exportfile' => array('operator'),
        'import' => array('operator'),
    );


    /**
     * Show a list of connected hosts
     */
    public function hostsAction()
    {

        $hostModel = new \Application\modules\bbs\models\hostModel($this->app);
        $list = $hostModel->getList();

        $this->app->view->content['title'] = $this->lang('title_hosts');
        $this->app->view->content['nav_main'] = 'operation';
        $this->app->view->content['list'] = $list;
    }


    /**
     * Add a host to the hostlist
     */
    public function addhostAction()
    {

        if (empty($_POST['newhost'])) {
            $this->forward($this->buildURL('bbs/operation/hosts'), $this->lang('error_illegal_parameter'), 'error');
        }

        $newhost = strtolower($_POST['newhost']);
        if (!preg_match('/^[a-z_-]{3,16}$/', $newhost)) {
            $this->forward($this->buildURL('bbs/operation/hosts'), $this->lang('error_invalid_hostname'), 'error');
        }

        $hostModel = new \Application\modules\bbs\models\hostModel($this->app);
        $hostList = $hostModel->getList();

        $list = array($this->app->config['systemname']);
        for ($i = 0; $i < sizeof($hostList); $i++) {
            $list[] = $hostList[$i]['name'];
        }

        if (in_array($newhost, $list)) {
            $this->forward($this->buildURL('bbs/operation/hosts'), $this->lang('error_hostname_exists'), 'error');
        }

        $data = array(
            'name' => $newhost,
            'lastexport' => '0000-00-00 00:00:00',
            'confirmed' => 0
        );

        $id = $hostModel->create($data);
        $this->forward($this->buildURL('bbs/operation/hosts'), $this->lang('msg_hostname_created'), 'notice');
    }


    /**
     * delete a host from the hostlist
     */
    public function deletehostAction()
    {

        if (sizeof($this->app->params) < 1) {
            $this->forward($this->buildURL('bbs/operation/hosts'), $this->lang('error_missing_parameter'), 'error');
        }
        $id = (int) $this->app->params[0];

        $hostModel = new \Application\modules\bbs\models\hostModel($this->app);
        $hostModel->delete($id);

        $this->forward($this->buildURL('bbs/operation/hosts'), $this->lang('msg_hostname_deleted'), 'notice');
    }


    /**
     * Show a page for creating transferfiles
     */
    public function exportAction()
    {

        $hostModel = new \Application\modules\bbs\models\hostModel($this->app);
        $list = $hostModel->getList();

        $this->app->view->content['title'] = $this->lang('title_export');
        $this->app->view->content['nav_main'] = 'operation';
        $this->app->view->content['list'] = $list;
    }


    /**
     * Show a page for importing a transferfile
     */
    public function importAction()
    {

        if (!empty($_FILES['mails'])) {

            // check correct upload
            if ($_FILES['mails']['error'] != 0) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_upload_failed'), 'error');
            }
            if (!is_uploaded_file($_FILES['mails']['tmp_name'])) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_upload_failed'), 'error');
            }

            // check filename
            $temp = explode('_', $_FILES['mails']['name']);
            if (sizeof($temp) != 4) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_illegal_filename'), 'error');
            }

            // check target and source system
            if ($temp[0] != $this->app->config['systemname']) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_illegal_target'), 'error');
            }
            $hostModel = new \Application\modules\bbs\models\hostModel($this->app);
            $source = $hostModel->getByName($temp[1]);
            if (empty($source)) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_illegal_source'), 'error');
            }

            // Try to open 
            try {
                $data = json_decode(file_get_contents($_FILES['mails']['tmp_name']), true);
            } catch (\Exception $e) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_mail_file_unreadable'), 'error');
            }

            // all included?
            if (empty($data['fromHost']) || empty($data['toHost']) || !is_array($data['mails'])) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_mail_file_unreadable'), 'error');
            }
            // double check source and target
            if ($data['fromHost'] != $source['name']) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_illegal_source'), 'error');
            }
            if ($data['toHost'] != $this->app->config['systemname']) {
                $this->forward($this->buildURL('bbs/operation/import'), $this->lang('error_illegal_target'), 'error');
            }

            // everything seems o.k.
            $result = $this->importMails($data['mails']);

            $this->forward($this->buildURL('bbs/operation/import'), sprintf($this->lang('msg_import_finished'), $result['imported'], $result['skipped']), 'message');
        }
        $this->app->view->content['title'] = $this->lang('title_import');
        $this->app->view->content['nav_main'] = 'operation';
    }


    /**
     * Create an export file for the message transfer to another host
     */
    public function exportfileAction()
    {

        if (sizeof($this->app->params) < 1) {
            $this->forward($this->buildURL('bbs/operation/export'), $this->lang('error_missing_parameter'), 'error');
        }

        // find host
        $id = (int) $this->app->params[0];
        $hostModel = new \Application\modules\bbs\models\hostModel($this->app);
        $host = $hostModel->read($id);
        if (empty($host)) {
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
        $filename = $host['name'] . '_' . $this->app->config['systemname'] . strftime('_%Y%m%d_%H%M%S.json');
        $json = json_encode($content);

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($json));
        echo $json;

        // Mark last export in DB
        $data = array(
            'lastexport' => strftime('%Y-%m-%d %H:%M:%S', time())
        );
        $hostModel->update($id, $data);
        exit;
    }


    /**
     * Import a transferfile with mails
     *
     * @param array $_mails
     * @return array Array with number of imported and skipped mails
     */
    protected function importMails($_mails)
    {

        $skipped = 0;
        $imported = 0;
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
        $boardModel = new \Application\modules\bbs\models\boardModel($this->app);
        $userModel = new \Application\modules\core\models\userModel($this->app);

        for ($i = 0; $i < sizeof($_mails); $i++) {

            // skip already existing mails
            $previous = $mailModel->findByMid($_mails[$i]['mid']);
            if (!empty($previous)) {
                $skipped++;
                continue;
            }

            // skip personal mail if user doesnt't exists
            $temp = explode('@', $_mails[$i]['to']);
            if (sizeof($temp) == 2) {
                if ($temp[1] != $this->app->config['systemname']) {
                    $skipped++;
                    continue;
                }
                $user = $userModel->getByHandle($temp[0]);
                if (empty($user)) {
                    $skipped++;
                    continue;
                }
            }

            // insert new mail
            $data = array(
                'mid' => $_mails[$i]['mid'],
                'from' => $_mails[$i]['from'],
                'to' => $_mails[$i]['to'],
                'written' => $_mails[$i]['written'],
                'subject' => $_mails[$i]['subject'],
                'message' => $_mails[$i]['message'],
            );
            $id = $mailModel->create($data);
            $imported++;

            // if mail is for a non existing board - create it
            if (preg_match('/^#/', $_mails[$i]['to'])) {
                $boardName = preg_replace('/^#/', '', $_mails[$i]['to']);
                $board = $boardModel->getByName($boardName);
                if (empty($board)) {
                    $data = array(
                        'parent_id' => 0,
                        'content' => 1,
                        'name' => $boardName,
                        'description' => 'inserted automaticcaly by the importer'
                    );
                    $bid = $boardModel->create($data);
                }
            }
        }

        return array(
            'imported' => $imported,
            'skipped' => $skipped
        );
    }

}
