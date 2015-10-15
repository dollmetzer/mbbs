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

namespace Application\modules\core\controllers;

/**
 * CORE Group Administration Controller
 * 
 * Methods for handling usergroups
 * 
 * @author Dirk Ollmetzer <dirk.ollmetzer@ollmetzer.com>
 * @copyright (c) 2014-2015, Dirk Ollmetzer
 * @package Application
 * @subpackage core
 */
class admingroupController extends \Application\modules\core\controllers\Controller
{
    /**
     * @var type array neccessary access rights
     */
    protected $accessGroups = array(
        'index' => array('administrator'),
        'show' => array('administrator'),
        'edit' => array('administrator'),
        'add' => array('administrator')
    );

    /**
     * List Groups
     */
    public function indexAction()
    {

        $groupModel = new \Application\modules\core\models\groupModel($this->app);

        // pagination
        $listEntries = $groupModel->getListEntries();
        $listLength  = 10;
        $page        = 0;
        if (sizeof($this->app->params) > 0) {
            $page = (int) $this->app->params[0] - 1;
        }
        $maxPages   = ceil($listEntries / $listLength);
        $firstEntry = $page * $listLength;

        $list = $groupModel->getList($firstEntry, $listLength);

        $this->app->view->content['nav_main']            = 'admin';
        $this->app->view->content['title']               = $this->lang('title_admin_group');
        $this->app->view->content['list']                = $list;
        $this->app->view->content['pagination_page']     = $page;
        $this->app->view->content['pagination_maxpages'] = $maxPages;
        $this->app->view->content['pagination_link']     = $this->buildURL('core/admingroup/index/%d');
    }

    /**
     * Show Group Details
     */
    public function showAction()
    {

        if (sizeof($this->app->params) == 0) {
            $this->app->forward($this->buildURL('core/admingroup'),
                $this->lang('error_missing_parameter'), 'error');
        }
        $id = (int) $this->app->params[0];

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        $group      = $groupModel->read($id);

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title']    = $this->lang('title_admin_group');
        $this->app->view->content['group']    = $group;
    }

    /**
     * Edit a group
     */
    public function editAction()
    {

        if (sizeof($this->app->params) == 0) {
            $this->app->forward($this->buildURL('core/admingroup'),
                $this->lang('error_missing_parameter'), 'error');
        }
        $id = (int) $this->app->params[0];

        $groupModel = new \Application\modules\core\models\groupModel($this->app);
        $group      = $groupModel->read($id);

        if (!empty($group['protected'])) {
            $this->app->forward($this->buildURL('core/admingroup/show/'.$id),
                $this->lang('error_protected_group'), 'error');
        }

        $form         = new \dollmetzer\zzaplib\Form($this->app);
        $form->name   = 'addgroup';
        $form->fields = array(
            'name' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 16,
                'value' => $group['name']
            ),
            'description' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 255,
                'value' => $group['description']
            ),
            'active' => array(
                'type' => 'checkbox',
                'value' => $group['active']
            ),
            'save' => array(
                'type' => 'submit',
                'value' => 'save'
            ),
        );

        if ($form->process()) {

            // get user
            $values = $form->getValues();

            $newValues           = array(
                'active' => 0,
                'name' => $values['name'],
                'description' => $values['description']
            );
            if (!empty($values['active'])) $newValues['active'] = 1;

            $groupModel->update($id, $newValues);
            $this->app->forward($this->buildURL('core/admingroup'),
                $this->lang('msg_group_changed'), 'notice');
        }

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title']    = $this->lang('title_admin_groupedit');
        $this->app->view->content['form']     = $form->getViewdata();
    }

    /**
     * Add a new group
     */
    public function addAction()
    {

        $form         = new \dollmetzer\zzaplib\Form($this->app);
        $form->name   = 'addgroup';
        $form->fields = array(
            'name' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 16,
            ),
            'description' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 255,
            ),
            'active' => array(
                'type' => 'checkbox',
                'value' => true
            ),
            'add' => array(
                'type' => 'submit',
                'value' => 'add'
            ),
        );

        if ($form->process()) {

            // get user
            $values = $form->getValues();

            $groupModel = new \Application\modules\core\models\groupModel($this->app);
            $group      = $groupModel->getByName($values['name']);
            if (empty($group)) {

                $active    = 0;
                if (!empty($values['active'])) $active    = 1;
                $newvalues = array(
                    'name' => $values['name'],
                    'description' => $values['description'],
                    'active' => $active
                );

                $id = $groupModel->create($newvalues);
                $this->app->forward($this->buildURL('core/admingroup'),
                    $this->lang('msg_group_added'), 'notice');
            } else {
                $form->fields['name']['error'] = $this->lang('form_error_name_exists');
            }
        }

        $this->app->view->content['nav_main'] = 'admin';
        $this->app->view->content['title']    = $this->lang('title_admin_groupadd');
        $this->app->view->content['form']     = $form->getViewdata();
    }

    /**
     * Delete a group
     */
    public function deleteAction()
    {

        die('delete action');
    }
}