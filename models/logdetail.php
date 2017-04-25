<?php 
/**
* @version 0.3.0
* @package hecMailing for Joomla
* @copyright Copyright (C) 2009 Hecsoft All rights reserved.
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
*
* Change Log
*		0.3.0 : Prise en charge groupe 0 (tous membres) dans getMailAdrFromGroupe
*		0.1.0 : Version d'origine
*/
defined('_JEXEC') or die ('restricted access'); 

jimport('joomla.application.component.model'); 

/**
 * hecMailing Component Form Model
 *
 * @package		Joomla
 */
class ModelhecMailingLogDetail extends JModel 
{ 
   /**
	 * User id
	 *
	 * @var int
	 */
   var $_id = 0; 

   var $_object=null;
   
   /**
   *    Contructor 
   **/
   function __construct() 

   { 
   	  parent::__construct(); 

   	  $this->params = &JComponentHelper::getParams( 'com_hecmailing' );

      $this->isLog = $this->params->get('Log');

      $this->isLog = true;

      if ($this->isLog)
      {
        $this->_log = &JLog::getInstance('com_hecmailing.log.php');
      }
   } 

   
  /**
	 * Method to write text into component log
	 *
	 * @access	public
	 * @param	string Text to write
	 */
   function Log($text)
   {  
      if ($this->isLog)
      {
        $this->_log->addEntry(array('comment' => $text));
      }
   }



  
    
    /**
	 * Method to get mailing groups as HTML select
	 *
	 * @access	public
	 * @param	int if =1 Add a row for all members
	 * @param int if =1 Add a row for saving
	 * @return array of Html option     	 
	 */
   function getLogDetail($idlog)
   {
      $db=$this->getDBO();
      $query = "SELECT l.log_id_message, l.log_dt_sent,l.log_vl_from,l.log_vl_subject,l.log_vl_body,l.grp_id_groupe,	l.usr_id_user ,
  						l.log_nb_ok,l.log_nb_errors, u.name,u.username, g.grp_nm_groupe,log_vl_mailok,log_vl_mailerr 
										FROM #__hecmailing_log l LEFT JOIN #__hecmailing_groups g ON l.grp_id_groupe=g.grp_id_groupe 
										LEFT JOIN #__users u on l.usr_id_user=u.id Where l.log_id_message=".$idlog;                        
      $db->setQuery($query);
       if (!$row = $db->loadObject())
      {
          return false;
      }
      $query = "SELECT l.log_nm_file
										FROM #__hecmailing_log_attachment l Where l.log_id_message=".$idlog;                        
      $db->setQuery($query);
      $attach = $db->loadObjectList();
      $attlist=array();
      foreach($attach as $r)
      {
      	$attlist[]= $r->log_nm_file;
      }
      $row->attachment = $attlist;
     return $row;
     

   }


} 

?> 

