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
 * The language controller switches the frontend between available languages
 *
 * @author Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL 3.0
 * @copyright 2016 Dirk Ollmetzer (dirk.ollmetzer@ollmetzer.com)
 * @package zzap_app
 * @subpackage core
 */
class languageController extends \dollmetzer\zzaplib\Controller
{

    /**
     * Switch the users current language, if the new language is installed.
     * Afterwards forward to the startpage
     */
    public function switchtoAction()
    {

        if (sizeof($this->request->params) < 1) {
            $this->forward($this->buildUrl(''), $this->lang('error_core_parameter_missing'), 'error');
        }
        $language = $this->request->params[0];

        if (!in_array($language, $this->config['languages'])) {
            $this->forward($this->buildUrl(''), $this->lang('error_core_illegal_parameter'), 'error');
        }

        $this->session->user_language = $language;

        $this->forward($this->buildUrl(''));

    }

}