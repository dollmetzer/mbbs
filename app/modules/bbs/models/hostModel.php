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
class hostModel extends \dollmetzer\zzaplib\DBModel
{
    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'host';

    /**
     * Get a host list
     * 
     * @return array
     */
    public function getList()
    {

        $sql  = "SELECT * FROM host";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get a host by name
     * 
     * @param string $_name
     * @return array
     */
    public function getByName($_name)
    {

        $sql  = "SELECT * FROM host WHERE name LIKE ".$this->dbh->quote($_name);
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
?>
