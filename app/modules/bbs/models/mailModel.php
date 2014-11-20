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
    public function getMaillist($_fromto, $_username, $outbox=false)
    {
        if($_fromto == 'to') {
            $sql = "SELECT * FROM mail WHERE `to`=?";
        } else if($_fromto == 'from') {
            $sql = "SELECT * FROM mail WHERE `from`=?";
            if($outbox !== false) {
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
    public function markRead($_id) {
        
        $sql = "UPDATE mail SET `read`='".strftime('%Y-%m-%d %H:%M:%S', time())."' WHERE id=".$_id;
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        
    }
    
    
    public function collectExport($_host, $_datetime) {
        
        // first get all board entries since datetime
        $sql = "SELECT mid, `from`, `to`, written, subject, message 
                FROM mail 
                WHERE `to` LIKE '#%' 
                    AND written > '".$_datetime."'
                    AND mid LIKE '".$this->app->config['systemname']."_%'";
                    
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        $boardMails = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // then get all private mails for the host
        
        return $boardMails;
    }
    
}

?>
