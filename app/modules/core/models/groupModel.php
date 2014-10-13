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
class groupModel extends \dollmetzer\zzaplib\DBModel {

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

}
