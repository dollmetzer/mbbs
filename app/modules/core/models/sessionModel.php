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
class sessionModel extends \dollmetzer\zzaplib\DBModel
{
    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'session';

    /**
     * Creates or update an entry for the current user session in the session table
     * 
     * @param string $_area Area string
     */
    public function update($_area)
    {

        $sql  = "REPLACE INTO session SET id=".$this->app->dbh->quote(session_id()).",
                start='".strftime('%Y-%m-%d %H:%M:%S', $_SESSION['start'])."',
                hits=".(int) $_SESSION['hits'].",
                user_id=".(int) $_SESSION['user_id'].",
                user_handle=".$this->app->dbh->quote($_SESSION['user_handle']).",
                area=".$this->app->dbh->quote($_area).",
                useragent=".$this->app->dbh->quote($_SERVER['HTTP_USER_AGENT']);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
    }

    /**
     * Get basic info about sessions
     * 
     * @param string $_start (fomat: DB Datetime)
     * @param string $_end
     * @return array
     */
    public function getInfo($_start, $_end = '')
    {

        if (empty($_end)) {
            $_end = strftime('%Y-%m-%d 23:59:59', time());
        }

        $sql  = "SELECT hits, COUNT( * ) AS number
                FROM `session` 
                WHERE START >= ".$this->app->dbh->quote($_start)."
                AND START <= ".$this->app->dbh->quote($_end)."
                    GROUP BY hits 
                    ORDER BY number desc";
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get info about used useragents
     * 
     * @param string $_start (fomat: DB Datetime)
     * @param string $_end
     * @return array
     */
    public function getUseragents($_start, $_end = '')
    {

        if (empty($_end)) {
            $_end = strftime('%Y-%m-%d 23:59:59', time());
        }

        $sql  = "SELECT useragent, COUNT( * ) AS sessions
                FROM `session` 
                WHERE START >= ".$this->app->dbh->quote($_start)."
                AND START <= ".$this->app->dbh->quote($_end)."
                    GROUP BY useragent
                    ORDER BY sessions desc";
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}