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
 * User Model
 *
 * Methods for accessing the user table in the DB
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class userModel extends \dollmetzer\zzaplib\DBModel {

    /**
     * @var string $tablename Name for standard CRUD
     */
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
     * Get a list of users for a given group
     * 
     * @param integer $_groupId
     * @return array
     */
    public function getListByGroup($_groupId) {

        $sql = "SELECT u.*
                FROM user_group AS ug 
                JOIN user AS u ON u.id=ug.user_id
                WHERE ug.group_id=?
                    AND u.active=1";
        $values = array(
            $_groupId
        );
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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

    /**
     * Get a list of users
     * 
     * @param integer $_first
     * @param integer $_length
     * @return array
     */
    public function getList($_first = null, $_length = null) {

        $sql = "SELECT * FROM user";
        if (isset($_first) && isset($_length)) {
            $sql .= ' LIMIT ' . (int) $_first . ',' . (int) $_length;
        }
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $list;
    }

    /**
     * Get the number of entries in a user list
     * 
     * @return integer
     */
    public function getListEntries() {

        $sql = "SELECT COUNT(*) as entries FROM user";
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['entries'];
    }

}

?>
