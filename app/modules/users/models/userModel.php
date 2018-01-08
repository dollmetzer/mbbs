<?php
/**
 * z z a p   a p p   e x a m p l e   a p p l i c a t i o n
 * =======================================================
 *
 * This is a base application using the zzaplib web applications mini framework
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 3 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses/>.
 */

namespace Application\modules\users\models;

/**
 * The users usermodel handles user data
 *
 * @author Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @copyright 2016-2017 Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @package zzapapp
 * @subpackage users
 */
class userModel extends \dollmetzer\zzaplib\DBModel
{

    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'user';

    /**
     * create a new user
     *
     * @param string $_handle
     * @param string $_password Hash password only, if set
     * @param string $_language
     * @param int $_active
     * @param string $_email
     * @param string $_confirmcode
     * @param string $_created Datetime string
     * @param string $_confirmed Datetime string
     * @return integer
     */
    public function create(
        $_handle,
        $_password,
        $_language,
        $_active,
        $_email = '',
        $_confirmcode = '',
        $_created = '',
        $_confirmed = ''
    ) {

        if ($_active != 0) {
            $_active = 1;
        }
        if ($_created == '') {
            $_created = strftime('%Y-%m-%d %H:%H:%S');
        }
        if ($_confirmed == '') {
            $_confirmed = strftime('%Y-%m-%d %H:%H:%S');
        }
        if ($_password != '') {
            $_password = hash('sha256', $_password);
        }

        $sql = "INSERT INTO user (
                    handle,
                    password,
                    language,
                    active,
                    email,
                    confirmcode,
                    created,
                    confirmed
                ) VALUES (
                    " . $this->dbh->quote($_handle) . ",
                    " . $this->dbh->quote($_password) . ",
                    " . $this->dbh->quote($_language) . ",
                    $_active,
                    " . $this->dbh->quote($_email) . ",
                    " . $this->dbh->quote($_confirmcode) . ",
                    " . $this->dbh->quote($_created) . ",
                    " . $this->dbh->quote($_confirmed) . "
                )";
        $this->dbh->exec($sql);
        return $this->dbh->lastInsertId();

    }

    /**
     * Set password
     *
     * @param integer $_uid
     * @param string $_password
     */
    public function setPassword($_uid, $_password)
    {

        $sql = "UPDATE user 
                SET password=" . $this->dbh->quote(hash('sha256', $_password)) . " 
                WHERE id=" . (int)$_uid;
        $this->dbh->exec($sql);

    }

    /**
     * Confirm a new user as registered
     *
     * @param integer $_uid User ID
     * @param string $_password
     * @param string $_language
     */
    public function confirm($_uid, $_password, $_language)
    {

        $sql = "UPDATE user 
                SET password=" . $this->dbh->quote(hash('sha256', $_password)) . ",
                    language=" . $this->dbh->quote($_language) . ",
                    confirmed=" . $this->dbh->quote(strftime('%Y-%m-%d %H:%M:%S', time())) . ",
                    confirmcode=''
                WHERE id=" . (int)$_uid;
        $this->dbh->exec($sql);

    }

    /**
     * Get a user by his handle
     *
     * @param string $_handle
     * @return array
     */
    public function getByHandle($_handle)
    {

        $sql = "SELECT * FROM user WHERE handle = ?";
        $values = array(
            $_handle
        );

        $stmt = $this->dbh->prepare($sql);
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
    public function getByLogin($_handle, $_password)
    {

        $sql = "SELECT *
                FROM user
                WHERE handle = ?
                    AND password=?
                    AND active=1";
        $values = array(
            $_handle,
            hash('sha256', $_password)
        );

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($values);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    /**
     * Returns a user by its confirmationcode
     *
     * @param $_confirmcode
     * @return mixed
     */
    public function getByConfirmcode($_confirmcode)
    {

        $sql = "SELECT *
                FROM user
                WHERE confirmcode = " . $this->dbh->quote($_confirmcode);

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user;

    }

    /**
     * Get a list of users for a given group
     *
     * @param integer $_groupId
     * @return array
     */
    public function getListByGroup($_groupId)
    {

        $sql = "SELECT u.*
                FROM user_group AS ug
                JOIN user AS u ON u.id=ug.user_id
                WHERE ug.group_id=?
                    AND u.active=1";
        $values = array(
            $_groupId
        );
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Updates the lastlogin field to NOW
     *
     * @param integer $_uid
     */
    public function setLastlogin($_uid)
    {

        $sql = "UPDATE user SET lastlogin=? WHERE id=?";
        $values = array(
            strftime('%Y-%m-%d %H:%M:%S', time()),
            (int)$_uid
        );
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($values);
    }

    /**
     * Get a list of users
     *
     * @param integer $_first
     * @param integer $_length
     * @param string $_sortColumn
     * @param string $_sortDirection
     * @return array
     */
    public function getList($_first = null, $_length = null, $_sortColumn = null, $_sortDirection = 'asc')
    {

        $sql = "SELECT * FROM user";
        if ($_sortColumn) {
            if ($_sortDirection != 'desc') {
                $_sortDirection = 'asc';
            }
            $sql .= ' ORDER BY ' . $_sortColumn . ' ' . strtoupper($_sortDirection);

        }
        if (isset($_first) && isset($_length)) {
            $sql .= ' LIMIT ' . (int)$_first . ',' . (int)$_length;
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $list;
    }

    /**
     * Get the number of entries in a user list
     *
     * @return integer
     */
    public function getListEntries()
    {

        $sql = "SELECT COUNT(*) as entries FROM user";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['entries'];
    }

    /**
     * Get Users, created on a specified time
     *
     * @param string $_date Datetime format
     * @param bool $_isUnconfirmed
     * @return array
     */
    public function getByRegistered($_date, $_isUnconfirmed = true)
    {

        $sql = "SELECT * FROM user WHERE created LIKE " . $this->dbh->quote($_date);
        if ($_isUnconfirmed === true) {
            $sql .= " AND confirmed IS null'";
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    /**
     * Search for a user
     *
     * @param string $_searchterm
     * @param integer $_first
     * @param integer $_length
     * @param string $_sortColumn
     * @param string $_sortDirection
     * @return array users
     */
    public function search($_searchterm, $_first = null, $_length = null, $_sortColumn = null, $_sortDirection = 'asc')
    {

        $sql = "SELECT * FROM user WHERE handle LIKE " . $this->dbh->quote($_searchterm);
        if ($_sortColumn) {
            if ($_sortDirection != 'desc') {
                $_sortDirection = 'asc';
            }
            $sql .= ' ORDER BY ' . $_sortColumn . ' ' . strtoupper($_sortDirection);

        }
        if (isset($_first) && isset($_length)) {
            $sql .= ' LIMIT ' . (int)$_first . ',' . (int)$_length;
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $list;

    }

    /**
     * Get the number of results for a search
     *
     * @param string $_searchterm
     * @return array
     */
    public function getSearchEntries($_searchterm)
    {

        $sql = "SELECT COUNT(*) as entries FROM user WHERE handle LIKE " . $this->dbh->quote($_searchterm);
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['entries'];

    }


}