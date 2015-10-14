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
 * File Model
 *
 * Methods for handling files in the data directory
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class fileModel {
    
    const UPLOAD_EMPTY = 0;
    const UPLOAD_OK = 1;
    const UPLOAD_ERROR_FILE_FILETYPE = 2;
    const UPLOAD_ERROR_FILE_SIZE = 3;
    const UPLOAD_ERROR_WRONG_FILE = 4;
    const UPLOAD_ERROR_FILE_RESOLUTION = 2;
    const CHECKS_ERROR_TYPE = 99;
    const CHECKS_ERROR_SIZE = 98;
    const CHECKS_ERROR_RESOLUTION = 97;
    
    /**
     * check, if a file upload is valid.
     * 
     * @param array $_file Part of $_FILES, eg $_FILES['picture']
     * @param array $_checks
     * @return type
     */
    public function checkUploadedFile($_file, $_checks) {

        // check filetype
        if(isset($_checks['type'])) {
            // is check correct set?
            if(!is_array($_checks['type'])) {
                return fileModel::CHECKS_ERROR_TYPE;
            }
            // is type correct?
            if(!in_array($_file['type'], $_checks['type'])) {
                return fileModel::UPLOAD_ERROR_FILE_FILETYPE;
            }
        }
        
        // check filesize
        if(isset($_checks['size'])) {
            // is check correct set?
            if(!is_int($_checks['size'])) {
                return fileModel::CHECKS_ERROR_SIZE;
            }
            // is size correct?
            if($_file['size'] > $_checks['size'] ) {
                return fileModel::UPLOAD_ERROR_FILE_SIZE;
            }
        }
        
        // check picture min resolution
        if(isset($_checks['min_resolution'])) {
            // is check correct set?
            if(!is_array($_checks['min_resolution'])) {
                return fileModel::CHECKS_ERROR_RESOLUTION;
            }

        }

        // check picture max resolution
        if(isset($_checks['max_resolution'])) {
            // is check correct set?
            if(!is_array($_checks['max_resolution'])) {
                return fileModel::CHECKS_ERROR_RESOLUTION;
            }

        }
        
        // check uploaded file
        if(is_uploaded_file($_file['tmp_name']) === false) {
            return fileModel::UPLOAD_ERROR_WRONG_FILE;
        }

        return fileModel::UPLOAD_OK;
    }
    
    
    public function saveFileInData($_type='mail', $_id, $_file) {
        
        if(!in_array($_type, array('mail','user'))) {
            return false;
        }

        // build complete path to file
        $filename = PATH_DATA.$_type;
        if(!is_dir($filename)) {
            mkdir($filename);
            chmod($filename, 0775);
        }
        $digit = substr($_id, strlen($_id)-1, 1);
        $filename .= '/'.$digit;
        if(!is_dir($filename)) {
            mkdir($filename);
            chmod($filename, 0775);
        }
        $filename .= '/'.$_id;
        if(!is_dir($filename)) {
            mkdir($filename);
            chmod($filename, 0775);
        }

        // move file
        $filename .= '/'.$_file['name'];
        if(!move_uploaded_file($_file['tmp_name'], $filename)) {
            return false;
        }
        
        return $filename;
        
    }
    
}
