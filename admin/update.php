<?php

defined('_JEXEC') or die('Restricted access');



global $mainframe;

$mainframe->isAdmin() or die('Must be admin to execute!');



/**
* @version 0.4.0
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



/**

 * A class for update functions

 */

class HecMailingUpdate

{

    function update_hecmailing_table()

    {

        // NOTE: It should be harmless to run this function multiple times
        // Get the existing field names

        $db =& JFactory::getDBO();

        $query = "explain #__hecmailing_groupdetail";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        $fields = array();

        foreach ($rows as $row) 
        {
            if ($row->Field=='gdet_id_detail' && $row->Extra == '')
            {
            		echo "<h3>Updating HecMailing Table...</h3>\n";
                echo "&nbsp;&nbsp;&nbsp;Save Group Detail table <br>";
                $query = "Drop Table If Exists tmp_hecmailing_groupdetail";
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseError( 500, "Error deleting groupdetail table: " . $db->stderr() );
                    return false;
                }
                $query = "Create Table tmp_hecmailing_groupdetail As Select * from #__hecmailing_groupdetail";
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseError( 500, "Error copy groupdetail table: " . $db->stderr() );
                    return false;
                }
                $query = "Drop Table #__hecmailing_groupdetail";
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseError( 500, "Error deleting groupdetail table: " . $db->stderr() );
                    return false;
                }
                
                echo "&nbsp;&nbsp;&nbsp;Create Group Detail table <br>";
                $query = "CREATE TABLE IF NOT EXISTS `#__hecmailing_groupdetail` (
          				`grp_id_groupe` int(11) NOT NULL COMMENT 'Id du groupe',
          				`gdet_cd_type` tinyint(4) NOT NULL COMMENT 'Type de detail (1 : UserName, 2 : UserId, 3 : UserType, 4 : E-mail)',
          				`gdet_id_value` int(11) NOT NULL COMMENT 'Code de la valeur',
          				`gdet_vl_value` varchar(50) NOT NULL COMMENT 'E Mail...',
          				`gdet_id_detail` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
        				  PRIMARY KEY (`gdet_id_detail`),
          				KEY `grp_id_groupe` (`grp_id_groupe`)
					       ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Detail des groupe de diffusion'";
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseError( 500, "Error re-creating groupdetail table: " . $db->stderr() );
                    return false;
                }
                
                echo "&nbsp;&nbsp;&nbsp;Insert old data form saved table <br>";
                $query = "Insert Into #__hecmailing_groupdetail (grp_id_groupe,gdet_cd_type,gdet_id_value,gdet_vl_value)
                 Select grp_id_groupe,gdet_cd_type,gdet_id_value,gdet_vl_value
                 From tmp_hecmailing_groupdetail ";
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseError( 500, "Error deleting groupdetail table: " . $db->stderr() );
                    return false;
                }
                
                echo "&nbsp;&nbsp;&nbsp;clean temp table <br>";
                $query = "Drop Table If Exists tmp_hecmailing_groupdetail";
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseError( 500, "Error cleaning temp table: " . $db->stderr() );
                    
                }
                echo "<h3>The hecMailing tables is now up to date. <h3>\n";
                return true;
            }
            

      }

			echo "<h3>The hecMailing tables are already up to date. <h3>\n";
      return true;

    }

}