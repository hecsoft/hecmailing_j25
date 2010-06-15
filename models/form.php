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
class ModelhecMailingForm extends JModel 
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
      $block_mode = $this->params->get('send_to_blocked');
      switch ($block_mode)
      {
      	case 0:
      		$blockcond1=" AND u.block=0 ";
      		$blockcond2=True;
      		break;
      	case 1: // YES, IF ALL USERS OR JOOMLA GROUP	
      		$blockcond1=" AND u.block=0 ";
      		$blockcond2=False;
      		break;
      	case 2: // YES, IF USER LIST	
      		$blockcond1="";
      		$blockcond2=True;
      		break;
      	case 3: // YES, FOR ALL	
      		$blockcond1="";
      		$blockcond2=False;
      		break;
      }
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
	                WHERE u.block=0 AND gd.grp_id_groupe=".$groupe. $useprofile.$blockcond1;
	      // Cas des adresse e-mail
	      $query .= " UNION SELECT gd.gdet_vl_value as email, gd.gdet_vl_value as name
	                FROM #__hecmailing_groupdetail gd 
	                WHERE gd.gdet_cd_type=4 AND gd.grp_id_groupe=".$groupe;
	    }
	    else	/* Tous les utilisateurs de la base (Actifs, non blockés) */
	    {
	    	if (intval($useprofile)==1)
	          $useprofile= " WHERE u.sendEmail=1 ".$blockcond2;
	      else
	      {
	      	  if ($blockcond2)
	      	  {
	          	$useprofile=" WHERE u.block=0 ";
	      	  }
	      	  else
	      	  {
	      	  	$useprofile="";
	      	  }
	      	  
	      	}
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
	 * Method to get userType option list
	 *
	 * @access	public
	 * @param	int if 1 add All option
	 * @return array of Html select option of existing user Type     	 
	 */
   function getUserType($tous)
   {
      $db=$this->getDBO();
      $query = "SELECT distinct userType FROM #__users";
                              
      $db->setQuery($query);
      if (!$rows = $db->loadRowList())
      {
          return false;
      }
     $val = array();
     foreach($rows as $r)
     {
        $val[$no][] = JHTML::_('select.option', $r[0], $r[0], 'usertype', 'usertype');

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
   function getGroupes($tous, $save, $askselect)
   {
      $db=$this->getDBO();
      $query = "SELECT grp_id_groupe, grp_nm_groupe FROM #__hecmailing_groups Where published=1 order by grp_nm_groupe";
                              
      $db->setQuery($query);
      if (!$rows = $db->loadRowList())
      {
          return false;
      }
     $val = array();
     $save=false;
     if ($askselect)
     {
        $val[] = JHTML::_('select.option', -2, "{".JText::_('SELECT GROUP')."}", 'grp_id_groupe', 'grp_nm_groupe');
     }
     
     
     if ($save)
     {
        $val[] = JHTML::_('select.option', -1, "{".JText::_('SAVE')."}", 'grp_id_groupe', 'grp_nm_groupe');
     }
     
     if ($tous=='1')
     {
        $val[] = JHTML::_('select.option', 0, '{'.JText::_('ALL_USERS').'}', 'grp_id_groupe', 'grp_nm_groupe');
     }
     foreach($rows as $r)
     {
        $val[] = JHTML::_('select.option', $r[0], $r[1], 'grp_id_groupe', 'grp_nm_groupe');
     }
     
     if ($tous=='2')
     {
        $val[] = JHTML::_('select.option', 0, '{'.JText::_('ALL_USERS').'}', 'grp_id_groupe', 'grp_nm_groupe');
     }
     
     return $val;

   }

    /**
	 * Method to get the mailfrom list
	 *
	 * @access	public
	 * @return array of Html select option of emails     	 
	 */   
    function getFrom()
   {
      global $mainframe;
      $user =&JFactory::getUser();
      $MailFrom 	= $mainframe->getCfg('mailfrom');
      $FromName 	= $mainframe->getCfg('fromname');
      $val = array();
      $val[] = JHTML::_('select.option', $user->email.';'.$user->name, $user->name, 'email', 'name');
      $val[] = JHTML::_('select.option', $MailFrom.';'.$FromName, JText::_('DEFAULT').'('.$FromName.')', 'email', 'name');
       
       return $val;

   }

   /**
	 * Method to know if current logged user is in a mailing group
	 *
	 * @access	public
	 * @param	int Groupe identifier
	 * @return true is current user is in the group and false else     	 
	 */
  function isInGroupe($groupe)
   {
      $db=$this->getDBO();
      $user =&JFactory::getUser();
      $query = "SELECT *
                FROM #__hecmailing_groupdetail gd inner join  #__hecmailing_groups g on gd.grp_id_groupe=g.grp_id_groupe
                WHERE g.grp_nm_groupe=".$db->Quote($groupe)." AND gdet_id_value=".$user->id." AND gdet_cd_type=2";
                                   
      $db->setQuery($query);
      if (!$rows = $db->loadRow())
      {
          return false;
      }
      
      return true;
   }

   /**
	 * Method to get Html select option of saved templates
	 *
	 * @access	public
	 * @return array of Html option     	 
	 */
  function getSavedMails()
  {
        $db=$this->getDBO();
      $query = "SELECT msg_id_message,ifnull(msg_lb_message,msg_vl_subject) FROM #__hecmailing_save";
                              
      $db->setQuery($query);
      if (!$rows = $db->loadRowList())
      {
          return false;
      }
     $val = array();
     $val[] = JHTML::_('select.option', 0, JText::_('NONE'), 'msg_id_message', 'msg_lb_message');
     
     foreach($rows as $r)
     {
        $val[] = JHTML::_('select.option', $r[0], $r[1], 'msg_id_message', 'msg_lb_message');
     }
     return $val;
  }
  
     /**
	 * Method to get a template saved
	 *
	 * @access	public
	 * @param	int Template mail identifier
	 * @return array with Message Id, Subject, Body     	 
	 */
  function getSavedMail($idmsg)
  {
        $db=$this->getDBO();
      $query = "SELECT msg_id_message,msg_vl_subject,msg_vl_body FROM #__hecmailing_save where msg_id_message=".$idmsg;
                              
      $db->setQuery($query);
      if (!$row = $db->loadRow())
      {
          return false;
      }
     return $row;
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

