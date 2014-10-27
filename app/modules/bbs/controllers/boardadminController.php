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

namespace Application\modules\bbs\controllers;

/**
 * BBS Board Admin Controller
 * 
 * Methods for the administration of Bulletion Boards
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class boardadminController extends \dollmetzer\zzaplib\Controller
{
    
    /**
     * @var array $accessGroups
     */
    protected $accessGroups = array(
        'add' => array('admin'),
        'edit'  => array('admin'),
        'delete'  => array('admin')
    );
    
    
    /**
     * add a new board
     */
    public function addAction() {

        if(sizeof($this->app->params)<1 ) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_missing_parameter'), 'error');
        }
        $id = $this->app->params[0];

        die('boardadmin:add:'.$id);
        
                $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'mailform';
        $form->fields = array(
            'board' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
                'value' => $board['name']
            ),
            'description' => array(
                'type' => 'text',
                'required' => true,
                'rows' => 8,
                'maxlength' => 255,
                'value' => $board['description']
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => 'change'
            )
        );

        if ($form->process()) {

            $values = $form->getValues();
            var_dump($values);
            die();
        }
        $this->app->view->content['form'] = $form->getViewdata();
        
    }
    
    /**
     * edit a board
     */
    public function editAction() {
        
        if(sizeof($this->app->params)<1 ) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_missing_parameter'), 'error');
        }
        $id = $this->app->params[0];
        
        $boardModel = new \Application\modules\bbs\models\boardModel($this->app);
        $board = $boardModel->read($id);
        if(empty($board)) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_illegal_parameter'), 'error');
        }
        
        $form = new \dollmetzer\zzaplib\Form($this->app);
        $form->name = 'mailform';
        $form->fields = array(
            'board' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
                'value' => $board['name']
            ),
            'description' => array(
                'type' => 'text',
                'required' => true,
                'rows' => 8,
                'maxlength' => 255,
                'value' => $board['description']
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => 'change'
            )
        );

        if ($form->process()) {

            $values = $form->getValues();
            $data = array(
                'name' => $values['board'],
                'description' => $values['description']
            );
            $boardModel->update($id, $data);
            $this->app->forward($this->buildURL('/bbs/board/list/'.$board['parent_id']));
            
        }
        $this->app->view->content['form'] = $form->getViewdata();
        
    }

    /**
     * delete an empty board
     */
    public function deleteAction() {

        if(sizeof($this->app->params)<1 ) {
            $this->app->forward($this->buildURL('/bbs/board'), $this->lang('error_missing_parameter'), 'error');
        }
        $id = $this->app->params[0];

        die('boardadmin:delete:'.$id);
        
        // is board empty?
        
    }

}
