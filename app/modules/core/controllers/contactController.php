<?php
/**
 * CORE - Web Application Core Elements
 * 
 * Typical Elements for every Web Application
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */

namespace Application\modules\core\controllers;

/**
 * CORE Account Controller
 * 
 * Methods for account handling (login, logout, register, ...)
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class contactController extends \Application\modules\core\controllers\Controller
{
    /**
     * @var type array neccessary access rights
     */
    protected $accessGroups = array(
        'suggest' => array('user', 'operator', 'administrator', 'moderator')
    );

    /**
     * Returns a JSON array off contact suggestions, based on the system users 
     * and the contact list of the requester
     */
    public function suggestAction()
    {

        $result = array();

        $part = '';
        if (sizeof($this->app->params > 0)) {
            $part = $this->app->params[0];
        }
        if (strlen($part) > 1) {
            $userModel = new \Application\modules\core\models\userModel($this->app);
            $result    = $userModel->getSuggestList($part);
        }

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        echo json_encode($result);
        exit;
    }
}