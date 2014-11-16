<?php

/**
 * CORE - Web Application Core Elements
 * 
 * Typical Elements for every Web Application
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */

namespace Application\modules\core\models;

use dollmetzer\zzaplib\DBModel;

/**
 * User Model
 *
 * Methods for accessing the user table in the DB
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class userModel extends \dollmetzer\zzaplib\DBModel {

    protected $tablename = 'user';
    
    /**
     * Get a user by his handle
     * 
     * @param string $_handle
     * @return array
     */
    public function getByHandle($_handle) {

        $sql = "SELECT * FROM user WHERE handle = ?";
        $values = array(
            $_handle
        );

        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Returns a user, if login is possible
     * 
     * @param string $_handle
     * @param string $_password
     * @return array
     */
    public function getByLogin($_handle, $_password) {

        $sql = "SELECT * 
                FROM user 
                WHERE handle = ? 
                    AND password=? 
                    AND active=1";
        $values = array(
            $_handle,
            sha1($_password)
        );

        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    /**
     * Updates the lastlogin field to NOW
     * 
     * @param integer $_uid
     */
    public function setLastlogin($_uid) {

        $sql = "UPDATE user SET lastlogin=? WHERE id=?";
        $values = array(
            strftime('%Y-%m-%d %H:%M:%S', time()),
            (int) $_uid
        );
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
    }

    
    public function getList($_first=null, $_length=null) {
                
        $sql = "SELECT * FROM user";
        if(isset($_first) && isset($_length)) {
            $sql .= ' LIMIT '.(int)$_first.','.(int)$_length;            
        }
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $list;
        
    }
    
}

?>
