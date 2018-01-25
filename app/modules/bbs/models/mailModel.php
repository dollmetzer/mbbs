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

namespace Application\modules\bbs\models;

/**
 * BBS Mail Model
 * 
 * Database Methods for Mail handling
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
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
     * @param $_fromto
     * @param $_username
     * @param bool $_outbox
     * @return mixed
     */
    public function getListEntries($_fromto, $_username, $_outbox = false) {

        if ($_fromto == 'to') {
            $sql = "SELECT COUNT(*) as entries FROM mail WHERE `to`=".$this->dbh->quote($_username);
        } else if ($_fromto == 'from') {
            $sql = "SELECT COUNT(*) as entries FROM mail WHERE `from`=".$this->dbh->quote($_username);
            if ($_outbox !== false) {
                $sql .= " AND `to` NOT LIKE '#%' AND `to` NOT LIKE '!%'";
            }
        } else {
            $sql = "SELECT COUNT(*) as entries FROM mail";
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['entries'];

    }



    /**
     * Get a list of mails
     * 
     * @param string $_fromto 'to', 'from' or 'all'
     * @param string $_username
     * @param boolean $_outbox (default = false)
     * @param integer $_first (default = 0)
     * @param integer $_length (default = 0) If length = 0, then do no pagination
     * @return array
     */
    public function getMaillist($_fromto, $_username, $_outbox = false,
                                $_first = 0, $_length = 0)
    {
        if ($_fromto == 'to') {
            $sql = "SELECT * FROM mail WHERE `to`=?";
        } else if ($_fromto == 'from') {
            $sql = "SELECT * FROM mail WHERE `from`=?";
            if ($_outbox !== false) {
                $sql .= " AND `to` NOT LIKE '#%' AND `to` NOT LIKE '!%'";
            }
        } else {
            $sql = "SELECT * FROM mail";
        }

        // Standard sorting hardcoded...
        $sql .= ' ORDER BY written DESC';

        // Pagination
        if ($_length != 0) {
            $sql .= ' LIMIT '.(int) $_first.', '.(int) $_length;
        }

        $values = array($_username);
        $stmt   = $this->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get a number of entries of a list of mails
     * 
     * @param string $_fromto 'to', 'from' or 'all'
     * @param string $_username
     * @param boolean $_outbox (default = false)
     * @return integer
     */
    public function getMaillistEntries($_fromto, $_username, $_outbox = false)
    {
        if ($_fromto == 'to') {
            $sql = "SELECT COUNT(*) as entries FROM mail WHERE `to`=?";
        } else if ($_fromto == 'from') {
            $sql = "SELECT COUNT(*) as entries FROM mail WHERE `from`=?";
            if ($_outbox !== false) {
                $sql .= " AND `to` NOT LIKE '#%' AND `to` NOT LIKE '!%'";
            }
        } else {
            $sql = "SELECT COUNT(*) as entries FROM mail";
        }

        $values = array($_username);
        $stmt   = $this->dbh->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['entries'];
    }

    /**
     * Mark a mail as read
     * 
     * @param integer $_id
     */
    public function markRead($_id)
    {

        $sql  = "UPDATE mail SET `read`='".strftime('%Y-%m-%d %H:%M:%S', time())."' WHERE id=".$_id;
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
    }

    /**
     * Get the number of unread mails of a recipient
     * 
     * @param string $_recipient
     * @return integer
     */
    public function getNewMailCount($_recipient)
    {

        $sql    = "SELECT COUNT(*) as newmails FROM mail WHERE `to`=? AND `read` IS NULL";
        $values = array($_recipient);

        $stmt   = $this->dbh->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['newmails'];
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
                    AND written > '".$_datetime."'
                    AND mid LIKE '".$this->config['name']."_%'";

        $stmt       = $this->dbh->prepare($sql);
        $stmt->execute();
        $boardMails = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // then get all private mails for the host
        $sql = "SELECT mid, `from`, `to`, written, subject, message 
                FROM mail 
                WHERE `to` LIKE '%@$_host' 
                    AND written > '".$_datetime."'
                    AND mid LIKE '".$this->config['name']."_%'";

        $stmt         = $this->dbh->prepare($sql);
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

        $sql  = "SELECT * FROM mail WHERE mid LIKE ".$this->dbh->quote($_mid);
        $stmt = $this->dbh->prepare($sql);
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

        $data['mid'] = '.'; // placeholder
        $id  = parent::create($_data);
        $mid = $this->config['name'].'_'.$id;
        $sql = "UPDATE mail SET mid = ".$this->dbh->quote($mid)." WHERE id=".$id;
        if (empty($_data['origin_mid'])) {
            $sql = "UPDATE mail SET mid = ".$this->dbh->quote($mid).", origin_mid = ".$this->dbh->quote($mid)." WHERE id=".$id;
        }
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $id;
    }
}
?>
