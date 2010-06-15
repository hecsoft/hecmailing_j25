<?php 
defined('_JEXEC') or die ('restricted access'); 

jimport('joomla.application.component.view'); 
jimport('joomla.html.toolbar');
class hecMailingViewForm extends JView 
{ 
    
   function display ($tpl=null) 
   { 
      global $option,$mainframe; 
     
   
      $currentuser= &JFactory::getUser();
      $pparams = &$mainframe->getParams();
			
			$model = & $this->getModel(); 
      $groupe=0; 
      if ($pparams->get('send_all','0')=='1')
      {
        $send_all = true;
      }
      else
      {
        $send_all=false;
      }
      
      if ($pparams->get('backup_mail','0')=='1')
      {
        $backup_mail = "checked=\"checked\"";
        
      }
      else
      {
        $backup_mail="";
      }
      
    if ($pparams->get('default_use_profil','0')=='1')
      {
        $default_use_profil = "checked=\"checked\"";
        
      }
      else
      {
        $default_use_profil="";
      }
      
      if ($pparams->get('image_incorpore','1')=='1')
      {
        $image_incorpore = "checked=\"checked\"";
        
      }
      else
      {
        $image_incorpore="";
      }
      if ($pparams->get('ask_select_group','1')=='1')
      {
        $askselect = true;
        $groupe=-2;
      }
      else
      {
        $askselect=false;
      }
     
   	  $send_all =$pparams->get('send_all','0');
      
      $browse_path = $pparams->get('browse_path','/images/stories');
      $height = $pparams->get('edit_width','400');
      $width = $pparams->get('edit_height','400');
      
      $groupelist = $model->getGroupes($send_all,false, $askselect);
      if (!$groupelist)
      {
        $groupes = JText::_("NO_GROUP");
      }
      else
      {
        
        $groupes = JHTML::_('select.genericlist',  $groupelist, 'groupe', 'class="inputbox" size="1"', 'grp_id_groupe', 'grp_nm_groupe', intval($groupe));
      }
      
      $tmpfrom = $model->getFrom();
      $from = JHTML::_('select.genericlist',  $tmpfrom, 'from', 'class="inputbox" size="1"', 'email', 'name');
     $idmsg = JRequest::getInt('idTemplate', 0, 'post');
     $idlog = JRequest::getInt('idlog', 0);
		  $savedlist = $model->getSavedMails();
		  if ($savedlist)
		  {
        #$saved = JHTML::_('select.genericlist',  $savedlist, 'saved', 'class="inputbox" size="1" onchange="javascript:submitbutton(\'load\');"', 'msg_id_message', 'msg_vl_subject', intval($idmsg));
        $saved = JHTML::_('select.genericlist',  $savedlist, 'saved', 'class="inputbox" size="1" ', 'msg_id_message', 'msg_lb_message', intval($idmsg));
      }
      else {
       $saved="";}  
      
      if ($idlog>0)
      {
      	
      	$infomsg = $model->getLogDetail($idlog);
      	//$this->assignRef('idmsg', 0);
      	$this->assignRef('idlog', $infomsg->log_id_message);
        $this->assignRef('subject', $infomsg->log_vl_subject);
        $this->assignRef('body', $infomsg->log_vl_body);
        $this->assignRef('attachment', $infomsg->attachment);
        
      }
      else if ($idmsg>0)
      {
        $infomsg = $model->getSavedMail($idmsg);
        $this->assignRef('idmsg', $infomsg[0]);
        $this->assignRef('subject', $infomsg[1]);
        $this->assignRef('body', $infomsg[2]);
        $att=array();
        $this->assignRef('attachment',$att);
      }
      else
      {
      	$att=array();
      	$this->assignRef('attachment',$att);
      }
  
      $this->assignRef('groupes', $groupes);
      $this->assignRef('from', $from);
      $this->assignRef('default_use_profil', $default_use_profil);
      $this->assignRef('saved', $saved);
      $this->assignRef('height', $height);
      $this->assignRef('width', $width);
      $this->assignRef('backup_mail', $backup_mail);
      $this->assignRef('browse_path', $browse_path);
      $this->assignRef('image_incorpore', $image_incorpore);
      $viewLayout = JRequest::getVar( 'layout', 'default' );
	    $this->_layout = $viewLayout;
      
      parent::display($tpl); 
   } 
   
   
} 
?> 
