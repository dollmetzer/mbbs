<?php
/**
 * CORE - Web Application Core Elements
 *
 * Typical Elements for every Web Application
 *
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */

namespace Application\modules\bbs\models;

/**
 * Mail Attachment Model
 *
 * Methods for accessing the mail_attachment table in the DB
 *
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class mailattachmentModel extends \dollmetzer\zzaplib\DBModel
{
    /**
     * @var string $tablename Name for standard CRUD
     */
    protected $tablename = 'mail_attachment';

    /**
     * Get attachments for a mail
     * 
     * @param integer $_mailId
     * @return array
     */
    public function getAttachments($_mailId)
    {

        $sql  = "SELECT * FROM mail_attachment WHERE mail_id=".(int) $_mailId.' ORDER BY sort';
        $stmt = $this->app->dbh->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}