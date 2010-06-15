<?php
/**
 * @version 0.8.2 
 * @package hecmailing
 * @copyright 2009 Hecsoft.info
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 * @link http://joomlacode.org/gf/project/userport/
 * @author H Cyr
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* @package		hecMailing
* 
*/
class HTML_hecmailing
{
  
  /**
   * Methode to display group list
   *
   * @param group list
   * @param Page navigation
   * @param Options
   * @param List of parameters (order,search...)
   *                 
   **/        
	function showObjects( &$rows, &$pageNav, $option, &$lists )
	{
		$user =& JFactory::getUser();

		//Ordering allowed ?
		$ordering = ($lists['order'] == 'cd.ordering');

		JHTML::_('behavior.tooltip');
		?>
		<form action="index.php?option=com_hecmailing" method="post" name="adminForm">

		<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'GO' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'RESET' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $lists['catid'];
				echo $lists['state'];
				?>
			</td>
		</tr>
		</table>

			<table class="adminlist">
			<thead>
				<tr>
					<th width="10">
						<?php echo JText::_( 'NUM' ); ?>
					</th>
					<th width="10" class="title">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
					</th>
					
					<th class="title" >
						<?php echo JHTML::_('grid.sort',   JText::_('NAME'), 'g.grp_nm_groupe', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					
					<th  class="title">
						<?php echo JHTML::_('grid.sort',   JText::_('DESCRIPTION'), 'g.grp_cm_groupe', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th class="title" >
						<?php echo JHTML::_('grid.sort',   JText::_('PUBLISHED'), 'g.published', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th class="title" >
						<?php echo JHTML::_('grid.sort',   JText::_('ITEM_COUNT'), 'grp_nb_item', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th  width="5px" class="title">
						<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'g.grp_id_groupe', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
				<tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="7">
						<?php echo $pageNav->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php
			$k = 0;
			for ($i=0, $n=count($rows); $i < $n; $i++) {
				$row = $rows[$i];
        $published = JHTML::_('grid.published', $row, $i );
				$link 		= JRoute::_( 'index.php?option=com_hecmailing&task=edit&cid[]='. $row->grp_id_groupe );
        $checked = JHTML::_('grid.id', $i, $row->grp_id_groupe ); 
				//$checked 	= JHTML::_('grid.checkedout',   $row, $i );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td width="5px">
						<?php echo $pageNav->getRowOffset( $i ); ?>
					</td>
					<td width="5px">
						<?php echo $checked; ?>
					</td>
					
					<td width="40%">
					<?php
					if (JTable::isCheckedOut($user->get ('id'), $row->checked_out )) :
						echo $row->grp_nm_groupe;
					else :
						?>
						<span class="editlinktip hasTip" title="<?php echo JText::_( 'EDIT_GROUP' );?>::<?php echo $row->grp_nm_groupe."(".$row->grp_id_groupe.")"; ?>">
						<a href="<?php echo $link; ?>">
							<?php echo $row->grp_nm_groupe; ?></a> </span>
						<?php
					endif;
					?>
					</td>
					
					<td>
						
							<?php echo $row->grp_cm_groupe; ?>
					</td>
						<td width="30px" class="at_published" align="center">
						  
							<?php echo $published ?>
					</td>
						<td width="30px">
						
							<?php echo $row->grp_nb_item; ?>
					</td>
					<td>
					<?php
					if (JTable::isCheckedOut($user->get ('id'), $row->checked_out )) :
						echo $row->grp_id_groupe;
					else :
						?>
						<span class="editlinktip hasTip" title="<?php echo JText::_( 'EDIT_GROUP' );?>::<?php echo $row->grp_nm_groupe."(".$row->grp_id_groupe.")"; ?>">
						<a href="<?php echo $link; ?>">
							<?php echo $row->grp_id_groupe; ?></a> </span>
						<?php
					endif;
					?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>

		<input type="hidden" name="option" value="com_hecmailing" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		<div class="warning"><?php echo  JText::_( 'WARNING_CHANGE_GROUP' ); ?></div>
		</form>
		<?php
		
	}

/**
 * Methode for display group edit screen
 * 
 * @param Group list
 * @param Parameter list
 * @param Detail
 * @param Parameters
 * @param Joomla user list (like Html Select Option)
 * 
 **/        
	function editObject( &$row, &$lists, $detail, &$params, $users, $jgroups ) {

		JRequest::setVar( 'hidemainmenu', 1 );

		if ($row->image == '') {
			$row->image = 'blank.png';
		}

		JHTML::_('behavior.tooltip');
		jimport('joomla.html.pane');
        // TODO: allowAllClose should default true in J!1.6, so remove the array when it does.
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));

		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'misc' );
		$cparams = JComponentHelper::getParams ('com_hecmailing');
		$document =& JFactory::getDocument();
		//$burl = JURI::base();
		$burl = "../";
		$document->addScript($burl."components/com_hecmailing/libraries/jt/dom-drag.js");
		$document->addScript($burl."components/com_hecmailing/libraries/jt/jt_.js");
		$document->addScript($burl."components/com_hecmailing/libraries/jt/jt_DialogBox.js");
		$document->addScript($burl."components/com_hecmailing/libraries/jt/jt_AppDialogs.js");
		$document->addStyleSheet($burl."components/com_hecmailing/libraries/jt/jt_DialogBox.css");
		$document->addStyleSheet($burl."components/com_hecmailing/libraries/jt/veils.css");
		
		?>
		 
	<LINK rel="stylesheet" type="text/css" href="../components/com_hecmailing/css/dialog.css">
	<div id="dialog_container"></div>
	<div id="dialog" class="hecdialog" name="dialog" style="display:none;"  >
          <!--<div class="dlgheader"><h1><?php echo JText::_( 'NEW USER' ); ?></h1></div>-->
          <div class="image"><img src="../components/com_hecmailing/images/user64.png" ></div>
          <div class="content"><br/>
          <?php echo JText::_('SELECT_USER_BELOW'); ?><br/><br/>
          <?php echo JText::_('USER')." : ".$users ?></div>
          
          <div class="buttons"><button onclick="javascript:addUser();return false;"><img src="../components/com_hecmailing/images/ok16.png" ><?php echo JText::_('ADD'); ?></button><button onclick="javascript:cancel();return false;"><img src="../components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('CANCEL'); ?></button></div> 
      </div>
       <div id="dialog2" name="dialog2" class="hecdialog" style="display:none;" >
          <!--<div class="dlgheader"><h1><?php echo JText::_( 'NEW GROUP' ); ?></h1></div>-->
           <div class="image" ><img width="64px" src="../components/com_hecmailing/images/group64.png" ></div>
           <div class="content">
           <?php echo JText::_('SELECT_GROUP_BELOW') ?><br/><br/>
                  <?php echo JText::_('GROUP')." : ".$jgroups ?>
                  
                  </div>
                <div class="buttons"><button onclick="javascript:addGroupe();return false;"><img src="../components/com_hecmailing/images/ok16.png" ><?php echo JText::_('ADD'); ?></button><button onclick="javascript:cancel();return false;"><img src="../components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('CANCEL'); ?></button></div> 
          </div>
      
      <div id="dialog3" name="dialog3" class="hecdialog" style="display:none;">
          <!--<div class="dlgheader"><h1><?php echo JText::_( 'DELETE' ); ?></h1></div>-->
                <div class="image" ><img width="64px" src="../components/com_hecmailing/images/poubelle64.png" ></div>
                <div id="dialog3_msg" name="dialog3_msg" class="content"><?php echo JText::_('REMOVE_ALL_SELECTED'); ?></div>
          
                <div class="buttons"><button onclick="javascript:deleteRows();return false;"><img src="../components/com_hecmailing/images/ok16.png" ><?php echo JText::_('REMOVE'); ?></button><button onclick="javascript:cancel();return false;"><img src="../components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('CANCEL'); ?></button></div> 
          
      </div>
      <div id="dialog4" name="dialog4" class="hecdialog" style="display:none;">
          <!--<div class="dlgheader"><h1><?php echo JText::_( 'NEW MAIL' ); ?></h1></div>-->
           <div class="image" ><img width="64px" src="../components/com_hecmailing/images/email64.png" ></div>
           <div class="content">
           <?php echo JText::_('ENTER_EMAIL_BELOW') ?><br/><br/>
                  <?php echo JText::_('EMAIL')." : "?><input type="text" name="newmail" id="newmail" value="" width="95%" />
                   </div>
                <div class="buttons"><button onclick="javascript:addMail();return false;"><img src="../components/com_hecmailing/images/ok16.png" ><?php echo JText::_('ADD'); ?></button><button onclick="javascript:cancel();return false;"><img src="../components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('CANCEL'); ?></button></div> 
          </div>
      <script type="text/javascript">
    jt_DialogBox.imagePath = '../components/com_hecmailing/libraries/jt/';
    
    
     function createContent(cid,title, width) {
		dlgbox = new jt_DialogBox(true);

		dlgbox.setTitle(title);
		dlgbox.setContent(document.getElementById(cid).innerHTML);
		dlgbox.setWidth(width);
		btnnewuser = document.getElementById('btnnewuser');
		x = 30;
		y = 100;
		dlgbox.moveTo(x,y);
		
		return (dlgbox);
	}
	

	dlg1 = null;
	dlg2 = null;
	dlg3 = null;
	dlg4 = null;
	var newuser=null;	
	var newmail=null;
	var newgroupe=null;
		

</script>
		<script language="javascript" type="text/javascript">
		<!--
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if ( form.name.value == "" ) {
				alert( "<?php echo JText::_( 'YOU MUST PROVIDE A NAME', true ); ?>" );
			} else {
				submitform( pressbutton );
			}
		}
		
		function showAddNewUser()
		{
        
	      	if (dlg1 == null) 
	      	{
				
				dlg1 = createContent('dialog','<?php echo JText::_( "NEW USER" ); ?>', 300);
				dlgNode = dlg1.getContentNode();
				l = dlgNode.getElementsByTagName('select');
				for (i in l)
				{
					el = l[i];
					
					if (el.id=='newuser')
					{
						newuser=el;
						
					}
					
				}	
			}
		
		dlg1.show();
      	return false;  
    }
    
    	function showAddNewMail()
		{
        //document.getElementById("dialog4").style.visibility = "visible";
        if (dlg4 == null) 
	    {
				dlg4 = createContent('dialog4','<?php echo JText::_( "NEW MAIL" ); ?>', 300);
				dlgNode = dlg4.getContentNode();
				l = dlgNode.getElementsByTagName('input');
				for (i in l)
				{
					el = l[i];
					
					if (el.id=='newmail')
					{
						newmail=el;
					}
					
				}	
		}	
        dlg4.show();
      
        return false;  
    }
	   function showAddNewGroupe()
		{
        if (dlg2==null)
        {
        	dlg2 = createContent('dialog2','<?php echo JText::_( "NEW GROUP" ); ?>', 300);
        	dlgNode = dlg2.getContentNode();
				l = dlgNode.getElementsByTagName('select');
				for (i in l)
				{
					el = l[i];
					
					if (el.id=='newgroupe')
					{
						newgroupe=el;
					}
					
				}	
        }
        dlg2.show();
        return false;  
    }
    function showDeleteEntry()
    {
        
        var msg = document.getElementById("dialog3_msg");
        var table = document.getElementById("detail");  
        var rowCount = table.rows.length;  
        nb=0;

        for(var i=0; i<rowCount; i++) 
        {  
            var row = table.rows[i];  
            var chkbox = row.cells[0].childNodes[0];  
            if(null != chkbox && true == chkbox.checked) 
            {
                nb++;         
            }  
        }
        if (nb>0)
        {
          if (dlg3==null)
          	dlg3 = createContent('dialog3','<?php echo JText::_( "DELETE" ); ?>', 300);
          dlg3.show();
          msg.innerHTML = '<?php echo JText::_('WANT_REMOVE', true) ?>'+nb+' <?php echo JText::_('ITEMS', true) ?> '; 
        }
        else
        {
          alert('<?php echo JText::_("NO_SELECTED_ITEM"); ?>');
        }
        return false;  
    
    }    
    function addUser()
    {
        var nbnew = document.getElementById("nbnew");
        //document.getElementById("dialog").style.visibility = "hidden";
        dlg1.hide();
        //var user = document.getElementById("newuser");
        user=newuser;
        
        tab=document.getElementById("detail");
        tabBody=tab.getElementsByTagName("TBODY").item(0);
         row=document.createElement("TR");
         cell0 = document.createElement("TD");
         cell1 = document.createElement("TD");
         cell2 = document.createElement("TD");
         chknode = document.createElement("input");
         n=0;
         n=nbnew.value;
         n++;
         chknode.name= 'suppressnew'+n;
         chknode.id= 'suppressnew'+n;
         chknode.value=0;
         chknode.type="checkbox";
         img = document.createElement("img");
         img.src="../components/com_hecmailing/images/user16.png";
         textnode1=document.createTextNode("<?php echo JText::_('USER', true); ?>");
         textnode2=document.createTextNode(user.options[user.selectedIndex].text);
         hid = document.createElement("input");
         hid.name= 'new'+n;
         hid.id= 'new'+n;
         hid.type="hidden";
         
         hid.value= "2;"+user.value;
         cell0.appendChild(chknode);
         cell1.appendChild(img);
         cell1.appendChild(textnode1);
         cell2.appendChild(textnode2);
         cell0.appendChild(hid);
         row.appendChild(cell0);
         row.appendChild(cell1);
         row.appendChild(cell2);
         tabBody.appendChild(row);
      
         
         nbnew.value=n;
    }
    
    function addMail()
    {
        var nbnew = document.getElementById("nbnew");
        //document.getElementById("dialog4").style.visibility = "hidden";
        dlg4.hide();
        //var mail = document.getElementById("newmail");
        mail=newmail;
        tab=document.getElementById("detail");
        tabBody=tab.getElementsByTagName("TBODY").item(0);
         row=document.createElement("TR");
         cell0 = document.createElement("TD");
         cell1 = document.createElement("TD");
         cell2 = document.createElement("TD");
         chknode = document.createElement("input");
         n=0;
         n=nbnew.value;
         n++;
         chknode.name= 'suppressnew'+n;
         chknode.id= 'suppressnew'+n;
         chknode.value=0;
         chknode.type="checkbox";
         img = document.createElement("img");
         img.src="../components/com_hecmailing/images/email16.png";
         textnode1=document.createTextNode("<?php echo JText::_('EMAIL', true); ?>");
         textnode2=document.createTextNode(mail.value);
         hid = document.createElement("input");
         hid.name= 'new'+n;
         hid.id= 'new'+n;
         hid.type="hidden";
         
         hid.value= "4;"+mail.value;
         cell0.appendChild(chknode);
         cell1.appendChild(img);
         cell1.appendChild(textnode1);
         cell2.appendChild(textnode2);
         cell0.appendChild(hid);
         row.appendChild(cell0);
         row.appendChild(cell1);
         row.appendChild(cell2);
         tabBody.appendChild(row);
      
         
         nbnew.value=n;
    }
    
     function addGroupe()
    {
        var nbnew = document.getElementById("nbnew");
        //document.getElementById("dialog2").style.visibility = "hidden";
        dlg2.hide();
        //var grp = document.getElementById("newgroupe");
        grp = newgroupe;
        tab=document.getElementById("detail");
        tabBody=tab.getElementsByTagName("TBODY").item(0);
         row=document.createElement("TR");
         cell0 = document.createElement("TD");
         cell1 = document.createElement("TD");
         cell2 = document.createElement("TD");
         chknode = document.createElement("input");
         n=0;
         n=nbnew.value;
         n++;
         hid = document.createElement("input");
         hid.name= 'new'+n;
         hid.id= 'new'+n;
         hid.type="hidden";
         img = document.createElement("img");
         img.src="../components/com_hecmailing/images/group16.png";
         hid.value= "3;"+grp.value;
         chknode.name= 'suppressnew'+n;
         chknode.id= 'suppressnew'+n;
         chknode.value=0;
         chknode.type="checkbox";
         textnode1=document.createTextNode("<?php echo JText::_('GROUP', true); ?>");
         textnode2=document.createTextNode(grp.options[grp.selectedIndex].text);
         cell0.appendChild(chknode);
         cell0.appendChild(hid);
         cell1.appendChild(img);
         cell1.appendChild(textnode1);
         cell2.appendChild(textnode2);
         row.appendChild(cell0);
         row.appendChild(cell1);
         row.appendChild(cell2);
         tabBody.appendChild(row);
         nbnew.value=n;
    }
    
    function deleteRows() {  
       try {  
            //document.getElementById("dialog3").style.visibility = "hidden";
            dlg3.hide();
             var todel = document.getElementById('todel');
             var table = document.getElementById("detail");  
             var rowCount = table.rows.length;  
   
             for(var i=0; i<rowCount; i++) {  
                 var row = table.rows[i];  
                 var chkbox = row.cells[0].childNodes[0];  
                 if(null != chkbox && true == chkbox.checked) {
                     
                      todel.value+=chkbox.value+';';
                       
                     table.deleteRow(i);  
                     rowCount--;  
                     i--;  
                     
                 }  
   
             }  
      }catch(e) {  
             alert(e);  
       }  
    }  



    
    function cancel()
    {
            /*document.getElementById("dialog").style.visibility = "hidden";
            document.getElementById("dialog2").style.visibility = "hidden";
            document.getElementById("dialog3").style.visibility = "hidden";
            document.getElementById("dialog4").style.visibility = "hidden";*/
            if (dlg1!=null)  dlg1.hide();
            if (dlg2!=null) dlg2.hide();
            if (dlg3!=null) dlg3.hide();
            if (dlg4!=null) dlg4.hide();
    }
		//-->
		</script>

		<form action="index.php" method="post" name="adminForm">
    
  
		<div class="col">
		  
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'GROUP' ); ?></legend>

				<table class="admintable">
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'ID' ); ?>:
						</label>
					</td>
					<td >
						<?php echo $row->grp_id_groupe; ?><input type="hidden" name="grp_id_groupe" id="grp_id_groupe" value="<?=$row->grp_id_groupe ?>" >
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'NAME' ); ?>:
						</label>
					</td>
					<td >
						<input class="inputbox" type="text" name="grp_nm_groupe" id="grp_nm_groupe" size="60" maxlength="255" value="<?php echo $row->grp_nm_groupe; ?>" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'COMMENT' ); ?>:
						</label>
					</td>
					<td >
							<textarea name="grp_cm_groupe" id="grp_cm_groupe" rows="3" cols="45" class="inputbox"><?php echo $row->grp_cm_groupe; ?></textarea>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="name">
							<?php echo JText::_( 'PUBLISHED' ); ?>:
						</label>
					</td>
					<td >
					<?php
              echo $lists['published'];					      
           ?>
						
					</td>
				</tr>
				</table>
			</fieldset>
      
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'DETAIL' ); ?></legend>
        <button id="btnnewuser" onclick="javascript:showAddNewUser();return false;" ><img src="../components/com_hecmailing/images/user16.png" ><?php echo JText::_( 'NEW USER' ); ?></button>
        <button id="btnnewmail" onclick="javascript:showAddNewMail();return false;" ><img src="../components/com_hecmailing/images/email16.png" ><?php echo JText::_( 'NEW MAIL' ); ?></button>
        <button id="btnnewgroupe" onclick="javascript:showAddNewGroupe();return false;" ><img src="../components/com_hecmailing/images/group16.png" ><?php echo JText::_( 'NEW GROUP' ); ?></button>
        <button id="delete" onclick="javascript:showDeleteEntry();return false;" ><img src="../components/com_hecmailing/images/poubelle16.png" ><?php echo JText::_( 'DELETE' ); ?></button>
				<table class="adminlist" id="detail">
				<thead>
				  <th class="title"></th><th class="title"><?php echo JText::_('TYPE'); ?></th><th class="title"><?php echo JText::_('NAME'); ?></th>
				</thead>
				<tbody>
				<?php 
				  $i=0;$k=0;
				  foreach ($detail as $r)
				  {
            echo "<tr class=\"row".$k."\"><td><input type=\"checkbox\" name=\"suppress".$i."\" id=\"suppress".$i."\" value=\"".$r[3]."\" ></td>";
            $i++;
            if ($k==1) $k=0;
            else  $k=1;
            
            switch($r[0])
            {
              case 1: 
                  echo "<td><img src=\"../components/com_hecmailing/images/user16.png\" >".JText::_("USER")."</td><td>".$r[2]."</td>";
                  break;
              case 2: 
                  echo "<td><img src=\"../components/com_hecmailing/images/user16.png\" >".JText::_("USER")."</td><td>".$r[4]."</td>";
                  break;
              case 3: 
                  echo "<td><img src=\"../components/com_hecmailing/images/group16.png\" >".JText::_("GROUP")."</td><td>".$r[5]."</td>";
                  break;
              case 4: 
                  echo "<td><img src=\"../components/com_hecmailing/images/email16.png\" >".JText::_("EMAIL")."</td><td>".$r[2]."</td>";
                  break;
            }
            echo "</tr>";
          
          }
          echo "<input type=\"hidden\" name=\"nbold\" id=\"nbold\" value=\"".$i."\"/>";
          echo "<input type=\"hidden\" name=\"nbnew\" id=\"nbnew\" value=\"0\"/>";
          echo "<input type=\"hidden\" name=\"todel\" id=\"todel\" value=\"\"/>";
        ?>				
						
				</tbody>
				</table>
			</fieldset>
		</div>

		<div class="clr"></div>

      
		<input type="hidden" name="option" value="com_hecmailing" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		
		<input type="hidden" name="task" value="" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}
	
	/**
	 * Methode that show template list
	 * 
	 * @param array Template list
	 * @param PageNav
	 * @param array Options
	 * @param array Variable list (order...)
	 * 
	 **/                    	
	function showTemplates( $rows, $pageNav, $option, $lists )
	{
    ?>	
   <form action="index.php" method="post" name="adminForm">
      <table class="adminlist">
			<thead>
				<tr>
					<th width="10px">
						<?php echo JText::_( 'NUM' ); ?>
					</th>
					<th width="10px" class="title">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
					</th>
					<th width="100%" class="title" >
						<?php echo JHTML::_('grid.sort',   JText::_('TEMPLATE'), 'msg_lb_message', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					
					<th width="50px" class="title">
						<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'msg_id_message', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
				<tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="4">
						<?php echo $pageNav->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			 	<?php
			       $k = 0;
			       for ($i=0, $n=count($rows); $i < $n; $i++) 
             {
				        $row = $rows[$i];
                $checked = JHTML::_('grid.id', $i, $row->msg_id_message ); 
				
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td width="5px">
						<?php echo $pageNav->getRowOffset( $i ); ?>
					</td>
					<td width="5px">
						<?php echo $checked; ?>
					</td>
					
					<td width="40%"><?php if ($row->msg_lb_message=='')
										echo $row->msg_vl_subject;
										else
										echo $row->msg_lb_message;
						?></td>
					<td width="40%"><?=$row->msg_id_message	?></td>
					
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>
				<input type="hidden" name="option" value="com_hecmailing" />
		    <input type="hidden" name="task" value="templates" />
		    <input type="hidden" name="boxchecked" value="0" />
		    <input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		    <input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		    <?php echo JHTML::_( 'form.token' ); ?>
   </form>
   <?php
  }
  
/**
	 * Methode that show contact list
	 * 
	 * @param array Template list
	 * @param PageNav
	 * @param array Options
	 * @param array Variable list (order...)
	 * 
	 **/                    	
	function showContact( $rows, $pageNav, $option, $lists )
	{
    ?>	
   <form action="index.php" method="post" name="adminForm">
      <table class="adminlist">
			<thead>
				<tr>
					<th width="10px">
						<?php echo JText::_( 'NUM' ); ?>
					</th>
					<th width="10px" class="title">
						<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
					</th>
					<th width="100%" class="title" >
						<?php echo JHTML::_('grid.sort',   JText::_('CONTACT_TITLE'), 'ct_nm_contact', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					
					<th width="50px" class="title">
						<?php echo JHTML::_('grid.sort',   JText::_('CONTACT_ID'), 'ct_id_contact', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
				<tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="4">
						<?php echo $pageNav->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
			 	<?php
			       $k = 0;
			       for ($i=0, $n=count($rows); $i < $n; $i++) 
             {
				        $row = $rows[$i];
                		$checked = JHTML::_('grid.id', $i, $row->ct_id_contact ); 
				
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td width="5px">
						<?php echo $pageNav->getRowOffset( $i ); ?>
					</td>
					<td width="5px">
						<?php echo $checked; ?>
					</td>
					
					<td width="40%"><a href="index.php?option=com_hecmailing&task=editContact&contactid=<?= $row->ct_id_contact ?>" ><?=$row->ct_nm_contact	?></a></td>
					<td width="40%"><?=$row->ct_id_contact	?></td>
					
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>
				<input type="hidden" name="option" value="com_hecmailing" />
		    <input type="hidden" name="task" value="edit_contact" />
		    <input type="hidden" name="boxchecked" value="0" />
		    <input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		    <input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		    <?php echo JHTML::_( 'form.token' ); ?>
   </form>
   <?php
  }
  
  function editContact($id,$groups,$data,$param)
  {
  		JRequest::setVar( 'hidemainmenu', 1 );

		if ($row->image == '') {
			$row->image = 'blank.png';
		}

		JHTML::_('behavior.tooltip');
  	$editor =& JFactory::getEditor();


  ?>
  	<form action="index.php" method="post" name="adminForm">
    	<table class="admintable">
			<tr><td class="key"><label for="name"><?php echo JText::_( 'ID_CONTACT' ); ?>:</label></td>
				<td><?php echo $data->ct_id_contact; ?><input type="hidden" name="ct_id_contact" id="ct_id_contact" value="<?=$id ?>" ></td></tr>
			<tr><td class="key"><label for="name"><?php echo JText::_( 'CONTACT_NAME' ); ?>:</label></td>
				<td><input class="inputbox" type="text" name="ct_nm_contact" id="ct_nm_contact" size="30" maxlength="30" value="<?php echo $data->ct_nm_contact; ?>" /></td></tr>
			<tr><td class="key"><label for="name"><?php echo JText::_( 'GROUP' ); ?>:</label></td>
				<td ><?php  echo $groups; ?></td></tr>
			<tr><td class="key"><label for="name"><?php echo JText::_( 'INFO' ); ?>:</label></td>
				<td><?php echo $editor->display('ct_vl_info', $data->ct_vl_info, 400, 200, '60', '20', true); ?>
					<!--<textarea name="ct_vl_info" id="ct_vl_info" rows="5" cols="45" class="inputbox"><?php echo $data->ct_vl_info; ?></textarea>--></td></tr>
			
		</table>
		<input type="hidden" name="option" value="com_hecmailing" />
		<input type="hidden" name="task" value="saveContact" />
	</form>
		
<?php 
  }
  
}
?>