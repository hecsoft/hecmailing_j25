<?php 

defined ('_JEXEC') or die ('restricted access'); 
jimport('joomla.html.html');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/css/toolbar.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/css/dialog.css" type="text/css" media="screen" />');

?>
<script language="javascript" type="text/javascript">

function tableOrdering( order, dir, task )
{
        var form = document.adminForm;
 
        form.filter_order.value = order;
        form.filter_order_Dir.value = dir;
        document.adminForm.submit( task );
}

<!--

function submitbutton2(pressbutton) {
    myform = document.getElementById("adminForm");;
    mytask = document.getElementById("task");
    
    if (pressbutton) {
      mytask.value=pressbutton;
    }
     if (typeof myform.onsubmit == "function") {
        myform.onsubmit();
    }
    if (pressbutton == 'cancel') {
            myform.submit();
            return;
    }
    
    <?php
            $editor =& JFactory::getEditor();
            echo $editor->save( 'body' );
    ?>
    alert('submit task='+document.getElementById("task").value);
    myform.submit();
}


<!--
function setgood() {
	// TODO: Put setGood back
	
	return true;
}


//-->

</script>
<table>
	<tr><td>
<div class="componentheading"><?php echo JText::_('MAILING_LOG'); ?></div>
<div id="component-hecmailing">
</div>
<!--<div style="min-height:20px;width:100%;">
	<div class="toolbar" id="Toolbar">-->
		<table class="toolbar"><tr>
			<td class="button" id="User Toolbar-log">
  <a href="index.php?option=com_hecmailing" class="toolbar">
    <span class="icon-32-back" title="<?php echo JText::_('BACK')?>"></span><?php echo JText::_('BACK'); ?></a>
</td>
			
	</tr></table>
 <!--</div>
</div>
</div>-->
<hr>
</td></tr>
<tr><td>

<form Method="POST" Action="<?php echo "index.php"; ?>" name="adminForm" id="adminForm" onSubmit="setgood();" enctype="multipart/form-data">

	<table id="filter" ><tr>
		<td align="left"><?php echo JText::_("GROUP"); ?> : <?=$this->groupes ?></td>
		<td><?php echo JText::_( 'Filter' ); ?>: <input type="text" height="1" name="search2" id="search2" value="<?php echo $this->lists['search2']; ?>"  onchange="document.adminForm.submit();" /></td>
		<td><input type="submit" name="filter" id="filter"></td>
	</tr></table>


<table id="list" width="100%">
	<thead><tr><th width="10"><?php echo JText::_("ID_LOG"); ?></th>
		<th class="title"><a href="javascript:tableOrdering('u.username','desc','');" title="<?php echo JText::_('SORT_MSG'); ?>"><?php echo JText::_("USERNAME"); ?></a></th>
		<th class="title"><a href="javascript:tableOrdering('l.log_dt_sent','desc','');" title="<?php echo JText::_('SORT_MSG'); ?>"><?php echo JText::_("DATE_SEND"); ?></a></th>
		<th class="title"><a href="javascript:tableOrdering('l.log_vl_subject','desc','');" title="<?php echo JText::_('SORT_MSG'); ?>"><?php echo JText::_("SUBJECT"); ?></a></th>
		<th class="title"><a href="javascript:tableOrdering('l.log_vl_mailok','desc','');" title="<?php echo JText::_('SORT_MSG'); ?>"><?php echo JText::_("SEND_OK"); ?></a></th>
		<th class="title"><a href="javascript:tableOrdering('l.log_vl_mailerr','desc','');" title="<?php echo JText::_('SORT_MSG'); ?>"><?php echo JText::_("SEND_ERR"); ?></a></th></tr></thead>
	<tfoot><tr><td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
	<tbody>
	
	<?php
    $no=$this->pagination->limitstart; 
    foreach($this->logs as $obj)
	{ 
	  
	  $no++;
    if ($classrow=='row1')
    {
      $classrow = 'row2';
    }
    else
    {
      $classrow= 'row1';
    } 
    $detail = 'index.php?option=com_hecmailing&idlog='.$obj->log_id_message.'&task=viewlog';
    
    
    
  ?>
	<tr class="<?= $classrow; ?>" >
		<td><a href="<?= $detail; ?>" ><?= $obj->log_id_message  ?></a></td>
		<td><?=$obj->username ?></td><td><?=$obj->log_dt_sent ?></td><td><?=$obj->log_vl_subject ?></td>
		<td><?=$obj->log_nb_ok ?></td><td><?=$obj->log_nb_errors ?></td></tr>
	<?php  } ?>
	</tbody>
 </table>
<input type="hidden" name="task" value="log" >
<input type="hidden" name="option" value="com_hecmailing" >
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />	
  <?php echo JHTML::_( 'form.token' ); ?>	
</form>
</td></tr></table>
