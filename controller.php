<?php
/**
* @version 0.7.0
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
* ChangeLog :
*   0.9.0		23 mar 2010		Bug # 2970606 Contact : Can't add or edit contact
*								Bug #2975181 General : Add some missing translations
*								Request #2975177 General : Use jt dialog box instead of self made
*								Request #2975179 Contact : Change captcha --> Use ReCaptcha
*								Request #2975183 Contact : If user is logged, fill name and email fields
*								Bug #2975175 Contact : No body for contact email
*	0.8.2      	10 feb 2010		Bug #2913937 Problem with group
*				                Translate buttons (Add user, Add email, Add Group and Delete) in English
*	0.8.1		28 jan 2010		Bug #18750	Bad URL for link / URL lien erronée
*								Bug #19566	LogDetail : mail sent ok list is too large / Liste des destinataire ok et erreur trop large
*								Bug #19567	E-mail sent : Embedded image is not shown in email sent detail / Les images incorporées ne sont pas visibles dans le détail des eamil envoyés
*								Bug #19568	E-mail sent detail : error when no attachment / Erreur lorsqu'il n'y a aucun fichier joint
*								Bug #19569	send again email : error when no attachment/ Erreur lorsqu'il n'y a aucun fichier joint
*	0.8.0 		12 jan 2010		Ajout fonctionnalite images incorporées	
*   0.7.0 : Ajout fonctionnalite piece jointe lors envoi de messages
* 	0.6.0 : Ajout fonctionnalite contact
*	0.5.0 : Correction probleme adresse/nom envoye par
*			Sauvegarde des emails envoyes
*	0.4.0 : Correction suppression item dans groupe
*	0.3.0 : Correction probleme envoi tous membres + ajout nombre mail envoyés+erreur
*	0.2.0 : Correction probleme image dans template
*	0.1.0 : Version d'origine
***************************************************************************************************/
// no direct access
   defined ('_JEXEC') or die ('restricted access');
  
   
  jimport('joomla.application.component.controller'); 
	jimport('joomla.error.log');
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');
	require_once('components/com_hecmailing/libraries/recaptcha/recaptchalib.php');


   
/**
 * hecMailing Controller
 *
 * @package hecMailing
 */
 
class hecMailingController extends JController
{
		var $_db =null;
		var $_err="";
		var $_params= null;
		var $_log=null;
	 /**
	 * Constructor
	 *
	 * @access	public
	 */
    function hecMailingController()
    {
    	$this->_log = &JLog::getInstance('com_hecmailing.log.php');
        parent::__construct();
		
		$this->params = &JComponentHelper::getParams( 'com_hecmailing' );
				
			
       
    }

   /**
	 * Method to display a view
	 *
	 * @access	public
	 */
    function display($tmpl = null)
    {
      
      	
      //get a refrence of the page instance in joomla 
      $document=& JFactory::getDocument(); 
      //get the view name from the query string 
      $viewName = JRequest::getVar('view', ''); 
	  
      $viewType= $document->getType(); 
      $check_right=true;
     	// interceptors to support legacy urls
     	//$task = $this->getTask();
     	$task = JRequest::getVar('task','');
     	
     	if($task=='' && $viewName=='contact')
     	{
     		$task='contact';
     	}
     	if ($task=='' && $viewname=='')
     	{
     		$task='form';
     	}	
     	if ($task!='')
     	{
	  		switch ($task)
	  		{
	  			//index.php?option=com_contact&task=category&id=0&Itemid=4
	  			case 'form':
	  				$viewName	= 'form';
	  				$layout		= 'default';
	  				break;
	  			case 'sent':
	  			 	$viewName	= 'sent';
	  				$layout		= 'default';
	  				break;
	  			case 'load':
	  			  //load();
	  				$viewName	= 'form';
	  				$layout		= 'default';
	  			case 'log':
	  			  $viewName	= 'log';
	  				$layout		= 'default';
	  				break;
	  			case 'contact':
	  				$check_right=false;
	  			  $viewName	= 'contact';
	  				$layout	= 'default';
	  				break;
	  			case 'viewlog':
	  			  $viewName	= 'logdetail';
	  				$layout		= 'default';
	  				break;
	  			case 'save':
	  			 save();
	  			 return;
	  			 break;
	  			case 'send_contact':
	  				$check_right=false;
	  				$viewName	= 'contact';
	  				$layout	= 'default';
	  				$task = 'contact';
	  				JRequest::setVar('task' , $task);
	  				if ($this->sendContact())
	  				{
	  					$msg=JText::_("CONTACT_SENT");
				     	$return = JRoute::_('index.php?option=com_content&view=frontpage');		
				     	$this->setRedirect( $return, $msg );
	  				}
	  			   break;
	  		}
     	}
      JRequest::setVar('view' , $viewName);
    	JRequest::setVar('layout', $layout);
      
      //get our view 
      $view = &$this->getView($viewName, $viewType); 
      
      //get the model 
      $model = &$this->getModel($viewName, 'ModelhecMailing');
      //get the model base
      $modelbase = &$this->getModel('form', 'ModelhecMailing');
      
      //some error check 
      if (!JError::isError($model)) 
      { 
         $view->setModel ($model, true); 
      }
     
      // Vérification droit d'access
      if ($check_right)
      {
	      $params = &JComponentHelper::getParams( 'com_hecmailing' );
	      $usr =& JFactory::getUser();
	      $utype = $usr->usertype;
				$grp = $params->get('usertype','ADMINISTRATOR;SUPER ADMINISTRATOR');
				if (strlen($utype)>0)
				{
					$pos = stripos($grp, $utype);
				}
				else
				{
					$pos=FALSE;
				}
					
					$usrgrp = $params->get('groupaccess','MailingGroup');
					
					if ($pos == FALSE && !$modelbase->isInGroupe($usrgrp))
					{
	         		 $msg=JText::sprintf("NO_RIGHT",$usrgrp);
				     $return = JRoute::_('index.php?option=com_content&view=frontpage');		
				     $this->setRedirect( $return, $msg );
	    		 }
	    }
     
      //set the template and display it 
      $view->setLayout($layout); 
      $view->display($tmpl); 

    }
    
  
    /**
	 * Method to load a saved template mail
	 *
	 * @access	public
	 */
    function load()
    {
      
         //get a refrence of the page instance in joomla 
      $document=& JFactory::getDocument(); 
      //get the view name from the query string 
      $viewName = JRequest::getVar('view', 'form'); 

      $viewType= $document->getType(); 
      
     $viewName	= 'form';
  	 $layout		= 'default';
  	 JRequest::setVar('view' , $viewName);
    JRequest::setVar('layout', $layout);
      
      //get our view 
      $view = &$this->getView($viewName, $viewType); 
      
      //get the model 
      $model = &$this->getModel($viewName, 'ModelhecMailing');
      
      //some error check 
      if (!JError::isError($model)) 
      { 
         $view->setModel ($model, true); 
      }
       
      //set the template and display it 
      $view->setLayout($layout); 
      $view->display($tmpl); 
      
    }
 
  /**
	 * Method to cancel current mail
	 *
	 * @access	public
	 */
   	function cancel()
		{
			echo "<script>alert('".JText::_("CANCEL_ALERT")."');</script>";
			$userid = JRequest::getVar( 'id', 0, 'post', 'int' );
			//$this->display();
			$msg=JText::_('CANCEL_MSG');
			$return = JRoute::_('index.php');		
			$this->setRedirect( $return, $msg );
		}
    
   /**
	 * Method to save current mail as template
	 *
	 * @access	public
	 */
    function save()
    {
       global $mainframe;
			// Check for request forgeries
			JRequest::checkToken() or jexit( 'Invalid Token' );
	     //get a refrence of the page instance in joomla 
      $document=& JFactory::getDocument(); 
      //get the view name from the query string 
      $viewName = JRequest::getVar('view', 'form'); 
	      //get our view 
	    $viewType= $document->getType(); 
      $view = &$this->getView('form', $viewType); 
          		$session =& JFactory::getSession();
      		$db	=& JFactory::getDBO();
            	
      		jimport( 'joomla.mail.helper' );
      
      		$SiteName 	= $mainframe->getCfg('sitename');
      		$MailFrom 	= $mainframe->getCfg('mailfrom');
      		$FromName 	= $mainframe->getCfg('fromname');
      
      		$link 		= base64_decode( JRequest::getVar( 'link', '', 'post', 'base64' ) );
      
      		
	
				// An array of e-mail headers we do not want to allow as input
		    $headers = array (	'Content-Type:',
							'MIME-Version:',
							'Content-Transfer-Encoding:',
							'bcc:',
							'cc:');

		    // An array of the input fields to scan for injected headers
		    $fields = array ('mailto',
						 'sender',
						 'from',
						 'subject',
						 );

		    /*
		    * Here is the meat and potatoes of the header injection test.  We
		    * iterate over the array of form input and check for header strings.
		    * If we find one, send an unauthorized header and die.
		    */
		    foreach ($fields as $field)
		    {
			     foreach ($headers as $header)
			     {
				      if (strpos($_POST[$field], $header) !== false)
				      {
					       JError::raiseError(403, '');
				      }
			     }
		    }

    		/*
    		 * Free up memory
    		 */
    		unset ($headers, $fields);
    
    		
    		$sender 			= JRequest::getString('sender', $MailFrom, 'post');
    		$fromvalue 				= JRequest::getString('from', $MailFrom, 'post');
    		$tmp = split(";" , $fromvalue);
			$from=$tmp[0];
			$sender=$tmp[1];
    		$subject_default 	= JText::sprintf('Item sent by', $sender);
    		$subject 			= JRequest::getString('subject', $subject_default, 'post');
    		$body 			= JRequest::getVar('body', '', 'post', 'string', JREQUEST_ALLOWRAW);
    		$groupe     		= JRequest::getString('groupe', '', 'post');
    		$name     		= JRequest::getString('saveTemplate',$subject , 'post');
    		
    		
    		
		    // Check for a valid to address
		    $error	= false;
		    $body = "<html><head></head><body>".$body."</body></html>";

		    // Check for a valid from address
		    if ( ! $from || ! JMailHelper::isEmailAddress($from) )
		    {
			     $error	= JText::sprintf('EMAIL_INVALID', $from);
			     JError::raiseWarning(0, $error );
		    }

    		// Clean the email data
    		$subject = JMailHelper::cleanSubject($subject);
    		$body	 = JMailHelper::cleanBody($body);
    		//$body = str_replace("src=\"","src=\"".JURI::base(),$body);
    		
    		$sender	 = JMailHelper::cleanAddress($sender);
        $query = "Insert Into #__hecmailing_save (msg_lb_message, msg_vl_subject,msg_vl_body,msg_vl_from) values (".$db->Quote($name).",".$db->Quote($subject).",".
            $db->Quote($body).",".$db->Quote($from).")";
        $db->execute($query);
        
        	$msg=JText::_("EMAIL SAVED");
			$return = JRoute::_('index.php');		
			$this->setRedirect( $return, $msg );
    }
     function sendMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=null, $bcc=null, $attachment=null, $replyto=null, $replytoname=null, $inline=null )

    {

         // Get a JMail instance

        $mail =& JFactory::getMailer();

 

        $mail->setSender(array($from, $fromname));

        $mail->setSubject($subject);

        $mail->setBody($body);

 

        // Are we sending the email as HTML?

        if ( $mode ) {

            $mail->IsHTML(true);

        }

 

        $mail->addRecipient($recipient);

        $mail->addCC($cc);

        $mail->addBCC($bcc);

        $mail->addAttachment($attachment);
        
        foreach ($inline as $att)
        {
        	 $mail->AddEmbeddedImage($att[0], $att[1], $name = $att[2]);
        }
        

 

        // Take care of reply email addresses

        if( is_array( $replyto ) ) {
            $numReplyTo = count($replyto);
          for ( $i=0; $i < $numReplyTo; $i++){
                $mail->addReplyTo( array($replyto[$i], $replytoname[$i]) );

            }

        } elseif( isset( $replyto ) ) {

           $mail->addReplyTo( array( $replyto, $replytoname ) );

        }

 

        return  $mail->Send();

    }


    /**
	 * Method to send current mail to selected group
	 *
	 * @access	public
	 */
    function send()
	   {
	     global $mainframe;
			// Check for request forgeries
			JRequest::checkToken() or jexit( 'Invalid Token' );
	     //get a refrence of the page instance in joomla 
      $document=& JFactory::getDocument(); 
      //get the view name from the query string 
      $viewName = JRequest::getVar('view', 'form'); 
	      //get our view 
	    $viewType= $document->getType(); 
      $view = &$this->getView('form', $viewType); 
      $viewName = "form";
      //get the model 
      $model = &$this->getModel($viewName, 'ModelhecMailing');
      
	     
	     		$session =& JFactory::getSession();
      		$db	=& JFactory::getDBO();
            	
      		jimport( 'joomla.mail.helper' );
      
      		$SiteName 	= $mainframe->getCfg('sitename');
      		$MailFrom 	= $mainframe->getCfg('mailfrom');
      		$FromName 	= $mainframe->getCfg('fromname');
      		
      		$link 		= base64_decode( JRequest::getVar( 'link', '', 'post', 'base64' ) );
      		
      	$params = &JComponentHelper::getParams( 'com_hecmailing' );
      		
	
				// An array of e-mail headers we do not want to allow as input
		    $headers = array (	'Content-Type:',
							'MIME-Version:',
							'Content-Transfer-Encoding:',
							'bcc:',
							'cc:');

		    // An array of the input fields to scan for injected headers
		    $fields = array ('mailto',
						 'sender',
						 'from',
						 'subject',
						 );

				#
 

		    /*
		    * Here is the meat and potatoes of the header injection test.  We
		    * iterate over the array of form input and check for header strings.
		    * If we find one, send an unauthorized header and die.
		    */
		    foreach ($fields as $field)
		    {
			     foreach ($headers as $header)
			     {
				      if (strpos($_POST[$field], $header) !== false)
				      {
					       JError::raiseError(403, '');
				      }
			     }
		    }

    		/*
    		 * Free up memory
    		 */
    		unset ($headers, $fields);
    		
    		$useprofil 		= JRequest::getString('useprofil', 0, 'post');
    		$image_incorpore 		= JRequest::getString('incorpore', 0, 'post');
    		$logmail 		= JRequest::getString('backup_mail', 0, 'post');
    		//$sender 			= JRequest::getString('sender', $FromName, 'post');
    		$fromvalue 				= JRequest::getString('from', $MailFrom.';'.$FromName, 'post');
				$tmp = split(";" , $fromvalue);
				$from=$tmp[0];
				$sender=$tmp[1];
    		$subject_default 	= JText::sprintf('DEFAULT_SUBJECT', $sender);
    		$subject 			= JRequest::getString('subject', $subject_default, 'post');
    		$body 			= JRequest::getVar('body', '', 'post', 'string', JREQUEST_ALLOWRAW);
        $groupe     		= JRequest::getString('groupe', '', 'post');
        
        $nbattach = JRequest::getInt('attachcount', 0, 'post');
    		$attach = array();
    		$files = array();
    		$pj_uploaded = array();
    		$attach_path = $mainframe->getCfg('tmp_path');
    		if (intval($logmail)==1)
    		{
    			$attach_path=$params->get('attach_path', $attach_path);
    		}
    		$path = realpath(JPATH_ROOT);
    		
    		// Cree le repertoire s'il n'existe pas
    		if (!JFolder::exists($path.$attach_path))
    		{
    			JFolder::create($path.$attach_path);
    		}
    		
    		// Traite les fichiers uploades
    		for($i=1;$i<=$nbattach;$i++)
    		{
    			
    				$file = JRequest::getVar('attach'.$i, null, 'files', 'array');
					$filename = JFile::makeSafe($file['name']);
          			$src = $file['tmp_name'];
					//Set up the source and destination of the file
					$dest = $attach_path.DS.$file['name'];
					JFile::upload($src, $path.$dest);
					$attach[] = $path.$dest;
					$files[] = $dest;
					// Bug #3013589 : Delete Failed message
					$pj_uploaded[] = $path.$dest;
					
    		}
    		$nblocal = JRequest::getInt('localcount', 0, 'post');
    		$local = array();
    		
    		$img="";
    		
    		// Traite les fichiers locaux (dejà presents sur le serveur)
    		for($i=1;$i<=$nblocal;$i++)
    		{
    			$isok = JRequest::getString('chklocal'.$i, 'c', 'post');
    			if ($isok!='')
    			{
	    			$file = JRequest::getString('local'.$i, '', 'post');
						$filename = $file;
	          
						
						$attach[] = $path.DS.$filename;
						$files[]=$filename;
					}
					
    		}
        
		// Check for a valid to address
		$error	= false;
		$body = "<html><head></head><body>".$body."</body></html>";
		
		// Check for a valid from address
		if ( ! $from || ! JMailHelper::isEmailAddress($from) )
		{
			$error	= JText::sprintf('EMAIL_INVALID', $fromvalue ."/".$from."/".$sender);
			JError::raiseWarning(0, $error );
		}

		// Clean the email data
		$subject = JMailHelper::cleanSubject($subject);
		$body	 = JMailHelper::cleanBody($body);
		//$body = str_replace("src=\"","src=\"".JURI::base(),$body);
		$inline=array();
		$bodytolog = $body;

		
		if ($image_incorpore=='1')
		{
		$pos= stripos($body," src=\"");
		while ($pos!==FALSE)
		{
			$pos+=6;
			$posfin= stripos($body,"\"", $pos+1);
			$url = substr($body, $pos, $posfin-$pos);
			$cur=count($inline);
			$cid= "12345612345-".$cur;
			$name = JFile::getName($url);
			/*if (stripos($url,"http://")===FALSE)
			{
				$url=JURI::base().$url;
			}*/
			
			
			$inline[$cur][1]=$cid;
			$inline[$cur][2]=$name;
			$inline[$cur][0]=$path.DS.$url;
			$body=substr($body,0,$pos)."cid:".$cid.substr($body,$posfin);
			$posfin++;
			$pos=stripos($body," src=\"",$posfin); 
		}
	}
	else
	{
		$pos= stripos($body," src=\"");
		while ($pos!==FALSE)
		{
			$pos+=6;
			$posfin= stripos($body,"\"", $pos+1);
			$url = substr($body, $pos, $posfin-$pos);
			
			if (stripos($url,"http://")===FALSE)
			{
				$url=JURI::base().$url;
			}
			
			
			$body=substr($body,0,$pos).$url.substr($body,$posfin);
			$posfin++;
			$pos=stripos($body," src=\"",$posfin); 
		}
	}
		
		$pos= stripos($body," href=\"");
		while ($pos!==FALSE)
		{
			$pos+=7;
			$posfin= stripos($body,"\"", $pos+1);
			$url = substr($body, $pos, $posfin-$pos);
			if (stripos($url,"http://")===FALSE)
			{
				$url=JURI::base().$url;
			}
			
			$body=substr($body,0,$pos).$url.substr($body,$posfin);
			$posfin++;
			$pos=stripos($body," href=\"",$posfin); 
		}
		
		
		// Traite PJ ...
		//$attach='images/logo.gif';
		
		
		$errors=0;
		$sender	 = JMailHelper::cleanAddress($sender);
    $lstmailok='';
    $lstmailerr='';
    
    if ($groupe>=0)
    {

        $detail = $model->getMailAdrFromGroupe($groupe,$useprofil);
        $nb=0;
        foreach($detail as $elmt)
        {
          $email = $elmt[0];
          if ( ! $email  || ! JMailHelper::isEmailAddress($email) )
    	   	{
    			   $error	= JText::sprintf('EMAIL_INVALID %s(%s)', $email, $elmt[1]);
    			   JError::raiseWarning(0, $error );
    			   $errors++;
    		  }
          else
          {
        		// Send the email
        		if ( $this->sendMail($from, $sender, $email, $subject, $body,true,null,null,$attach,null,null, $inline) !== true )
        		{
        		  $error	= JText::sprintf('EMAIL_NOT_SENT %s(%s)', $email, $elmt[1]);
        			JError::raiseNotice( 500, $error);
        			$errors++;
        			$lstmailerr .= $email .';';
        		}
        		else
        		{
        			$nb++;
        			$lstmailok .= $email . ';';
        		}
      		}
        }
      }
     
    	// Enregistrement Log
    	if (intval($logmail)==1)
    	{
    		$user =&JFactory::getUser();
    		$query = "Insert Into #__hecmailing_log (log_dt_sent,log_vl_subject,log_vl_body,
  				log_vl_from,grp_id_groupe,usr_id_user,log_bl_useprofil,log_nb_ok,log_nb_errors,log_vl_mailok,log_vl_mailerr)
  				 values (now(),".$db->Quote($subject).",".
            $db->Quote($bodytolog).",".$db->Quote($from).",".$groupe.",".$user->id.",".$useprofil.",".$nb.",".$errors.",".$db->Quote($lstmailok).",".$db->Quote($lstmailerr).")";
        $db->execute($query);
    		$logid = $db->insertid(); 
    		foreach($files as $file)
    		{
    			$query = "Insert Into #__hecmailing_log_attachment (log_id_message, log_nm_file) values (".$logid.",".$db->Quote($file).")";
    			$db->execute($query);
    		}
    	
    
    }
    else	// Si on ne log pas le message, on n'a pas besoin de garder les pieces jointes non locales
    {
    	JFile::delete($pj_uploaded);
    		
    }
      $msg=JText::_("EMAIL_SENT"). "(".$nb." OK/".$errors." ERR)";
			$return = JRoute::_('index.php');		
			$this->setRedirect( $return, $msg );
		
					

		}
	
	  /**
	 * Method to send current mail to selected group
	 *
	 * @access	public
	 */
    function sendContact()
	{
     	global $mainframe;
     	
     	
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	    //get a refrence of the page instance in joomla 
      	$document=& JFactory::getDocument(); 
      	//get the view name from the query string 
      	$viewName = JRequest::getVar('view', 'form'); 
	    //get our view 
	    $viewType= $document->getType();

	   	
	    	    
      	$view = &$this->getView($viewName, $viewType); 
      	
	    //get the model 
      	$model = &$this->getModel('form', 'ModelhecMailing');
      
      	
      	// get DB connection
		$session =& JFactory::getSession();
	    $db	=& JFactory::getDBO();

	    // Import joomla mail module
      	jimport( 'joomla.mail.helper' );
      
      		
	
				// An array of e-mail headers we do not want to allow as input
		    $headers = array (	'Content-Type:',
							'MIME-Version:',
							'Content-Transfer-Encoding:',
							'bcc:',
							'cc:');

		    // An array of the input fields to scan for injected headers
		    $fields = array ('mailto',
						 'sender',
						 'from',
						 'subject',
						 );

		    /*
		    * Here is the meat and potatoes of the header injection test.  We
		    * iterate over the array of form input and check for header strings.
		    * If we find one, send an unauthorized header and die.
		    */
		    foreach ($fields as $field)
		    {
			     foreach ($headers as $header)
			     {
				      if (strpos($_POST[$field], $header) !== false)
				      {
					       JError::raiseError(403, '');
				      }
			     }
		    }

    		/*
    		 * Free up memory
    		 */
    		unset ($headers, $fields);
    		
    		# was there a reCAPTCHA response?
    		// Get a key from http://recaptcha.net/api/getkey
			$publickey = "6LdY6AsAAAAAACn2_Mq5qa7Ro_E3UaScqIv5iysB ";
			$privatekey = "6LdY6AsAAAAAAK6GF1sb7WpqBc61Xb4cpNE57hRO";
			
			# the response from reCAPTCHA
			$resp = null;
			# the error code from reCAPTCHA, if any
			
			$error = null;
			$error	= false;
			$check_captcha = JRequest::getInt('check_captcha',1,'post');
			
			if ($check_captcha==1)
			{
				$privatekey = $this->params->get('captcha_private_key','6LexAQwAAAAAAKTT3bwI9SR2mCAfExdLlS-DHfQt');
	    		$recaptcha_challenge_field = JRequest::getString('recaptcha_challenge_field','','post');
	    		$recaptcha_response_field= JRequest::getString('recaptcha_response_field','','post');
				if ($recaptcha_response_field!='') 
				{
	        		$resp = recaptcha_check_answer ($privatekey,
	                                        $_SERVER["REMOTE_ADDR"],
	                                        $recaptcha_challenge_field,
	                                        $recaptcha_response_field);
	
	        		if ($resp->is_valid) 
	        		{
	        			$error=false;
	    			}
	    			else
	    			{
		    			$error=true;
	    			}
	        		
	        	}
	    		if ($error)
	    		{	
	               
	  				JError::raiseWarning(0, JText::_('CONTACT_CAPTCHA_ERR') );
	  				$errors++;
	        		return false ;
	        	}
	        }
			
    		
    		$from = JRequest::getString('email', '', 'post');
    		$name  = JRequest::getString('name', '', 'post');
    		$groupe = JRequest::getInt('group', 0, 'post');
    		$subject = JRequest::getString('subject', '', 'post');
    		$body 	= JRequest::getVar('body', '', 'post', 'string', JREQUEST_ALLOWRAW);
        	$body = html_entity_decode($body);
    		$backup_mail = JRequest::getInt('backup_mail','0','post');
			$backup_mail = ($backup_mail==1);
			

		// Check for a valid from address
		if ( ! $from || ! JMailHelper::isEmailAddress($from) )
		{
			$error	= JText::sprintf('EMAIL_INVALID', $from);
			JError::raiseWarning(0, $error );
			return false;
		}
		else
		{
			// Clean the email data
			$subject = JMailHelper::cleanSubject($subject);
			$body	 = JMailHelper::cleanBody($body);
			$name	 = JMailHelper::cleanAddress($name);
	       	if ($groupe>=0)
	    	{
	
	        	$detail = $model->getMailAdrFromGroupe($groupe,false);
	        	$nb=0;
	        	$errors=0;
		        foreach($detail as $elmt)
		        {
		          $email = $elmt[0];
		          // Check email
		          if ( ! $email  || ! JMailHelper::isEmailAddress($email) )
		    	   	{
		    			   $error	= JText::sprintf('EMAIL_INVALID (%s)', $email, $elmt[1]);
		    			   JError::raiseWarning(0, $error );
		    			   $errors++;
		    		  }
		          else
		          {
		        		// Send the email
		        		if ( JUtility::sendMail($from, $name, $email, $subject, $body,true) !== true )
		        		{
		        		  	$error	= JText::sprintf('EMAIL_NOT_SENT (%s)', $email, $elmt[1]);
		        			JError::raiseNotice( 500, $error);
		       				$errors++;
		        		}
		       			else
		       			{
		       				$nb++;
		       			}
		      		}
		        }
		        if ($backup_mail)
		        {
		        	// Send the email
		        	$MailFrom 	= $mainframe->getCfg('mailfrom');
      				$FromName 	= $mainframe->getCfg('fromname');
	        		if ( JUtility::sendMail($MailFrom,$FromName,  $from, 'COPY:'.$subject, $body,true) !== true )
	        		{
	        		  	$error	= JText::sprintf('EMAIL_BACKUP_NOT_SENT', $from);
	        			JError::raiseNotice( 500, $error);
	       				$errors++;
	        		}
	       			else
	       			{
	       				$nb++;
	       			}
		        }
	      }
	    }
      if ($errors>0)
      {
      	return false;
      }
      else
      {
      	return true;
      }
					

	}
	
		
}
?> 