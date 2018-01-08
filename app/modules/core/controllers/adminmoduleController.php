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

namespace Application\modules\core\controllers;

/**
 * Class adminController
 * Administration of application module
 *
 * @author Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @copyright 2016-2017 Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @package zzap_app
 * @subpackage core
 */
class adminmoduleController  extends Controller
{

    /**
     * @var array $accessGroups For every action name is an array of allowed user groups
     */
    public $accessGroups = array(
        'index' => 'administrator',
        'deletecache' => 'administrator',
        'activate' => 'administrator',
        'deactivate' => 'administrator',
    );

    /**
     * Method is called before any controller action.
     * Overload in the application controller to use
     */
    public function before()
    {

        $this->view->theme = 'backend';

    }

    /**
     * Show admin dashboard
     */
    public function indexAction()
    {

        $modules = $this->request->getModuleList(false);
        $this->view->content['modules'] = $modules;

        $this->view->content['title'] = $this->lang('title_modules');

    }

    /**
     * Delete Cache files for navigation and language and forward to admin
     */
    public function deletecacheAction() {

        $this->view->deleteNavigation();
        $this->view->deleteLanguageCore();
        $this->request->module->rebuildConfig();

        $this->forward($this->buildUrl('core/adminmodule'), $this->lang('msg_cache_deleted'), '');

    }

    /**
     * Activate a module
     */
    public function activateAction() {

        if(empty($this->request->params)) {
            $this->request->log('core::adminmoduleController::activateAction() failed. Parameter missing');
            $this->forward($this->buildUrl('core/adminmodule'), $this->lang('error_core_parameter_missing'), 'error');
        }

        $moduleName = $this->request->params[0];
        try {
            $this->request->module->activate($moduleName);
        } catch(\Exception $e) {
            $this->request->log('core::adminmoduleController::activateAction() failed. Flag active for module '.$moduleName.' was not false');
            $this->forward($this->buildUrl('core/adminmodule'), $this->lang('error_module_activate'), 'error');

        }



        $this->view->deleteNavigation();
        $this->view->deleteLanguageCore();

        $this->forward($this->buildUrl('core/adminmodule'), $this->lang('msg_module_activated'), '');

    }

    /**
     * Deactivate a module
     */
    public function deactivateAction() {

        if(empty($this->request->params)) {
            $this->request->log('core::adminmoduleController::deactivateAction() failed. Parameter missing');
            $this->forward($this->buildUrl('core/adminmodule'), $this->lang('error_core_parameter_missing'), 'error');
        }

        $moduleName = $this->request->params[0];
        try {
            $this->request->module->deactivate($moduleName);
        } catch(\Exception $e) {
            $this->request->log('core::adminmoduleController::deactivateAction() failed for module '.$moduleName);
            $this->forward($this->buildUrl('core/adminmodule'), $this->lang('error_module_deactivate'), 'error');
        }



        $this->view->deleteNavigation();
        $this->view->deleteLanguageCore();

        $this->forward($this->buildUrl('core/adminmodule'), $this->lang('msg_module_deactivated'), '');

    }

}