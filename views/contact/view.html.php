<?php 
defined('_JEXEC') or die ('restricted access'); 

jimport('joomla.application.component.view'); 
jimport('joomla.html.toolbar');
class hecMailingViewContact extends JView 
{ 
    
   function display ($tpl=null) 
   { 
      global $option,$mainframe; 
     
   
      $currentuser= &JFactory::getUser();
      $pparams = &$mainframe->getParams();
			
	  $model = & $this->getModel(); 
      
	  $contact = JRequest::getInt('contact', 0);  
      
      $height = $pparams->get('edit_width','400');
      $width = $pparams->get('edit_height','400');
      $captcha_theme = $pparams->get('captcha_theme','white');
      $captcha_show_logged = $pparams->get('captcha_show_logged','1');
      $publickey = $pparams->get('captcha_public_key','6LexAQwAAAAAANErhkc2zLD3wmsiZWeU1Cstc50_');
      if ($captcha_show_logged =='1')
      	$captcha_show_logged=true;
      else
      	$captcha_show_logged=false;
      $title = $pparams->get('contact_title',JText::_('CONTACT'));
	  $c    = $model->getContacts();
      $contactlist=$c[0];
      $infolist = $c[1]; 
      $infoid = $c[2];
	  if ($contactlist)
	  {
        $contacts = JHTML::_('select.genericlist',  $contactlist, 'contact', 'class="inputbox" size="1" onchange="showInfo(this.value)"', 'ct_id_contact', 'ct_nm_contact', intval($contact));
		        
      }
      else 
      {
       $contacts="";
      }  
      if ($contact>0)
      {
      	$contactinfo = $model->getContactInfo($contact);
      }
      else
      {
      	$contactinfo=false;
      }
      if (!$currentuser->guest)
      {
      	$email = $currentuser->email;
      	$name = $currentuser->name;
      	$lang = $currentuser->getParam('language', '');
      }
      else
      {
      	$email="";
      	$name="";
      	$lang = $currentuser->getParam('language', '');
      }
      /* Recuperer les champs déjà saisis */
      $email = JRequest::getString('email', $email, 'post');
      $name = JRequest::getString('name', $name, 'post');
      $subject = JRequest::getString('subject', '', 'post');
      $body = JRequest::getVar('body', '', 'post', 'string', JREQUEST_ALLOWRAW);
      $logmail 		= JRequest::getString('backup_mail', 0, 'post');
      $this->assignRef('contacts', $contacts);
      $this->assignRef('contact', $contact);
      $this->assignRef('contactinfo', $contactinfo);
      $this->assignRef('infolist', $infolist);
      $this->assignRef('infoid', $infoid);
      $this->assignRef('height', $height);
      $this->assignRef('width', $width);
      $this->assignRef('title', $title);
      $this->assignRef('email', $email);
      $this->assignRef('lang', $lang);
      $this->assignRef('name', $name);
      $this->assignRef('publickey', $publickey);
      $this->assignRef('subject', $subject);
      $this->assignRef('body', $body);
      $this->assignRef('logmail', $logmail);
      $this->assignRef('captcha_theme', $captcha_theme);
      $this->assignRef('captcha_show_logged', $captcha_show_logged);
      $viewLayout = JRequest::getVar( 'layout', 'default' );
	  $this->_layout = $viewLayout;
      
      parent::display($tpl); 
   } 
   
   
} 
?> 
