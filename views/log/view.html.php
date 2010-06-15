<?php 
defined('_JEXEC') or die ('restricted access'); 

jimport('joomla.application.component.view'); 
jimport('joomla.html.toolbar');
class hecMailingViewLog extends JView 
{ 
    
    function display ($tpl=null) 
   { 
      global $option,$mainframe; 
      
       
      $currentuser= &JFactory::getUser();
      $pparams = &$mainframe->getParams();
			
			$intcss=1;
			//$intcss = $pparams->get('internal_css');
      
      
      $model = & $this->getModel(); 
       
      
  
      $group = $mainframe->getUserStateFromRequest( $option.'group',        'group',        0,    'int' );
      $owner = $mainframe->getUserStateFromRequest( $option.'owner',        'owner',        0,    'int' );
      $filter_order        = $mainframe->getUserStateFromRequest( $option.'filter_order',        'filter_order',  'name', 'cmd' );
      $filter_order_Dir    = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',    'filter_order_Dir', 'desc', 'word' );
      $search				= $mainframe->getUserStateFromRequest( "$option.search2",			'search2', 			'',			'string' );
	  $search				= JString::strtolower( $search );
      $limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	  //$limitstart = $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );
	$limitstart =	JRequest::getVar('limitstart', 0, '', 'int');
      
      
      $grouplist = $model->getGroups();
      if (!$grouplist)
      {
        $groupes = JText::_("NO_GROUP");
      }
      else
      {
        $groupes = JHTML::_('select.genericlist',  $grouplist, 'group', 'class="inputbox" size="1"', 'grp_id_groupe', 'grp_nm_groupe', intval($group));
      }
      
      //$pagination = $model->getPagination();
      jimport('joomla.html.pagination');
      $pagination = new JPagination($model->getTotal(), $limitstart, $limit );
 	  $logs = $model->getData($limitstart, $limit); 
      // table ordering
		  $lists['order_Dir']	= $filter_order_Dir;
		  $lists['order']		= $filter_order; 
      // search filter
		  $lists['search2']= $search;
		  $lists['groups'] = $groupes;
		    
  
  
      $this->assignRef('logs', $logs);
      $this->assignRef('groupes', $groupes);
      $this->assignRef('pagination', $pagination);
      $this->assignRef('limitstart', $limitstart);
      $this->assignRef('lists',		$lists);
      $viewLayout = JRequest::getVar( 'layout', 'default' );
	    $this->_layout = $viewLayout;
      
      parent::display($tpl); 
   } 
   


   
   
} 
?> 
