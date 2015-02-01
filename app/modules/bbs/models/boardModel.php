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
 * BBS Board Model
 * 
 * Database Methods for Board handling
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class boardModel extends \dollmetzer\zzaplib\DBModel
{

    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'board';


    /**
     * Get the path to a certain board
     * 
     * @param integer $_parentid
     * @return array
     */
    public function getPath($_parentid = 0)
    {
        $path = array();
        while ($_parentid != 0) {
            $sql = "SELECT * 
                FROM board 
                WHERE id=" . (int) $_parentid . "";
            $stmt = $this->app->dbh->prepare($sql);
            $stmt->execute();
            $step = $stmt->fetch(\PDO::FETCH_ASSOC);
            array_unshift($path, $step);
            $_parentid = $step['parent_id'];
        }
        return $path;
    }


    /**
     * Get list of boards
     * 
     * @param integer $_parentid ID of the parent board
     * @param boolean $_msgcount Count messages in the board
     * @return array
     */
    public function getList($_parentid = 0, $_msgcount = false)
    {

        $sql = "SELECT * 
            FROM board 
            WHERE parent_id=" . (int) $_parentid . " 
                ORDER BY name ASC";
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($_msgcount === true) {
            foreach ($list as $pos => $element) {

                // TODO: count Mails recursive
                $sql = "SELECT COUNT(id) as mails FROM mail WHERE `to` LIKE '#" . $element['name'] . "'";
                $stmt = $this->app->dbh->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                $list[$pos]['mails'] = $result['mails'];
            }
        }

        return $list;
    }


    /**
     * Get Board by name
     * 
     * @param string $_boardName
     * @return array
     */
    public function getByName($_boardName)
    {

        $sql = "SELECT * FROM board WHERE name=?";
        $values = array($_boardName);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    /**
     * Count number of entries for board
     * 
     * @param type $_boardId
     * @return type
     */
    public function countEntries($_boardId)
    {

        $sql = "SELECT name FROM board WHERE id=?";
        $values = array($_boardId);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        $board = $stmt->fetch(\PDO::FETCH_ASSOC);
        $boardName = '#' . $board['name'];

        $sql = "SELECT COUNT(*) FROM mail WHERE `to` LIKE " . $this->app->dbh->quote($boardName);
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        $values = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $values['COUNT(*)'];
    }

}

?>
