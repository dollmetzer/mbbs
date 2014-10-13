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
    
    
    public function getMaillist($_fromto, $_username)
    {
        if($_fromto == 'to') {
            $sql = "SELECT * FROM mail WHERE `to`=?";
        } else if($_fromto == 'from') {
            $sql = "SELECT * FROM mail WHERE `from`=?";
        } else {
            $sql = "SELECT * FROM mail";
        }

        // Standardsortierung hardcoded...
        $sql .= ' ORDER BY written DESC';
        
        $values = array($_username);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
    }
    
    
    public function markRead($_id) {
        
        $sql = "UPDATE mail SET `read`='".strftime('%Y-%m-%d %H:%M:%S', time())."' WHERE id=".$_id;
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        
    }
    

}

?>
