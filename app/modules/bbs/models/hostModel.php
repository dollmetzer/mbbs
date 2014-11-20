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
class hostModel extends \dollmetzer\zzaplib\DBModel
{

    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'host';
    
    
    public function getList() {
        
        $sql = "SELECT * FROM host";
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
    }
    
    
    
}

?>
