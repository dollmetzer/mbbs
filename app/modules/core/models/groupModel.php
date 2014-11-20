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

/**
 * Group Model
 *
 * Methods for accessing the group table in the DB
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class groupModel extends \dollmetzer\zzaplib\DBModel 
{
    
    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'group';
    
    
    /**
     * Get a list of all groups for a certain user
     *  
     * @param integer $_userId
     * @return array
     */
    public function getUserGroups($_userId) {

        $sql = "SELECT g.*
                FROM `user_group` AS ug
                JOIN `group` AS g ON g.id=ug.group_id
                WHERE `user_id`=?
                    AND g.active=1";
        $values = array($_userId);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Get a group by its name
     * 
     * @param string $_name
     * @return array
     */
    public function getByName($_name) {
        
        $sql = "SELECT * FROM `group` WHERE name=?";
        $values = array($_name);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
        
    }

    /**
     * Get a list of groups
     * 
     * @param integer $_first
     * @param integer $_length
     * @return array
     */
    public function getList($_first=null, $_length=null) {
                
        $sql = "SELECT * FROM `group`";
        if(isset($_first) && isset($_length)) {
            $sql .= ' LIMIT '.(int)$_first.','.(int)$_length;            
        }
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $list;
        
    }
    
    /**
     * Attach a user to a group
     * 
     * @param integer $_userId
     * @param integer $_groupId
     */
    public function setUserGroup($_userId, $_groupId) {
        
        $sql = "INSERT INTO `user_group` (
                    user_id, 
                    group_id
                ) VALUES (
                    ?,
                    ?
                )";
        $values = array($_userId, $_groupId);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        
    }
    
    /**
     * Delete a user from a group
     * 
     * @param type $_userId
     * @param type $_groupId
     */
    public function deleteUserGroup($_userId, $_groupId) {
        
    }
    
}
