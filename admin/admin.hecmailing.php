<?php
/**
 * @version 0.0.1 
 * @package hecmailing
 * @copyright 2009 Hecsoft.info
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 * @link http://joomlacode.org/gf/project/userport/
 * @author H Cyr
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
  jimport('joomla.error.log');
/*
 * Make sure the user is authorized to view this page
 */
$user = & JFactory::getUser();
$document = &JFactory::getDocument();
$task	= JRequest::getCmd('task');
$id 	= JRequest::getVar('id', 0, 'get', 'int');
$cid 	= JRequest::getVar('cid', array(0), 'post', 'array');
$option = JRequest::getCmd('option');
JArrayHelper::toInteger($cid, array(0));
require_once( JApplicationHelper::getPath( 'admin_html' ) );
// Set the table directory
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_hecmailing'.DS.'tables');
$document->addStyleSheet( $mainframe->getSiteURL() . 'administrator/components/com_hecmailing/hecmailing.css', 
                          'text/css', null, array() );
                          


switch ($task)
{
   
	case 'add' :
		editObject(false );
		break;
	case 'edit':
		editObject(true);
		break;

	case 'apply':
	case 'save':
	case 'save2new':
	case 'save2copy':
		saveObject( $task );
		break;

	case 'remove':
	
		removeObject( $cid );
		break;

	case 'publish':
		changeObject( $cid, 1 );
		break;

	case 'unpublish':
		changeObject( $cid, 0 );
		break;

	case 'orderup':
		orderObject( $cid[0], -1 );
		break;

	case 'orderdown':
		orderObject( $cid[0], 1 );
		break;

	case 'accesspublic':
		changeAccess( $cid[0], 0 );
		break;

	case 'accessregistered':
		changeAccess( $cid[0], 1 );
		break;

	case 'accessspecial':
		changeAccess( $cid[0], 2 );
		break;

	case 'saveorder':
		saveOrder( $cid );
		break;

	case 'cancel':
		cancelObject();
		break;

  case 'templates':
    showTemplates();
    break;
  
  case 'delTemplate':
    delTemplates($cid);
    break;
    case 'contact':
    case 'cancelContact':
    	showContact();
    break;
    case 'edit_contact':
    case 'editContact':
    	$idContact 	= JRequest::getVar('contactid', 0, 'get', 'int');
    	editContact($idContact);
    break;
    case 'new_contact':
    case 'newContact':
    	
    	editContact(0);
    break;
    case 'delContact':
    delContact($cid);
    break;
    case 'saveContact':
    	saveContact();
    break;
    
	default:
		showObjects( $option );
		break;
}

/**
* List the records
* @param string The current GET/POST option
*/
function showObjects( $option )
{
	global $mainframe;

	$db					=& JFactory::getDBO();
	$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order', 		'filter_order', 	'cd.ordering',	'cmd' );
	$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
	$filter_state 		= $mainframe->getUserStateFromRequest( $option.'filter_state', 		'filter_state', 	'',				'word' );
	$filter_catid 		= $mainframe->getUserStateFromRequest( $option.'filter_catid', 		'filter_catid',		0,				'int' );
	$search 			= $mainframe->getUserStateFromRequest( $option.'search', 			'search', 			'',				'string' );
	$search 			= JString::strtolower( $search );

	$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart	= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');

	$where = array();

/*	if ( $search ) {
		$where[] = 'cd.name LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
	}
	if ( $filter_catid ) {
		$where[] = 'cd.catid = '.(int) $filter_catid;
	}
	if ( $filter_state ) {
		if ( $filter_state == 'P' ) {
			$where[] = 'cd.published = 1';
		} else if ($filter_state == 'U' ) {
			$where[] = 'cd.published = 0';
		}
	}
*/
  if ($filter_order != 'g.grp_nm_groupe' && $filter_order != 'g.grp_cm_groupe' && $filter_order != 'g.published' && $filter_order != 'grp_nb_item' && $filter_order != 'g.grp_id_groupe')
    $filter_order= 'cd.ordering';
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'cd.ordering'){
		$orderby 	= ' ORDER BY grp_id_groupe';
	} else {
		$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir ;
	}

	// get the total number of records
	$query = 'SELECT COUNT(*)'
	. ' FROM #__hecmailing_groups AS g '
	. $where
	;
	$db->setQuery( $query );
	$total = $db->loadResult();

	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );

	// get the subset (based on limits) of required records
	$query = 'SELECT g.*, count(gd.grp_id_groupe) as grp_nb_item '
	. ' FROM #__hecmailing_groups AS g Left Join #__hecmailing_groupdetail gd on g.grp_id_groupe=gd.grp_id_groupe '
	. $where
	. 'GROUP BY grp_id_groupe'
	. $orderby
	;
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();

	// build list of categories
	$javascript = 'onchange="document.adminForm.submit();"';
	$lists['catid'] = JHTML::_('list.category',  'filter_catid', 'com_contact_details', intval( $filter_catid ), $javascript );

	// state filter
	$lists['state']	= JHTML::_('grid.state',  $filter_state );

	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;

	// search filter
	$lists['search']= $search;

	HTML_hecmailing::showObjects( $rows, $pageNav, $option, $lists );
}

/**
* Creates a new or edits and existing user record
* @param int The id of the record, 0 if a new entry
* @param string The current GET/POST option
*/
function editObject($edit )
{
	$db		=& JFactory::getDBO();
	$user 	=& JFactory::getUser();

	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	$option = JRequest::getCmd('option');

	JArrayHelper::toInteger($cid, array(0));

	$row =& JTable::getInstance('groupe', 'Table');
	// load the row from the db table
	if($edit)
	$row->load( $cid[0] );

	if ($edit) {
		// do stuff for existing records
		$row->checkout($user->get('id'));
	} else {
		// do stuff for new records
		$row->imagepos 	= 'top';
		$row->ordering 	= 0;
		$row->published = 1;
	}
	$lists = array();
  $query = "Select gd.gdet_cd_type, gd.gdet_id_value, gd.gdet_vl_value,gd.gdet_id_detail, u.name, g.name From #__hecmailing_groupdetail gd 
  left join #__users u on gd.gdet_id_value=u.id left join #__core_acl_aro_groups g on g.id=gd.gdet_id_value and gd.gdet_cd_type=3
   Where grp_id_groupe=".$cid[0];
  $db->setQuery($query);
  $detail = $db->loadRowList();
      
	$query = "Select id, username,name From #__users order by name";
  $db->setQuery($query);
  $users = $db->loadRowList();
  $ulist=array();
	foreach($users as $u)
	{
    $ulist[] = JHTML::_('select.option', $u[0], $u[2], 'id', 'name');
  }
	$users = JHTML::_('select.genericlist',  $ulist, 'newuser', 'class="inputbox" size="1"', 'id', 'name', 0);
	if($edit)
		$lists['ordering'] 			= JHTML::_('list.specificordering',  $row, $cid[0], $query );
	else
		$lists['ordering'] 			= JHTML::_('list.specificordering',  $row, '', $query );

  $query = "Select id, name From #__core_acl_aro_groups order by id";
  $db->setQuery($query);
  $grp = $db->loadRowList();
  $glist = array(); 
  foreach($grp as $g)
  {
  	$glist[] = JHTML::_('select.option', $g[0], $g[1], 'id', 'name');
  }
  
  $groups = JHTML::_('select.genericlist',  $glist, 'newgroupe', 'class="inputbox" size="1"', 'id', 'name', 0);
	
	// build the html radio buttons for published
	$lists['published'] 		= JHTML::_('select.booleanlist',  'published', '', $row->published );
	
	// get params definitions
	$file 	= JPATH_ADMINISTRATOR .'/components/com_hecmailing/config.xml';
	$params = new JParameter( $row->params, $file, 'component' );

	HTML_hecmailing::editObject( $row, $lists, $detail, $params, $users, $groups );
}

/**
* Saves the record from an edit form submit
* @param string The current GET/POST option
*/
function saveObject( $task )
{
	global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );
  $log = &JLog::getInstance('com_hecmailing.log.php');
	// Initialize variables
	$db		=& JFactory::getDBO();
	$row	=& JTable::getInstance('groupe', 'Table');
	$tmppost = JRequest::get( 'post' );
	$post=array();
	$post['grp_id_groupe'] = $tmppost['grp_id_groupe'];
	$post['grp_nm_groupe'] = $tmppost['grp_nm_groupe'];
	$post['grp_cm_groupe'] = $tmppost['grp_cm_groupe'];
	$post['published'] = $tmppost['published'];
	if (!$row->bind( $post )) {
		JError::raiseError(500, $row->getError() );
	}
	

	// pre-save checks
	if (!$row->check()) {
		JError::raiseError(500, $row->getError() );
	}

	// save the changes
	if (!$row->store()) {
		JError::raiseError(500, $row->getError() );
	}
	
	
	$nbold = $tmppost['nbold'];
	$nbnew= $tmppost['nbnew'];
	$log->addEntry(array('comment' => 'nbold='.$nbold));
	$log->addEntry(array('comment' => 'nbnew='.$nbnew));
	
	  $todel = $tmppost['todel'];
    $log->addEntry(array('comment'=>'todel='.$todel));
    if (isset($todel))
    {
      $listToDel = split(';',$todel);
      foreach ($listToDel as $item)
      {
        $query = "delete from #__hecmailing_groupdetail Where gdet_id_detail=".$item;
        $db->execute($query);
        $log->addEntry(array('comment'=>'query='.$query));
        }
    }
  foreach ($tmppost as $k=>$e)
  {
      $log->addEntry(array('comment'=>$k."=".$e));
  }
  for ($i=1;$i<=$nbnew;$i++)
  {
    $v = $tmppost['new'.$i];
    
    if (isset($v))
    {
      
      $tv = split(";",$v);
      $t=$tv[0];
      $n=$tv[1];
      $l='';
      if ($t==4)
      {
        $l = $n;
        $n=0;
      }
      $log->addEntry(array('comment'=>'new'.$i."=".$t.".".$n));
      $query = "insert into #__hecmailing_groupdetail (grp_id_groupe,gdet_cd_type,gdet_id_value,gdet_vl_value)
          values (".$row->grp_id_groupe.",".$t.",".$n.",".$db->Quote( $l, true ).")";
      
      $db->execute($query);
      $log->addEntry(array('comment'=>"Query=".$query));
    }
  }

	
	$row->checkin();
	

	switch ($task)
	{
		case 'apply':
		case 'save2copy':
			$msg	= JText::_( 'GROUPE SAVED' );
			$link	= 'index.php?option=com_hecmailing&task=edit&cid[]='. $row->grp_id_groupe .'';
			break;

		case 'save2new':
			$msg	= JText::sprintf( 'CHANGES TO X SAVED', 'Group' );
			$link	= 'index.php?option=com_hecmailing&task=edit';
			break;

		case 'save':
		default:
			$msg	= JText::_( 'GROUPE SAVED' );
			$link	= 'index.php?option=com_hecmailing';
			break;
	}

	$mainframe->redirect( $link, $msg );
}

/**
* Removes records
* @param array An array of id keys to remove
* @param string The current GET/POST option
*/
function removeObject( &$cid )
{
	global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );
  echo "<script>alert('".JText::_("REMOVE_ITEM")."');</script>";
	// Initialize variables
	$db =& JFactory::getDBO();
	JArrayHelper::toInteger($cid);

	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__hecmailing_groups'
		. ' WHERE grp_id_groupe IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg(true)."'); window.history.go(-1); </script>\n";
		}
	}
  $msg = count($cid)." ".JText::_("GROUP_DELETED");
	$mainframe->redirect( "index.php?option=com_hecmailing" ,$msg);
}

/**
* Changes the state of one or more content pages
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The current option
*/
function changeObject( $cid=null, $state=0 )
{
    global $option,$mainframe;
    
    if ($state==1) {
         $publish = 1;
         $msg=JText::_("GROUP_PUBLISHED");
            }
        else {
            $publish = 0;
            $msg=JText::_("GROUP_UNPUBLISHED");
            }
    $mailTable =& JTable::getInstance('groupe', 'Table');
    
    $mailTable->publish($cid, $publish);
    $msg = count($cid)." ".$msg;
    	$mainframe->redirect( "index.php?option=com_hecmailing", $msg );
}

/** JJC
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderContacts( $uid, $inc )
{
	global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );

	// Initialize variables
	$db =& JFactory::getDBO();

	$row =& JTable::getInstance('object', 'Table');
	$row->load( $uid );
	$row->move( $inc, 'catid = '. (int) $row->catid .' AND published != 0' );

	$mainframe->redirect( 'index.php?option=com_hecmailing' );
}

/** PT
* Cancels editing and checks in the record
*/
function cancelObject()
{
	global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );

	// Initialize variables
	$db =& JFactory::getDBO();
	$row =& JTable::getInstance('groupe', 'Table');
	$row->bind( JRequest::get( 'post' ));
	$row->checkin();

	$mainframe->redirect('index.php?option=com_hecmailing');
}

/**
* changes the access level of a record
* @param integer The increment to reorder by
*/
function changeAccess( $id, $access  )
{
	global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );

	// Initialize variables
	$db =& JFactory::getDBO();

	$row =& JTable::getInstance('hecmailing', 'Table');
	$row->load( $id );
	$row->access = $access;

	if ( !$row->check() ) {
		return $row->getError();
	}
	if ( !$row->store() ) {
		return $row->getError();
	}

	$mainframe->redirect( 'index.php?option=com_hecmailing' );
}

function saveOrder( &$cid )
{
	global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );

	// Initialize variables
	$db			=& JFactory::getDBO();
	$total		= count( $cid );
	$order 		= JRequest::getVar( 'order', array(0), 'post', 'array' );
	JArrayHelper::toInteger($order, array(0));

	$row =& JTable::getInstance('object', 'Table');
	$groupings = array();

	// update ordering values
	for( $i=0; $i < $total; $i++ ) {
		$row->load( (int) $cid[$i] );
		// track categories
		$groupings[] = $row->catid;

		if ($row->ordering != $order[$i]) {
			$row->ordering = $order[$i];
			if (!$row->store()) {
				JError::raiseError(500, $db->getErrorMsg() );
			}
		}
	}

	// execute updateOrder for each parent group
	$groupings = array_unique( $groupings );
	foreach ($groupings as $group){
		$row->reorder('catid = '.(int) $group);
	}

	$msg 	= JText::_('MSG_NEW_ORDERING_SAVED');
	$mainframe->redirect( 'index.php?option=com_hecmailing', $msg );
}

function showTemplates()
{
 	global $mainframe;
	$option = JRequest::getCmd('option');

	$db					=& JFactory::getDBO();
	$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order', 		'filter_order', 	'cd.ordering',	'cmd' );
	$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
	$search 			= $mainframe->getUserStateFromRequest( $option.'search', 			'search', 			'',				'string' );
	$search 			= JString::strtolower( $search );

	$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart	= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');

	$where = array();
  if ($filter_order != 'msg_lb_message' && $filter_order != 'msg_id_message')
    $filter_order= 'cd.ordering';
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'cd.ordering'){
		$orderby 	= ' ORDER BY msg_id_message';
	} else {
		$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir ;
	}

	// get the total number of records
	$query = 'SELECT COUNT(*)'
	. ' FROM #__hecmailing_save AS s '
	. $where
	;
	$db->setQuery( $query );
	$total = $db->loadResult();

	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );

	// get the subset (based on limits) of required records
	$query = 'SELECT * '
	. ' FROM #__hecmailing_save '
	. $where
	. $orderby
	;
	
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();

	// build list of categories
	$javascript = 'onchange="document.adminForm.submit();"';
	$lists['catid'] = JHTML::_('list.category',  'filter_catid', 'com_contact_details', intval( $filter_catid ), $javascript );

	// state filter
	$lists['state']	= JHTML::_('grid.state',  $filter_state );

	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;

	// search filter
	$lists['search']= $search;

	HTML_hecmailing::showTemplates( $rows, $pageNav, $option, $lists );
}

/**
* Removes records
* @param array An array of id keys to remove
* @param string The current GET/POST option
*/
function delTemplates( &$cid )
{
	global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );
  echo "<script>alert('".JText::_("REMOVE_ITEM")."');</script>";
	// Initialize variables
	$db =& JFactory::getDBO();
	JArrayHelper::toInteger($cid);

	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__hecmailing_save'
		. ' WHERE msg_id_message IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg(true)."'); window.history.go(-1); </script>\n";
		}
	}
  $msg = count($cid).JText::_('MSG_TEMPLATE_DELETED');
	$mainframe->redirect( "index.php?option=com_hecmailing&task=templates" ,$msg);
}

function showContact()
{
  	global $mainframe, $option;

	$db					=& JFactory::getDBO();
	$filter_order		= $mainframe->getUserStateFromRequest( $option.'filter_order', 		'filter_order', 	'cd.ordering',	'cmd' );
	$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );
	$search 			= $mainframe->getUserStateFromRequest( $option.'search', 			'search', 			'',				'string' );
	$search 			= JString::strtolower( $search );

	$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart	= $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');

	$where = array();
  if ($filter_order != 'ct_nm_contact' && $filter_order != 'ct_id_contact')
    $filter_order= 'cd.ordering';
	$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	if ($filter_order == 'cd.ordering'){
		$orderby 	= ' ORDER BY ct_id_contact';
	} else {
		$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir ;
	}

	// get the total number of records
	$query = 'SELECT COUNT(*)'
	. ' FROM #__hecmailing_contact AS s '
	. $where
	;
	$db->setQuery( $query );
	$total = $db->loadResult();

	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );

	// get the subset (based on limits) of required records
	$query = 'SELECT * '
	. ' FROM #__hecmailing_contact left join #__hecmailing_groups on #__hecmailing_contact.grp_id_groupe=#__hecmailing_groups.grp_id_groupe '
	. $where
	. $orderby
	;
	
	$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	$rows = $db->loadObjectList();

	// build list of categories
	$javascript = 'onchange="document.adminForm.submit();"';
	$lists['catid'] = JHTML::_('list.category',  'filter_catid', 'com_contact_details', intval( $filter_catid ), $javascript );

	// state filter
	$lists['state']	= JHTML::_('grid.state',  $filter_state );

	// table ordering
	$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;

	// search filter
	$lists['search']= $search;

	HTML_hecmailing::showContact( $rows, $pageNav, $option, $lists );
}

/**
* Edit a contact info
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The current option
*/
function editContact(  $edit )
{
	global $cid;
    	$db		=& JFactory::getDBO();
	$user 	=& JFactory::getUser();

	$id 	= JRequest::getVar('contactid', 0, 'get', 'int');
	if ($id==0) $id=$cid[0];
	$option = JRequest::getCmd('option');

	

	$row =& JTable::getInstance('contact', 'Table');
	// load the row from the db table
	if($edit)
		$row->load( $id );

	
	$lists = array();
  	$query = "Select ct_id_contact ,grp_id_groupe,ct_nm_contact,ct_cm_contact,ct_vl_info  
  		From #__hecmailing_contact  
        Where ct_id_contact=".$id;
  $db->setQuery($query);
  $detail = $db->loadObject();
      
	$query = "Select grp_id_groupe, grp_nm_groupe From #__hecmailing_groups order by grp_nm_groupe";
  $db->setQuery($query);
  $groups = $db->loadRowList();
  $glist=array();
	foreach($groups as $g)
	{
    $glist[] = JHTML::_('select.option', $g[0], $g[1], 'grp_id_groupe', 'grp_nm_groupe');
  }
	$groups = JHTML::_('select.genericlist',  $glist, 'grp_id_groupe', 'class="inputbox" size="1"', 'grp_id_groupe', 'grp_nm_groupe', $detail->grp_id_groupe);
	if($edit)
		$lists['ordering'] 			= JHTML::_('list.specificordering',  $row, $id, $query );
	else
		$lists['ordering'] 			= JHTML::_('list.specificordering',  $row, '', $query );

	
	
	// get params definitions
	$file 	= JPATH_ADMINISTRATOR .'/components/com_hecmailing/config.xml';
	$params = new JParameter( $row->params, $file, 'component' );

	HTML_hecmailing::editContact( $id,$groups,$detail, $params );
}

/**
* Removes records
* @param array An array of id keys to remove
* @param string The current GET/POST option
*/
function delContact( &$cid )
{
	global $mainframe;

	// Check for request forgeries
	JRequest::checkToken() or jexit( 'Invalid Token' );
  echo "<script>alert('".JText::_("REMOVE_ITEM")."');</script>";
	// Initialize variables
	$db =& JFactory::getDBO();
	JArrayHelper::toInteger($cid);

	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$query = 'DELETE FROM #__hecmailing_contact'
		. ' WHERE ct_id_contact IN ( '. $cids .' )'
		;
		$db->setQuery( $query );
		if (!$db->query()) {
			echo "<script> alert('".$db->getErrorMsg(true)."'); window.history.go(-1); </script>\n";
		}
	}
  $msg = count($cid).JText::_('MSG_CONTACT_DELETED');
	$mainframe->redirect( "index.php?option=com_hecmailing&task=contact" ,$msg);
}


/**
* Removes records
* @param array An array of id keys to remove
* @param string The current GET/POST option
*/
function saveContact( )
{
	global $mainframe;

	// Check for request forgeries
	//JRequest::checkToken() or jexit( 'Invalid Token' );
 
 	$post = JRequest::get( 'post' );
 	$ct_id_contact = $post['ct_id_contact'];
	$grp_id_groupe = $post['grp_id_groupe'];
	$ct_nm_contact = $post['ct_nm_contact'];
	//$ct_cm_contact = $post['ct_cm_contact'];
	$ct_vl_info = JRequest::getVar('ct_vl_info', '', 'post', 'string', JREQUEST_ALLOWRAW); //$post['ct_vl_info'];
	//$ct_vl_info = html_entity_decode($ct_vl_info);
	$ct_vl_info = nl2br($ct_vl_info);
	// Initialize variables
	$db =& JFactory::getDBO();
	$msg = JText::_('MSG_CONTACT_SAVED');
  	if ($ct_id_contact>0)
	{
		$query = 'UPDATE #__hecmailing_contact set grp_id_groupe='.$grp_id_groupe.',ct_nm_contact='.$db->Quote($ct_nm_contact).
		',ct_vl_info='.$db->Quote($ct_vl_info).
		' WHERE ct_id_contact ='.$ct_id_contact	;
		$db->setQuery( $query );
		if (!$db->query()) {
			$msg = JText::_('MSG_ERROR_SAVE_CONTACT').':'.$query.'/'.$db->getErrorMsg(true);
		}
		else
		{
			$msg = "Contact sauvegarde";
		}
	}
	else
	{
	
		$query = 'INSERT  #__hecmailing_contact (grp_id_groupe,ct_nm_contact,ct_cm_contact,ct_vl_info) 
			values ('.$db->Quote($grp_id_groupe).','.$db->Quote($ct_nm_contact).','.$db->Quote('').','.$db->Quote($ct_vl_info).')';
		$db->setQuery( $query );
		if (!$db->query()) {
			$msg = JText::_('MSG_ERROR_SAVE_CONTACT').':'.$db->getErrorMsg(true);
		}
		else
		{
			$msg = "Contact cree";
		}
	}
  	
	$mainframe->redirect( "index.php?option=com_hecmailing&task=contact" ,$msg);
}