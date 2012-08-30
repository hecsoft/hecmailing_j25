<?php
/**
* @version 1.7.4
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

$task = JRequest::getVar('task','');

// Browse server webservice ...
if ($task=="getdir")
{
    $user = JFactory::getUser();
    $user->guest==0 or die("|NOT ALLOWED|");
		$ref = $_SERVER['HTTP_REFERER'];
		$uri = $_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
		$ref_tab = split('/', $ref);
		$ser_tab = split('/', $uri);
		$uri_serveur='';
		$j=2;
		$ok=true;

		for ($i=0;$i<count($ser_tab)-4;$i++)
		{
			if ($ref_tab[$j]!=$ser_tab[$i])
			{
				$ok=false;
				break;
			}
			$j++;
		}
		if ($ok)
		{
			if (array_key_exists("dir", $_POST))
			{
				$dir = $_POST["dir"];
			}
			else 
			{
				$dir="";
			}
			$params = &JComponentHelper::getParams( 'com_hecmailing' );
			$root = realpath(JPATH_ROOT).DS.$params->get('browse_path','images/stories');
			if ($dir != '')
			{
				echo $dir.'|';
				$dir = $root . $dir;
			}
			else
			{
				echo '|';
				$dir=$root;
			}
			echo '@..|';
			// Open a known directory, and proceed to read its contents
			if (is_dir($dir)) 
			{
			   if ($dh = opendir($dir)) 
         {
         		while (($file = readdir($dh)) !== false) 
            {
           		if (is_dir($dir .'/'. $file))
           		{
           				if ($file !='.' && $file!='..')
            					echo '@'.$file. "|";
              }
            }
            closedir($dh);
    		}
  			if ($dh = opendir($dir)) 
        {
        		while (($file = readdir($dh)) !== false) 
            {
            		if (!is_dir($dir .'/'. $file))
            		{
            				if ($file !='.' && $file!='..')
            						echo $file. "|";
            	  }
            }
         		closedir($dh);
         }
			}
		}
		else
		{
			echo "|NOT ALLOWED|";
		}
		exit;
	}
// END Browse server webservice ...

require_once (JPATH_COMPONENT.DS.'controller.php');
$controller = new hecMailingController();
$controller->execute(JRequest::getVar('task'));
$controller->redirect(); 

?> 