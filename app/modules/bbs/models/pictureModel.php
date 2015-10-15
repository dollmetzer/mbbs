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
 * BBS Picture Model
 * 
 * Methods for handling mail related picture up- and downloads
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class pictureModel
{
    /**
     * @var Application $app Holds the instance of the application
     */
    public $app;

    /**
     * @var array Array of valid contexts ('wall', 'board', 'mail')
     */
    protected $context;

    /**
     * Constructor
     *
     * @param type $_app
     */
    public function __construct($_app)
    {

        $this->app     = $_app;
        $this->context = array('wall', 'board', 'mail');
    }

    /**
     * Return filepath for a given context
     * 
     * @param string $_context Valid is 'wall', 'board' or 'mail'
     * @return string Path, or empty on wrong context
     */
    public function getPath($_context)
    {

        if (!in_array($_context, $this->context)) {
            return '';
        }
        return PATH_DATA.$_context;
    }

    /**
     * Check, if a picture for a given wall article exists
     * 
     * @param string $_context Valid is 'wall', 'board' or 'mail'
     * @param string $_id Identifier of the picture (filename without filetype extension)
     * @return boolean
     */
    public function hasPicture($_context, $_id)
    {

        if (!in_array($_context, $this->context)) {
            return false;
        }
        $filename = PATH_DATA.$_context.'/'.$_id.'.jpg';
        if (!file_exists($filename)) return false;
        return true;
    }

    /**
     * Save a base64 encoded item picture
     * 
     * @param string $_context Valid is 'wall', 'board' or 'mail'
     * @param string $_id Identifier of the picture (filename without filetype extension)
     * @param string $_image Base64 encoded JPEG image
     * @return boolean success
     */
    public function saveEncodedPicture($_context, $_id, $_image)
    {

        if (!in_array($_context, $this->context)) {
            return false;
        }

        $path = PATH_DATA.$_context;
        if (!is_dir($path)) {
            if (mkdir($path, 0775, true) !== true) return false;
        }

        if (substr($_image, 0, 23) == 'data:image/jpeg;base64,') {
            $img         = str_replace('data:image/jpeg;base64,', '', $_image);
            $img         = str_replace(' ', '+', $img);
            $data        = base64_decode($img);
            $filename    = $path.'/'.$_id.'.jpg';
            $fileSuccess = file_put_contents($filename, $data);
            if ($fileSuccess === false) {
                $this->app->log('Saving Picture '.$filename.' failed');
                return false;
            }
            chmod($filename, 0664);
            return true;
        } else {
            $this->app->log('Saving Picture failed : Wrong content encoding for item'.$_id.'failed');
            return false;
        }
    }

    /**
     * Download a specified picture with all headers - or send a 404 error
     *
     * @param string $_context Valid is 'wall', 'board' or 'mail'
     * @param string $_id Identifier of the picture (filename without filetype extension)
     */
    public function download($_context, $_id) {

        $filename = $this->getPath($_context).'/'.$_id.'.jpg';
        if (!file_exists($filename)) {
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        header('Content-Type: image/jpeg');
        header('Content-Disposition: attachment; filename="mail_'.$_context.'_'.$_id.'.jpg"');
        header('Content-Length: '.filesize($filename));
        readfile($filename);
        exit;

    }
}