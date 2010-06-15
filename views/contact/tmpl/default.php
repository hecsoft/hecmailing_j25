<?php 

defined ('_JEXEC') or die ('restricted access'); 
jimport('joomla.html.html');
/*$cpath="components/com_hecmailing/libraries/crypt";
$cryptinstall=$cpath."/cryptographp.fct.php";
include $cryptinstall; */
require_once('components/com_hecmailing/libraries/recaptcha/recaptchalib.php');

// Get a key from http://recaptcha.net/api/getkey
//$publickey = "6LdY6AsAAAAAACn2_Mq5qa7Ro_E3UaScqIv5iysB ";
//$privatekey = "6LdY6AsAAAAAAK6GF1sb7WpqBc61Xb4cpNE57hRO";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

/*"<table><tr>
		<td><img id='cryptogram' src='" . $cpath . "/cryptographp.php?cfg=0&'></td>
		<td><a title='".JText::_("RESET CAPTCHA")."' style=\"cursor:pointer\" onclick=\"javascript:document.images.cryptogram.src=\'".$cpath."/cryptographp.php?cfg=0&&\'+Math.round(Math.random(0)*1000)+1\"><img src=\"".$cpath."/images/reload.png\"></a> </td>
		<td valign=\"bottom\" align=\"center\">".JText::_('COPY_CODE').":<br><input type=\"text\" name=\"captcha\" size=\"20\" id=\"captcha\"></td>
  		</tr></table>";*/

$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/css/toolbar.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/css/dialog.css" type="text/css" media="screen" />');
/*$mainframe->addCustomHeadTag ('<script type="text/javascript" src="components/com_hecmailing/libraries/jcap/md5.js"></script>');
$mainframe->addCustomHeadTag ('<script type="text/javascript" src="components/com_hecmailing/libraries/jcap/jcap.js"></script>');*/
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
var oldid=0;
function showInfo(id)
{
	
	
	var infodiv = document.getElementById("info");
 	if (id!="0")
 	{   
 	 	
 
	    var infocontact = document.getElementById("info"+id);
	    infodiv.innerHTML = infocontact.value;
	   
 	}
 	else
 	{
 		infodiv.innerHTML = '';
 	}  
    return true;  

}    
function checkcap(){
	return true;
	var uword = hex_md5(document.getElementById('captcha').value);

	if (uword==cword[anum-1]) {
	return true;
	}

	else {
	alert("<?php echo JText::_("INVALID_CAPTCHA"); ?>");
	document.getElementById('captcha').focus();
	return false;
	}
	}
//-->
<?php
if ($this->lang != '')
{
	$lang_tab = split('-',$this->lang);
	$lang = $lang_tab[0];
	$theme = $this->captcha_theme;
	/* Theme : red , white, blackglass, clean */
	echo "var RecaptchaOptions = {   lang : '".$lang."', theme:'".$theme."' };";	
}

?>

</script>


<form action="index.php?option=com_hecmailing&task=send_contact" method="post" name="adminForm" id="adminForm" ENCTYPE="multipart/form-data" onsubmit="return checkcap();">
<input type="hidden" id="required" name="required" value="uword">
<div class="componentheading"><?php echo $this->title; ?></div>
<div id="component-hecmailing">
</div>


<?php echo $this->msg;

 

?>
<hr><br>

<table width="100%" class="admintable" style="valign:top">

<tr valign="top"><td class="key"><?php echo JText::_('CONTACT_WHO'); ?> :</td><td><?php echo $this->contacts; ?></td></tr>
<tr valign="top"><td class="key"></td><td><div id="info" name="info"></div>
<?php 
$i=0;
foreach($this->infolist as $info)
{
	
	echo "<input type=\"hidden\" id=\"info" . $this->infoid[$i] . "\" name=\"info" . $this->infoid[$i] . "\" value=\"".$info."\" >";
	$i++; 
}

?>

</td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('YOUR_EMAIL'); ?> :</td><td><input type="text" id="email" name="email" value="<?php echo $this->email; ?>" /> </td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('YOUR_NAME'); ?> :</td><td><input type="text" id="name" name="name" value="<?php echo $this->name; ?>" /> </td></tr>


<tr valign="top"><td class="key"><?php echo JText::_('CONTACT_SUBJECT'); ?> :</td><td><input style="width:100%"  type="text" id="subject" name="subject" value="<?=$this->subject; ?>" /></td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('CONTACT_BODY'); ?> :</td><td>



<textarea id="body" width="300px" cols="50"  name="body" rows="4"><?=$this->body; ?> </textarea>
<?php
/*
$editor =& JFactory::getEditor();

echo $editor->display('body', $this->body, $this->width, $this->height, '60', '20', true);
*/
?>
</td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('CONTACT_BACKUP_MAIL'); ?> :</td><td><input type="checkbox" name="backup_mail" value="1" id="backup_mail" <?php echo $this->backup_mail; ?> /> </td></tr>
<?php
	if ($this->captcha_show_logged=='1')
	{
		?>
		<tr valign="top"><td class="key"><?php echo JText::_('ANTISPAM'); ?> :</td><td><?php echo JText::_("COPY_CODE"); ?><br><?php echo recaptcha_get_html($this->publickey, $error); ?>
	<input type="hidden" name="check_captcha" id="check_captcha" value="1"></td></tr>
	<?php
}
else
{
	?>
	<input type="hidden" name="check_captcha" id="check_captcha" value="0">
	<?php
}
?>
<tr><td colspan="2" align="center"><input type="submit" name="sendContact" value="<?php echo JText::_('SEND_CONTACT'); ?>"></input>
</td></tr></table>


<?php echo JHTML::_( 'form.token' ); ?>

<input type="hidden" name="option" id="option" value="com_hecmailing">
<!-- <input type="hidden" name="view" id="view" value="contact">  -->
<input type="hidden" name="task" id="task" value="send_contact">

</form>

