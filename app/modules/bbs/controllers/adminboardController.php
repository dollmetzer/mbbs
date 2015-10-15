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

namespace Application\modules\bbs\controllers;

/**
 * BBS Board Admin Controller
 * 
 * Methods for the administration of Bulletion Boards
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage bbs
 */
class adminboardController extends \Application\modules\core\controllers\Controller
{
    /**
     * @var array $accessGroups
     */
    protected $accessGroups = array(
        'add' => array('administrator'),
        'edit' => array('administrator'),
        'delete' => array('administrator')
    );

    /**
     * add a new board
     */
    public function addAction()
    {

        if (sizeof($this->app->params) < 1) {
            $this->app->forward($this->buildURL('/bbs/board'),
                $this->lang('error_missing_parameter'), 'error');
        }
        $id = $this->app->params[0];

        // todo: exist parent id
        $boardModel = new \Application\modules\bbs\models\boardModel($this->app);
        if ($id != 0) {
            $board = $boardModel->read($id);
            if (empty($board)) {
                $this->app->forward($this->buildURL('/bbs/board'),
                    $this->lang('error_illegal_parameter'), 'error');
            }
        }

        $form         = new \dollmetzer\zzaplib\Form($this->app);
        $form->name   = 'mailform';
        $form->fields = array(
            'board' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32
            ),
            'description' => array(
                'type' => 'text',
                'required' => true,
                'rows' => 8,
                'maxlength' => 255
            ),
            'content' => array(
                'type' => 'checkbox',
                'value' => 'on'
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => $this->lang('link_save')
            )
        );

        if ($form->process()) {

            $values = $form->getValues();

            $content = 0;
            if (!empty($values['content'])) $content = 1;

            $data = array(
                'parent_id' => $id,
                'content' => $content,
                'name' => $values['board'],
                'description' => $values['description']
            );
            $boardModel->create($data);
            $this->app->forward($this->buildURL('/bbs/board/list/'.$id));
        }
        $this->app->view->content['form']     = $form->getViewdata();
        $this->app->view->content['nav_main'] = 'board';
        $this->app->view->content['title']    = $this->lang('title_board_add');
        $this->app->view->template            = 'modules/bbs/views/web/adminboard/edit.php';
    }

    /**
     * edit a board
     */
    public function editAction()
    {

        if (sizeof($this->app->params) < 1) {
            $this->app->forward($this->buildURL('/bbs/board'),
                $this->lang('error_missing_parameter'), 'error');
        }
        $id = $this->app->params[0];

        $boardModel = new \Application\modules\bbs\models\boardModel($this->app);
        $board      = $boardModel->read($id);
        if (empty($board)) {
            $this->app->forward($this->buildURL('/bbs/board'),
                $this->lang('error_illegal_parameter'), 'error');
        }
        $boardEntries = $boardModel->countEntries($id);

        $form         = new \dollmetzer\zzaplib\Form($this->app);
        $form->name   = 'boardform';
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
            'entries' => array(
                'type' => 'static',
                'value' => $boardEntries
            ),
            'content' => array(
                'type' => 'checkbox',
                'value' => $board['content']
            ),
            'submit' => array(
                'type' => 'submit',
                'value' => $this->lang('link_save')
            )
        );
        if ($boardEntries > 0) {
            $form->fields['content']['type']  = 'hidden';
            $form->fields['content']['value'] = true;
        }

        if ($form->process()) {

            $values = $form->getValues();
            $data   = array(
                'name' => $values['board'],
                'description' => $values['description']
            );
            if ($values['content'] === true) {
                $data['content'] = 1;
            } else {
                // check, if board already contains articles
                if ($boardEntries > 0) {
                    $data['content'] = 1;
                } else {
                    $data['content'] = 0;
                }
            }
            $boardModel->update($id, $data);
            $this->app->forward($this->buildURL('/bbs/board/list/'.$board['parent_id']),
                $this->lang('msg_board_saved'), 'message');
        }
        $this->app->view->content['form']     = $form->getViewdata();
        $this->app->view->content['nav_main'] = 'board';
        $this->app->view->content['title']    = $this->lang('title_board_edit');
    }

    /**
     * delete an empty board
     */
    public function deleteAction()
    {

        if (sizeof($this->app->params) < 1) {
            $this->app->forward($this->buildURL('/bbs/board'),
                $this->lang('error_missing_parameter'), 'error');
        }
        $id = $this->app->params[0];

        $boardModel = new \Application\modules\bbs\models\boardModel($this->app);
        $board      = $boardModel->read($id);
        if (empty($board)) {
            $this->app->forward($this->buildURL('/bbs/board'),
                $this->lang('error_illegal_parameter'), 'error');
        }

        if ($boardModel->countEntries($id) > 0) {
            $this->app->forward($this->buildURL('/bbs/board'),
                $this->lang('error_board_not_empty'), 'error');
        }

        $boardModel->delete($id);
        $this->app->forward($this->buildURL('/bbs/board'),
            $this->lang('error_board_deleted'), 'message');
    }
}