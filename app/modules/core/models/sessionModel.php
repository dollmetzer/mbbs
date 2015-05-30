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

namespace Application\modules\core\models;

/**
 * Session Model
 *
 * Methods for accessing the session table in the DB
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class sessionModel extends \dollmetzer\zzaplib\DBModel {

    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'session';

    /**
     * Creates or update an entry for the current user session in the session table
     * 
     * @param string $_area Area string
     */
    public function update($_area) {

        $sql = "REPLACE INTO session SET id=" . $this->app->dbh->quote(session_id()) . ",
                start='" . strftime('%Y-%m-%d %H:%M:%S', $_SESSION['start']) . "',
                hits=" . (int) $_SESSION['hits'] . ",
                user_id=" . (int) $_SESSION['user_id'] . ",
                user_handle=" . $this->app->dbh->quote($_SESSION['user_handle']) . ",
                area=" . $this->app->dbh->quote($_area) . ",
                useragent=" . $this->app->dbh->quote($_SERVER['HTTP_USER_AGENT']);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
    }

}
