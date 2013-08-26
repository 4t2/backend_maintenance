<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Lingo4you 2013
 * @author     Mario Müller <http://www.lingolia.com/>
 * @version    1.0.1
 * @package    BackendMaintenance
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

class BackendMaintenanceHook extends \Backend
{
	public function __construct()
	{
		if (TL_MODE == 'BE' && $GLOBALS['TL_CONFIG']['backendMaintenance'] === true)
		{
			$GLOBALS['TL_CSS'][] = 'system/modules/backend_maintenance/assets/maintenance.css';
		}

		parent::__construct();
	}

	public function outputBackendTemplateHook($strContent, $strTemplate)
	{
		$this->import('BackendUser', 'User');

		if ($this->User->isAdmin)
		{
			$strContent = preg_replace('~(<div id="header">\s*<h1.*)(</h1>)~isU', '$1 <strong style="color:red">['.$GLOBALS['TL_LANG']['backend_maintenance']['title'].']</strong>$2', $strContent);
		}
		elseif ($this->User->id > 0)
		{
			$strContent = str_ireplace('<h1 class="main_headline">', '<h1>', $strContent);
			$strContent = str_ireplace(
				'<div id="main">',
				'<div id="main"><h1 class="main_headline">'.$GLOBALS['TL_LANG']['backend_maintenance']['title'].'</h1><p style="color:red;margin:2em;">'.sprintf($GLOBALS['TL_LANG']['backend_maintenance']['message'], $GLOBALS['TL_CONFIG']['adminEmail']).'</p></div><div style="display:none">',
				$strContent);
		}

		return $strContent;
	}
}
