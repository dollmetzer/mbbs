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
 * Implementation of the Activitypub API - Inbox controller
 *
 * ActivityPub Homepage: https://activitypub.rocks/
 * W3C Recommendation: https://www.w3.org/TR/activitypub/#actor-objects
 *
 * @package Application\modules\bbs\api
 */
class inboxController extends \dollmetzer\zzaplib\ApiController
{

    /**
     * Implements Activitypub API
     *
     * @return array
     */
    public function getAction() {

        // get user
        if(sizeof($this->request->params) == 0) {

        }
        $user = $this->request->params[0];

        // does user exists?



        return array($this->request->listApiCalls());

    }


    /**
     * Implements Activitypub API
     *
     * @return array
     */
    public function postAction() {

        // get user
        if(sizeof($this->request->params) == 0) {

        }
        $user = $this->request->params[0];

        // does user exists?



        return array($this->request->listApiCalls());

    }



}