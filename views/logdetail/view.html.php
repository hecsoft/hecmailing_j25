<?php 
defined('_JEXEC') or die ('restricted access'); 

jimport('joomla.application.component.view'); 
jimport('joomla.html.toolbar');
class hecMailingViewLogDetail extends JView 
{ 
    
   function display ($tpl=null) 
   { 
      global $option,$mainframe; 
     
   
      $currentuser= &JFactory::getUser();
      $pparams = &$mainframe->getParams();
			
			$model = & $this->getModel(); 
      $groupe=0; 
      
      $height = $pparams->get('edit_width','400');
      $width = $pparams->get('edit_height','400');
      
      
     $idlog = JRequest::getInt('idlog', 0);
		  
      
      if ($idlog>0)
      {
        $infomsg = $model->getLogDetail($idlog);
        if (!$infomsg)
        {
        	$this->assignRef('data', false);
        	$this->assignRef('attachment',array());
        }
        else
        {
        	$this->assignRef('data', $infomsg);
        	
      		$this->assignRef('attachment',$infomsg->attachment);
        }
        
        
      }
      
      
      
  		$this->assignRef('idlog', $idlog);
      $this->assignRef('saved', $saved);
      $this->assignRef('height', $height);
      $this->assignRef('width', $width);
      $viewLayout = JRequest::getVar( 'layout', 'default' );
	    $this->_layout = $viewLayout;
      
      parent::display($tpl); 
   } 
   
   
} 
?> 
