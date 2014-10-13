<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\modules\bbs\commands;

/**
 * Snatch all messages for delivery and assemble packages for sending
 *
 * @author dirk
 */
class snatchCommand
{
    
    protected $app;
    
    public function __construct($_app)
    {
        $this->app = $_app;
    }
    
    public function run() {
        
        $mailModel = new \Application\modules\bbs\models\mailModel($this->app);
//        print_r($mailModel->getMaillist('', ''));
        
        
    }
    
}

?>
