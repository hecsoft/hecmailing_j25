<?php
/**
* @version 0.0.1
* @package hecMailing for Joomla
* @copyright Copyright (C) 2008 Hecsoft All rights reserved.
* @license GNU/GPL
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
  /* No direct access */
   defined ('_JEXEC') or die ('restricted access');
   
   require_once (JPATH_COMPONENT.DS.'controller.php');

	 $controller = new hecMailingController();
	
	 $controller->execute(JRequest::getVar('task'));
	 $controller->redirect(); 
?> 