<?php
 
/**
* @version 0.6.0
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
* 		0.6.0 : Ajout fonctionnalite contact
*		0.5.0 : Correction probleme adresse/nom envoye par
*						Sauvegarde des emails envoyes
*		0.4.0 : Correction suppression item dans groupe
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
class ModelhecMailingContact extends JModel 
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
	 * Method to get email list from a group
	 *
	 * @access	public
	 * @param	int Group Identifier
	 * @param int useprofile => if 1 send email only if JUser sendEmail
	 *                 field is 1 
	 * @return array [email,name]     	 
	 */
   function getMailAdrFromGroupe($groupe, $useprofile)
   {
      $db=$this->getDBO();
      
      
      if ($groupe>0)
      {
      	if (intval($useprofile)==1)
	          $useprofile= " AND u.sendEmail=1 ";
	      else
	          $useprofile="";
	      // Cas des id user joomla
	      $query = "SELECT email, name
	                FROM #__users u inner join #__hecmailing_groupdetail gd ON u.id=gd.gdet_id_value AND gd.gdet_cd_type=2
	                WHERE gd.grp_id_groupe=".$groupe. $useprofile;
	      // Cas des username
	      $query .= " UNION SELECT email, name
	                FROM #__users u inner join #__hecmailing_groupdetail gd ON u.username=gd.gdet_vl_value AND gd.gdet_cd_type=1
	                WHERE gd.grp_id_groupe=".$groupe. $useprofile;
	      // Cas des groupes joomla
	      $query .= " UNION SELECT email, name
	                FROM #__users u inner join #__hecmailing_groupdetail gd ON u.usertype=gd.gdet_vl_value AND gd.gdet_cd_type=3
	                WHERE gd.grp_id_groupe=".$groupe. $useprofile;
	      // Cas des adresse e-mail
	      $query .= " UNION SELECT gd.gdet_vl_value as email, gd.gdet_vl_value as name
	                FROM #__hecmailing_groupdetail gd 
	                WHERE gd.gdet_cd_type=4 AND gd.grp_id_groupe=".$groupe;
	    }
	    else	/* Tous les utilisateurs de la base */
	    {
	    	if (intval($useprofile)==1)
	          $useprofile= " WHERE u.sendEmail=1 ";
	      else
	          $useprofile="";
	    	$query = "SELECT email, name
	                FROM #__users u " . $useprofile;
	    }
	    
                              
      $db->setQuery($query);
      if (!$rows = $db->loadRowList())
      {
          return false;
      }
      
      return $rows;
   }

      
    /**
	 * Method to get contact list as HTML select
	 *
	 * @access	public
	 * @return array of Html option     	 
	 */
   function getContacts()
   {
      $db=$this->getDBO();
      $query = "SELECT ct_id_contact,ct_nm_contact, ct_vl_info FROM #__hecmailing_contact order by ct_nm_contact";
                              
      $db->setQuery($query);
      if (!$rows = $db->loadRowList())
      {
          return false;
      }
     $val = array();
     $infos = array();
     $val[] = JHTML::_('select.option', 0, JText::_('SET_CONTACT'), 'ct_id_contact', 'ct_nm_contact');
     
     foreach($rows as $r)
     {
        $val[] = JHTML::_('select.option', $r[0], $r[1], 'ct_id_contact', 'ct_nm_contact');
        $infos[] = $r[2];
        $id[] = $r[0];
     }
     return array($val,$infos, $id);

   }
   
	/**
	 * Method to get contact list as HTML select
	 *
	 * @access	public
	 * @param $idcontact : int Contact Id
	 * @return array of Html option     	 
	 */
   function getContactInfo($idcontact)
   {
      $db=$this->getDBO();
      $query = "SELECT ct_id_contact,grp_id_groupe,	ct_nm_contact ,	ct_cm_contact ,ct_vl_info 
      	From #__hecmailing_contact Where ct_id_contact="+$idcontact;
                              
      $db->setQuery($query);
      if (!$data = $db->loadObject())
      {
          return false;
      }
     
     return $data;

   }

      
} 

?> 

