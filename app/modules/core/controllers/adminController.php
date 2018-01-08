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
 *
 * @author Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @copyright 2016-2017 Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @package zzap_app
 * @subpackage core
 */
class adminController extends Controller
{

    /**
     * @var array $accessGroups For every action name is an array of allowed user groups
     */
    public $accessGroups = array(
        'index' => 'administrator',
        'test' => 'administrator',
        'form' => 'administrator',
        'deletecache' => 'administrator',
    );


    /**
     * Method is called before any controller action.
     * Overload in the application controller to use
     */
    public function before()
    {

        $this->view->content['searchtext'] = $this->lang('txt_search_placeholder');
        $this->view->theme = 'backend';

    }

    /**
     * Show admin dashboard
     */
    public function indexAction()
    {

        $modules = $this->request->getModuleList(false);
        $this->view->content['modules'] = $modules;

        $overviewAlerts = array();
        $overviewTasks = array();
        $overviewMessages = array();


        $this->view->content['title'] = $this->lang('title_dashboard');

        $this->view->content['link_to_message'] = '/message/admin/view/';
        $this->view->content['link_to_messages'] = '/message/admin';

        $this->view->content['overviewMessages'] = $overviewMessages;
        $this->view->content['overviewTasks'] = $overviewTasks;
        $this->view->content['overviewAlerts'] = $overviewAlerts;

    }

    public function testAction()
    {

        $this->view->content['title'] = 'Test Page';


        $overviewAlerts = array(
            array(
                'name' => 'Neuer Kommentar',
                'time' => '2017-01-05 17:12:14',
                'url' => '/alerts/admin/view/745',
                'icon' => 'fa-comment'
            ),
            array(
                'name' => '3 neue Follower',
                'time' => '2017-01-05 17:03:12',
                'url' => '/alerts/admin/view/233',
                'icon' => 'fa-twitter'
            ),
            array(
                'name' => 'Nachricht gesendet',
                'time' => '2017-01-05 16:46:27',
                'url' => '/alerts/admin/view/83',
                'icon' => 'fa-envelope'
            ),
            array(
                'name' => 'Neuer Task',
                'time' => '2017-01-05 13:33:23',
                'url' => '/alerts/admin/view/63',
                'icon' => 'fa-tasks'
            ),
            array(
                'name' => 'Server Neustart',
                'time' => '2017-01-05 00:45:02',
                'url' => '/alerts/admin/view/34',
                'icon' => 'fa-upload'
            ),
        );
        $this->view->content['link_to_alerts'] = '/alerts/admin';
        $this->view->content['overviewAlerts'] = $overviewAlerts;


        $overviewTasks = array(
            array(
                'name' => 'In den Spiegel schauen',
                'progress' => 30,
                'url' => '/tasks/admin/view/986',
                'type' => 'success',
            ),
            array(
                'name' => 'Gelangweilt gucken',
                'progress' => 70,
                'url' => '/tasks/admin/view/446',
                'type' => 'info',
            ),
            array(
                'name' => 'Heise lesen',
                'progress' => 50,
                'url' => '/tasks/admin/view/376',
                'type' => 'warning',
            ),
            array(
                'name' => 'HaX0R News',
                'progress' => 60,
                'url' => '/tasks/admin/view/773',
                'type' => 'danger',
            ),
        );
        $this->view->content['link_to_tasks'] = '/tasks/admin';
        $this->view->content['overviewTasks'] = $overviewTasks;


        $overviewMessages = array(
            array(
                'name' => 'Claus Santnji',
                'time' => '2016-12-24 16:12:14',
                'url' => '/message/admin/view/451',
                'shorttext' => 'So, der erste Kunde ist bedient. Das wird heute ...'
            ),
            array(
                'name' => 'Clara Blikk',
                'time' => '2016-12-24 14:37:12',
                'url' => '/message/admin/view/375',
                'shorttext' => 'Der Hein gelaubt noch an den Weihnachtsmann. Ist das nicht süß?'
            ),
            array(
                'name' => 'Hein Doof',
                'time' => '2016-12-24 14:00:00',
                'url' => '/message/admin/view/373',
                'shorttext' => 'In zwei Stunden kommt der Weihnachtsmann'
            )
        );
        $this->view->content['link_to_messages'] = '/message/admin';
        $this->view->content['overviewMessages'] = $overviewMessages;


        $this->view->theme = 'backend';

        $newJS = array(
            // Morris Charts JavaScript
            "/backend/vendor/raphael/raphael.min.js",
            "/backend/vendor/morrisjs/morris.min.js",
            "/backend/vendor/morris-data.js",
            // Flot Charts JavaScript
            "/backend/vendor/flot/excanvas.min.js",
            "/backend/vendor/flot/jquery.flot.js",
            "/backend/vendor/flot/jquery.flot.pie.js",
            "/backend/vendor/flot/jquery.flot.resize.js",
            "/backend/vendor/flot/jquery.flot.time.js",
            "/backend/vendor/flot-tooltip/jquery.flot.tooltip.min.js",
            "/backend/data/flot-data.js"
        );
        $this->view->addJS($newJS);
        $this->view->addCSS('/backend/vendor/morrisjs/morris.css');

    }

    public function formAction()
    {

        $form = new \dollmetzer\zzaplib\Form($this->request, $this->view);
        $form->name = 'loginform';
        $form->fields = array(
            'handle' => array(
                'type' => 'text',
                'required' => true,
                'maxlength' => 32,
                'helptext' => $this->lang('form_help_handle'),
                'placeholder' => 'platzhalter'
            ),
            'password' => array(
                'type' => 'password',
                'required' => true,
                'maxlength' => 32,
                'help' => 'Das ist ein alter helptext',
            ),
            'lalala' => array(
                'type' => 'hidden',
                'value' => 'mhhhhh...'
            ),
            'statisch' => array(
                'type' => 'static',
                'value' => 'Statischer Text'
            ),
            'anaus' => array(
                'type' => 'checkbox',
                'description' => 'Soll das an sein?',
                'value' => 1
            ),
            'einszweidrei' => array(
                'type' => 'radio',
                'options' => array(
                    1 => 'Eins',
                    2 => 'Zwei',
                    3 => 'Drei'
                ),
                'value' => 2
            ),
            'nextarea' => array(
                'type' => 'divider'
            ),
            'aussuche' => array(
                'type' => 'select',
                'options' => array(
                    1 => 'Eins',
                    2 => 'Zwei',
                    3 => 'Drei'
                ),
                'size' => 3,
                'multiple' => true,
                'value' => 2,
            ),
            'longtext' => array(
                'type' => 'textarea',
                'rows' => '4',
                'placeholder' => 'schreib mal wieder'
            ),
            'hochladen' => array(
                'type' => 'file',
            ),
            'submit' => array(
                'type' => 'submit'
            ),
            'reset' => array(
                'type' => 'reset'
            ),

        );

        if ($form->process()) {

            $values = $form->getValues();
            var_dump($values);
            die();

        }

        $this->view->content['title'] = 'Form test';
        $this->view->theme = 'backend';
        $this->view->content['form'] = $form->getViewdata();

    }


}