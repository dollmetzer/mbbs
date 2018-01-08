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

namespace Application\modules\users\controllers;

/**
 * Class admingroupController
 *
 * @author Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @copyright 2016-2017 Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @package zzap_app
 * @subpackage users
 */
class admingroupController extends \Application\modules\core\controllers\Controller
{

    /**
     * @var array $accessGroups For every action name is an array of allowed user groups
     */
    public $accessGroups = array(
        'index' => 'administrator',
        'details' => 'administrator',
        'new' => 'administrator',
        'edit' => 'administrator',
        'delete' => 'administrator',
        'search' => 'administrator',
    );


    /**
     * Method is called before any controller action.
     * Overload in the application controller to use
     */
    public function before()
    {

        $this->view->content['searchurl'] = $this->buildURL('users/admingroup/search');
        $this->view->content['searchtext'] = $this->lang('txt_group_search_placeholder');
        $this->view->theme = 'backend';

    }

    /**
     * Show a list of all groups with pagination and sorting
     */
    public function indexAction()
    {

        $groupModel = new \Application\modules\users\models\groupModel($this->config);

        $columns = $this->getColumns();
        $table = new \dollmetzer\zzaplib\Table($this->request);
        $table->setColumns($columns);

        // calculate pagination
        $page = 0;
        if (sizeof($this->request->params) > 0) {
            $page = (int)$this->request->params[0];
        }
        $table->page = $page;
        $entriesPerPage = 10;
        $table->entriesPerPage = $entriesPerPage;
        $table->calculateMaxPage($groupModel->getListEntries());
        $first = $page * $entriesPerPage;
        $table->urlPage = 'users/admingroup/index';

        $table->urlSort = 'users/admingroup/sort';
        $table->urlNew = 'users/admingroup/new';
        $table->urlDetails = 'users/admingroup/details';
        $table->urlEdit = 'users/admingroup/edit';
        $table->urlDelete = 'users/admingroup/delete';

        // sorting
        $sortColumn = $this->session->sortGroupCol;
        if (!$sortColumn) {
            $sortColumn = 'name';
        }
        $table->sortColumn = $sortColumn;
        $sortDirection = $this->session->sortGroupDir;
        if (!$sortDirection) {
            $sortDirection = 'asc';
        }
        $table->sortDirection = $sortDirection;

        // get content from db
        $table->setRows($groupModel->getList($first, $entriesPerPage, $sortColumn, $sortDirection));

        $this->view->content['table'] = $table;
        $this->view->content['title'] = $this->lang('title_groups');

    }

    /**
     * Show details of a group
     */
    public function detailsAction()
    {

        if (sizeof($this->request->params) < 1) {
            $this->request->forward($this->buildUrl('users/admingroup/index/0'),
                $this->lang('error_core_parameter_missing'),
                'error');
        }
        $gid = (int)$this->request->params[0];

        $groupModel = new \Application\modules\users\models\groupModel($this->config);
        $group = $groupModel->read($gid);
        if (empty($group)) {
            $this->request->forward($this->buildUrl('users/admingroup/index/0'),
                $this->lang('error_core_illegal_parameter'),
                'error');
        }

        $this->view->theme = 'backend';
        $this->view->content['title'] = $this->lang('title_details');
        $this->view->content['group'] = $group;

    }

    /**
     * Create a new group
     */
    public function newAction()
    {

        $group = array(
            'id' => 0,
            'name' => '',
            'description' => '',
            'active' => 1
        );

        $form = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name = 'groupform';
        $form->fields = $this->getGroupformFields($group);

        if ($form->process()) {

            $values = $form->getValues();

            // check, if groupname already exists
            $groupModel = new \Application\modules\users\models\groupModel($this->config);
            $oldGroup = $groupModel->getByName($values['name']);
            if (!empty($oldGroup)) {
                $form->fields['name']['error'] = $this->lang('form_error_group_already_exists');
                $form->hasErrors = true;
            }

            if ($form->hasErrors === false) {

                // save group
                $data = array(
                    'active' => $values['active'],
                    'protected' => 0,
                    'name' => $values['name'],
                    'description' => $values['description'],
                );
                $gid = $groupModel->create($data);

                $this->request->forward($this->buildURL('users/admingroup'),
                    sprintf($this->lang('msg_group_created'), $values['name']), 'message');

            }

        }

        $this->view->content['title'] = $this->lang('title_new');
        $this->view->content['form'] = $form->getViewdata();
        $this->view->content['group'] = $group;

    }

    /**
     * Edit a group
     */
    public function editAction()
    {

        if (sizeof($this->request->params) < 1) {
            $this->request->forward($this->buildUrl('users/admingroup/index/0'),
                $this->lang('error_core_parameter_missing'),
                'error');
        }
        $gid = (int)$this->request->params[0];

        $groupModel = new \Application\modules\users\models\groupModel($this->config);
        $group = $groupModel->read($gid);
        if (empty($group)) {
            $this->request->forward($this->buildUrl('users/admingroup/index/0'),
                $this->lang('error_core_illegal_parameter'),
                'error');
        }

        $form = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name = 'groupform';
        $form->fields = $this->getGroupformFields($group);

        if ($form->process() && empty($group['protected'])) {

            $values = $form->getValues();

            // check, if groupname already exists
            $groupModel = new \Application\modules\users\models\groupModel($this->config);
            $oldGroup = $groupModel->getByName($values['name']);
            if (!empty($oldGroup)) {
                if ($oldGroup['id'] != $gid) {
                    $form->fields['name']['error'] = $this->lang('form_error_group_already_exists');
                    $form->hasErrors = true;
                }
            }

            if ($form->hasErrors === false) {

                // save group
                $data = array(
                    'active' => $values['active'],
                    'name' => $values['name'],
                    'description' => $values['description'],
                );
                $groupModel->update($gid, $data);

                $this->request->forward($this->buildURL('users/admingroup/details/' . $gid),
                    $this->lang('msg_group_updated'), 'message');

            }

        }

        $this->view->content['title'] = $this->lang('title_edit');
        $this->view->content['form'] = $form->getViewdata();

    }

    /**
     * Delete a group
     */
    public function deleteAction()
    {

        if (sizeof($this->request->params) < 1) {
            $this->forward($this->buildUrl('users/admingroup/index/0'), $this->lang('error_core_parameter_missing'),
                'error');
        }
        $gid = (int)$this->request->params[0];

        $groupModel = new \Application\modules\users\models\groupModel($this->config);
        $group = $groupModel->read($gid);

        if (empty($group)) {
            $this->forward($this->buildUrl('users/admingroup/index/0'), $this->lang('error_core_illegal_parameter'),
                'error');
        }
        if (!empty($group['protected'])) {
            $this->forward($this->buildUrl('users/admingroup/index/0'), $this->lang('error_delete_not_allowed'),
                'error');
        }

        $groupModel->delete($gid);
        $this->forward($this->buildUrl('users/admingroup/index/0'),
            sprintf($this->lang('msg_group_deleted'), $group['name']), 'message');

    }


    public function searchAction()
    {

        $searchterm = '';

        if (!empty($_POST['searchterm'])) {

            $searchterm = htmlentities(trim($_POST['searchterm']));
            $searchterm = str_replace('*', '%', $searchterm);

            $groupModel = new \Application\modules\users\models\groupModel($this->config);

            // set table columns
            $columns = $this->getColumns();
            $table = new \dollmetzer\zzaplib\Table();
            $table->setColumns($columns);

            // calculate pagination
            $page = 0;
            if (sizeof($this->request->params) > 0) {
                $page = (int)$this->request->params[0];
            }
            $table->page = $page;
            $entriesPerPage = 10;
            $table->entriesPerPage = $entriesPerPage;

            $table->calculateMaxPage($groupModel->getSearchEntries($searchterm));
            $first = $page * $entriesPerPage;
            $table->urlPage = 'users/admingroup/search';
            $table->urlSort = 'users/admingroup/sort';
            $table->urlNew = 'users/admingroup/new';
            $table->urlDetails = 'users/admingroup/details';
            $table->urlEdit = 'users/admingroup/edit';
            $table->urlDelete = 'users/admingroup/delete';

            // sorting
            $sortColumn = $this->session->sortUserCol;
            if (!$sortColumn) {
                $sortColumn = 'name';
            }
            $table->sortColumn = $sortColumn;
            $sortDirection = $this->session->sortUserDir;
            if (!$sortDirection) {
                $sortDirection = 'asc';
            }
            $table->sortDirection = $sortDirection;
            $table->setRows($groupModel->search($searchterm, $first, $entriesPerPage, $sortColumn, $sortDirection));

            $this->view->content['table'] = $table;

        }

        $this->view->content['title'] = $this->lang('title_group_search');
        $this->view->content['searchterm'] = $searchterm;

    }


    /**
     * Returns the columns definition array for the group table
     *
     * @return array
     */
    protected function getColumns()
    {

        return array(
            'id' => array(
                'type' => 'hidden',
            ),
            'protected' => array(
                'type' => 'hidden',
            ),
            'active' => array(
                'type' => 'active',
                'sortable' => true,
                'width' => '5%',
            ),
            'name' => array(
                'type' => 'text',
                'sortable' => true,
                'width' => '30%',
            ),
            'description' => array(
                'type' => 'text',
                'width' => '50%',
            ),
            'details' => array(
                'type' => 'details',
                'width' => '5%',
            ),
            'edit' => array(
                'type' => 'edit',
                'width' => '5%',
            ),
            'delete' => array(
                'type' => 'delete',
                'width' => '5%',
            ),
        );

    }

    /**
     * Get the definition array for the group form
     *
     * @param array $_group
     * @return array Field definition
     */
    protected function getGroupformFields(array $_group)
    {

        $form = array(
            'id' => array(
                'type' => 'hidden',
                'value' => $_group['id'],
            ),
            'name' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
                'value' => $_group['name'],
            ),
            'description' => array(
                'type' => 'text',
                'maxlength' => 32,
                'value' => $_group['description'],
            ),
            'active' => array(
                'type' => 'checkbox',
                'value' => $_group['active'],
            ),
            'submit' => array(
                'type' => 'submit',
            ),
        );

        if (!empty($_group['protected'])) {
            foreach ($form as $name => $field) {
                $form[$name]['readonly'] = true;
            }
        }

        return $form;

    }

}