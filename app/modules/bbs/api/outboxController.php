<?php
/**
 * BBS - Bulletin Board System
 *
 * A small BBS package for mobile use
 *
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2018, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */

namespace Application\modules\bbs\api;

/**
 * Implementation of the Activitypub API - Outbox controller
 *
 * ActivityPub Homepage: https://activitypub.rocks/
 * W3C Recommendation: https://www.w3.org/TR/activitypub/#actor-objects
 *
 * @package Application\modules\bbs\api
 */
class outboxController extends \dollmetzer\zzaplib\ApiController
{

    /**
     * Outside world reads users outbox
     *
     * @return array
     */
    public function getAction() {

        // get user name
        if(sizeof($this->request->params) == 0) {
            $this->response->setStatusCode(400);
            $this->response->setStatusInfo('Missing user');
            return;
        }
        $userName = $this->getUserName($this->request->params[0]);

        // does user exists?
        if(empty($userName)) {
            $this->response->setStatusCode(404);
            $this->response->setStatusInfo('Invalid user');
            return;

        }

        // ToDo access control

        // ToDo pagination
        $first = 0;
        $entriesPerPage = 10;

        $mailModel = new \Application\modules\bbs\models\mailModel($this->config);
        $mailList = $mailModel->getMaillist('to', '!wall', false, $first,
            $entriesPerPage);



        return array($mailList);

    }


    /**
     * User sends message
     *
     * @return array
     */
    public function postAction() {

        // get user name
        if(sizeof($this->request->params) == 0) {
            $this->response->setStatusCode(400);
            $this->response->setStatusInfo('Missing user');
            return;
        }
        $userName = $this->getUserName($this->request->params[0]);

        // does user exists?
        if(empty($userName)) {
            $this->response->setStatusCode(404);
            $this->response->setStatusInfo('Invalid user');
            return;

        }


        return array($this->request->listApiCalls());

    }

    /**
     * Check, if username is valid (active user or "Special User")
     *
     * @param string $_name Username
     * @return string Username (empty, if user was not valid)
     */
    protected function getUserName($_name) {

        // special user wall
        if($_name == 'wall') return '!wall';

        // special user board

        // exists user and is active?
        // todo

        return $_name;

    }

}