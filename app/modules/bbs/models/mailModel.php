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

namespace Application\modules\bbs\models;

/**
 * BBS Mail Model
 * 
 * Database Methods for Mail handling
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class mailModel extends \dollmetzer\zzaplib\DBModel
{

    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'mail';


    /**
     * Get a list of mails
     * 
     * @param string $_fromto 'to', 'from' or 'all'
     * @param string $_username
     * @param boolean $outbox (default = false)
     * @return array
     */
    public function getMaillist($_fromto, $_username, $outbox = false)
    {
        if ($_fromto == 'to') {
            $sql = "SELECT * FROM mail WHERE `to`=?";
        } else if ($_fromto == 'from') {
            $sql = "SELECT * FROM mail WHERE `from`=?";
            if ($outbox !== false) {
                $sql .= " AND `to` NOT LIKE '#%' AND `to` NOT LIKE '!%'";
            }
        } else {
            $sql = "SELECT * FROM mail";
        }

        // Standard sorting hardcoded...
        $sql .= ' ORDER BY written DESC';

        $values = array($_username);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Mark a mail as read
     * 
     * @param integer $_id
     */
    public function markRead($_id)
    {

        $sql = "UPDATE mail SET `read`='" . strftime('%Y-%m-%d %H:%M:%S', time()) . "' WHERE id=" . $_id;
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
    }


    /**
     * Fetch a list of mails for export to a certain host
     * 
     * @param string $_host
     * @param string $_datetime
     * @return array
     */
    public function collectExport($_host, $_datetime)
    {

        // first get all board entries since datetime
        $sql = "SELECT mid, `from`, `to`, written, subject, message 
                FROM mail 
                WHERE `to` LIKE '#%' 
                    AND written > '" . $_datetime . "'
                    AND mid LIKE '" . $this->app->config['systemname'] . "_%'";

        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        $boardMails = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // then get all private mails for the host
        $sql = "SELECT mid, `from`, `to`, written, subject, message 
                FROM mail 
                WHERE `to` LIKE '%@$_host' 
                    AND written > '" . $_datetime . "'
                    AND mid LIKE '" . $this->app->config['systemname'] . "_%'";

        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        $privateMails = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_merge($boardMails, $privateMails);
    }


    /**
     * Find a mail by its mid (Mail ID)
     * 
     * @param integer $_mid
     * @return array
     */
    public function findByMid($_mid)
    {

        $sql = "SELECT * FROM mail WHERE mid LIKE " . $this->app->dbh->quote($_mid);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    /**
     * Enhanced create also fills the mid (Mail ID) automatically
     * 
     * @param array $_data Array of key=>value pairs.
     * @return integer Internal ID of the mail
     */
    public function create($_data)
    {

        $id = parent::create($_data);
        $mid = $this->app->config['systemname'] . '_' . $id;
        $sql = "UPDATE mail SET mid = " . $this->app->dbh->quote($mid) . " WHERE id=" . $id;
        if(empty($_data['origin_mid'])) {
            $sql = "UPDATE mail SET mid = " . $this->app->dbh->quote($mid) . ", origin_mid = " . $this->app->dbh->quote($mid) . " WHERE id=" . $id;    
        }
        error_log(print_r($_data, true));
        error_log($sql);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        return $id;
    }

}

?>
