<?php 

defined ('_JEXEC') or die ('restricted access'); 
jimport('joomla.html.html');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/css/toolbar.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/css/dialog.css" type="text/css" media="screen" />');

?>

<script language="javascript" type="text/javascript">

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
	function showLoadTemplate()
		{
        document.getElementById("loadtmpl").style.visibility = "visible";
      
        return false;  
    }
 function cancel()
    {
            document.getElementById("loadtmpl").style.visibility = "hidden";
            
    }
//-->

</script>

<div>
<form action="index.php" method="post" name="adminForm" id="adminForm" ENCTYPE="multipart/form-data">

<div class="componentheading"><?php echo JText::_('MAILING_LOG_DETAIL'); ?></div>
<div id="component-hecmailing">
</div>

<table class="toolbar"><tr>

<td class="button" id="User Toolbar-cancel">
   <a href="index.php?option=com_hecmailing" class="toolbar">
    <span class="icon-32-cancel" title="<?php echo JText::_('CANCEL_MSG'); ?>"></span><?php echo JText::_('Cancel'); ?></a></td>
<td class="spacer"></td><td class="spacer"></td><td class="spacer"></td><td class="spacer"></td>
<td>&nbsp;</td>
<td class="button" id="User Toolbar-log">
  <a href="index.php?option=com_hecmailing&idlog=<?=$this->idlog ?>" class="toolbar">
    <span class="icon-32-send" title="<?php echo JText::_('SEND_AGAIN')?>"></span><?php echo JText::_('SEND_AGAIN'); ?></a>
</td>
<td class="button" id="User Toolbar-log">
  <a href="index.php?option=com_hecmailing&task=log" class="toolbar">
    <span class="icon-32-back" title="<?php echo JText::_('BACK')?>"></span><?php echo JText::_('BACK'); ?></a>
</td>

</tr></table> 

<?php echo $this->msg;

  $data=$this->data; 
  $mailok =$data->log_vl_mailok; 
  
  $okformatte = str_replace(";","; ",$mailok);
  $mailerr =$data->log_vl_mailerr; 
  $errformatte = str_replace(";","; ",$mailerr);
	if ($data)
	{
?>
<hr><br>

<table width="100%" class="admintable" style="valign:top">
<tr valign="top"><td nowrap class="key"><?php echo JText::_('DATE_SEND'); ?>:</td><td><?php echo $data->log_dt_sent; ?></td></tr>
<tr valign="top"><td nowrap class="key"><?php echo JText::_('SENDER'); ?>:</td><td><?php echo $data->log_vl_from; ?></td></tr>
<tr valign="top"><td nowrap class="key"><?php echo JText::_('GROUP'); ?>:</td><td><?php echo $data->grp_nm_groupe; ?></td></tr>
<tr valign="top"><td nowrap class="key"><?php echo JText::_('SEND_OK'); ?>:</td><td><?=$okformatte; ?></td></tr>
<tr valign="top"><td nowrap class="key"><?php echo JText::_('SEND_ERR'); ?>:</td><td><?=$errformatte; ?></td></tr>
<tr valign="top"><td nowrap class="key"><?php echo JText::_('SUBJECT'); ?>:</td><td><?=$data->log_vl_subject; ?></td></tr>
<tr valign="top"><td nowrap class="key"><?php echo JText::_('ATTACHMENT'); ?>:</td><td><?php
	echo "<i>";
	foreach ($data->attachment as $file)
	{
		echo $file . "<br>";
	}
	echo "</i>";
	?></td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('BODY'); ?> :</td><td>

<?php


echo $data->log_vl_body;

?>

</td></tr>

</td></tr></table>


<?php 
}
else
{
	echo "<span class=\"error\">Le message n'existe pas</span>";
}
echo JHTML::_( 'form.token' ); ?>

<input type="hidden" name="option" id="option" value="com_hecmailing">
<!--<input type="hidden" name="view" id="view" value="form">-->
<input type="hidden" name="task" id="task" value="">

</form>
</div>
