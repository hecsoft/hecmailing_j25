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

/**
* @package		Joomla
* @subpackage	Contact
*/
class TOOLBAR_hecmailing
{
	/**
	* Draws the menu for a New Contact
	*/
	function _EDIT($edit) {
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );

		$text = ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );

		JToolBarHelper::title( JText::_( 'Hec Mailing' ) .': <small><small>[ '. $text .' ]</small></small>', 'hecmailing.png' );

		//JToolBarHelper::custom( 'save2new', 'new.png', 'new_f2.png', 'Save & New', false,  false );
		//JToolBarHelper::custom( 'save2copy', 'copy.png', 'copy_f2.png', 'Save To Copy', false,  false );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		if ( $edit ) {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		} else {
			JToolBarHelper::cancel();
		}
		
		JToolBarHelper::help( 'screen.hecmailing.edit' );
	}

  function _TEMPLATES()
  {
    $text = JText::_( 'TEMPLATES' );
		JToolBarHelper::title( JText::_( 'HEC MAILING' ) .': <small><small>[ '. $text .' ]</small></small>', 'hecmailing.png' );
		JToolBarHelper::custom('delTemplate','delete.png','delete.png', JText::_('DELETE'));
    JToolBarHelper::cancel();
  }
  
  function _CONTACT()
  {
    $text = JText::_( 'CONTACT' );
		JToolBarHelper::title( JText::_( 'HEC MAILING' ) .': <small><small>[ '. $text .' ]</small></small>', 'hecmailing.png' );
		JToolBarHelper::custom('newContact','new.png','new.png', JText::_('NEW CONTACT'),false,false);
		JToolBarHelper::custom('editContact','edit.png','edit.png', JText::_('EDIT CONTACT'),false,false);
		JToolBarHelper::custom('delContact','delete.png','delete.png', JText::_('DELETE'));
    JToolBarHelper::cancel();
  }

 function _EDITCONTACT($edit) {
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );

		$text = ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );

		JToolBarHelper::title( JText::_( 'HEC MAILING' ) .': <small><small>[ '. $text .' ]</small></small>', 'hecmailing.png' );

		//JToolBarHelper::custom( 'save2new', 'new.png', 'new_f2.png', 'Save & New', false,  false );
		//JToolBarHelper::custom( 'save2copy', 'copy.png', 'copy_f2.png', 'Save To Copy', false,  false );
		JToolBarHelper::custom('saveContact','save.png','save.png', JText::_('SAVE'),false,false);
		JToolBarHelper::custom('cancelContact','cancel.png','cancel.png', JText::_('CANCEL'),false,false);
		
		JToolBarHelper::help( 'screen.hecmailing.edit' );
	}
	
	function _DEFAULT() {
		JHTML::stylesheet('icons.css', 'administrator/components/com_hecmailing/hecmailing.css');
		JToolBarHelper::title( JText::_( 'HEC MAILING' ).': <small><small>[ '. JText::_('ADMIN GROUPS') .' ]</small></small>', 'hecmailing.png' );
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::custom('add', 'new.png','new_f2.png',JText::_('NEW GROUP'),false,false);
		//JToolBarHelper::addNewX();
		JToolBarHelper::divider();
		JToolBarHelper::custom('templates', 'copy.png','copy.png',JText::_('TEMPLATES'),false);
		JToolBarHelper::custom('contact', 'assign.png','assign.png',JText::_('CONTACT'),false);
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_hecmailing', '500');

		JToolBarHelper::help( 'screen.hecmailing' );
	}
}