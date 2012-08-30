<?php 
/**
* @version 1.7.0
* @package hecMailing for Joomla
* @module views.form.tmpl.default.php
* @subpackage : View Form (Sending mail form)
* @copyright Copyright (C) 2008-2011 Hecsoft All rights reserved.
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
*/
defined ('_JEXEC') or die ('restricted access'); 
jimport('joomla.html.html');
// Modif Joomla 1.6+
$mainframe = JFactory::getApplication();
$document = JFactory::getDocument();
// Modif pour J1.6+ : change $mainframe->addCustomHeadTag en   $document->addCustomTag
$document->addCustomTag('<link rel="stylesheet" href="components/com_hecmailing/css/toolbar.css" type="text/css" media="screen" />');
$document->addCustomTag('<link rel="stylesheet" href="components/com_hecmailing/css/dialog.css" type="text/css" media="screen" />');
$document->addCustomTag ('<link rel="stylesheet" href="components/com_hecmailing/libraries/jt/jt_DialogBox.css" type="text/css" />');
$document->addCustomTag ('<script src="components/com_hecmailing/libraries/jt/dom-drag.js" type="text/javascript"></script>');
//echo '<script src="components/com_hecmailing/libraries/jt/dom-drag.js" type="text/javascript"></script>\n';
$document->addCustomTag ('<script src="components/com_hecmailing/libraries/jt/jt_.js" type="text/javascript"></script>');
//echo '<script src="components/com_hecmailing/libraries/jt/jt_.js" type="text/javascript"></script>';
$document->addCustomTag ('<script src="components/com_hecmailing/libraries/jt/jt_DialogBox.js" type="text/javascript"></script>');
//echo '<script src="components/com_hecmailing/libraries/jt/jt_DialogBox.js" type="text/javascript"></script>';
$document->addCustomTag ('<link rel="stylesheet" href="components/com_hecmailing/libraries/jt/veils.css" type="text/css" />');
//$mainframe->addCustomHeadTag ('<script src="components/com_hecmailing/libraries/jt/jt_AppDialogs.js" type="text/javascript"></script>');
//$mainframe->addCustomHeadTag ('<script src="components/com_hecmailing/libraries/jt/MyApp_dialogs.js" type="text/javascript"></script>');
?>

<style type="text/css">
.liste{
	text-align:left;
	border:1px solid #4FBAB3;
	white-space:nowrap;
	font:normal 12px verdana;
	background:#fff;
  padding:5px;
  overflow: auto;
	height:50px;
}

.liste a{
	display:block;
	cursor:default;
	color:#000;
	text-decoration:none;
	background:#fff;
}

.liste a:hover{
	color:white;
	background-color:#7370CB;
}
</style>

<div id="loadtmpl" class="hecdialog" >
  <!--<div class="dlgheader"><h1><?php echo JText::_('COM_HECMAILING_LOAD_TEMPLATE'); ?></h1></div>-->
  <div class="image"><img src="components/com_hecmailing/images/disk.gif" width="64px"></div>
  <div class="content"><center><br/>
    <?php echo JText::_('COM_HECMAILING_SELECT_TEMPLATE_BELOW'); ?><br/><br/>
    <?php echo JText::_('COM_HECMAILING_TEMPLATE')." : ".$this->saved;?><br/><br/></center>
  </div>
  <div class="buttons"><center>
    <button onclick="javascript:loadTemplate();return false;">
      <img src="components/com_hecmailing/images/ok16.png" ><?php echo JText::_('COM_HECMAILING_LOAD'); ?>
    </button>
    <button onclick="javascript:cancel();return false;">
      <img src="components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('COM_HECMAILING_CANCEL'); ?>
    </button></center>
  </div>
</div>
<div id="savetmpl" class="hecdialog" >
  <!--<div class="dlgheader"><h1><?php echo JText::_('COM_HECMAILING_SAVE_TEMPLATE'); ?></h1></div>-->
  <div class="image"><img src="components/com_hecmailing/images/disk.gif" width="64px"></div>
  <div class="content"><center><br/>
    <?php echo JText::_('COM_HECMAILING_SAVE_TEMPLATE_INFO'); ?><br/><br/>
    <?php echo JText::_('COM_HECMAILING_SAVE_TEMPLATE_LABEL') ?><input type="text" id="tmplName" Name="tmplName" /><br/><br/></center>
  </div>
  <div class="buttons"><center>
    <button onclick="javascript:saveTemplate();return false;">
      <img src="components/com_hecmailing/images/ok16.png" ><?php echo JText::_('COM_HECMAILING_SAVE_TEMPLATE_BUTTON'); ?>
    </button>
    <button onclick="javascript:cancelSaveTmpl();return false;">
      <img src="components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('COM_HECMAILING_CANCEL'); ?>
    </button></center>
  </div>
</div>

<div id="browse" class="hecdialog" style="height:470px;width:330px;" >
  <!--<div class="dlgheader" style="width:320px" style="display:none;" ><h1><?php echo JText::_('COM_HECMAILING_BROWSE_FILES'); ?></h1></div>-->
  <div class="content" style="height:390px;" ><div id="Path" style="height:20px;"></div><div id="CurrentDir" style="display:none;"></div>
 	<!--<div class="image"><img src="components/com_hecmailing/images/disk.gif" width="64px"></div>-->
    <div id="liste" name="liste" class="liste" style="width:300px;height:350px;">.<br>..</div>
  </div>
  <div class="buttons">
    <button onclick="javascript:selectFile();return false;">
      <img src="components/com_hecmailing/images/ok16.png" ><?php echo JText::_('COM_HECMAILING_LOAD'); ?>
    </button>
    <button onclick="javascript:hideBrowse();return false;">
      <img src="components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('COM_HECMAILING_CANCEL'); ?>
    </button>
  </div>
</div>

<div id="msgbox">
<script language="javascript" type="text/javascript">
jt_DialogBox.imagePath = '<?php echo JURI::base( true ).'/components/com_hecmailing/libraries/jt/';?>';
var base_dir='<?php echo $this->browse_path; ?>';

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

  //alert('submit task='+document.getElementById("task").value);
  myform.submit();
}

function loadTemplate()
{
	iIdTemplate=document.getElementById("idTemplate");
	dlgTemplateNode = dlgTemplate.getContentNode();
	l = dlgTemplateNode.getElementsByTagName('select');
	s = l[0];
  selected = s.options[s.selectedIndex].value;
  if (selected>0)
  {
  		iIdTemplate.value=selected;
  		submitbutton('load');
  }
}

function saveTemplate()
{
	iSaveTemplate=document.getElementById("saveTemplate");
  dlgSaveTemplateNode = dlgSaveTemplate.getContentNode();
  l = dlgSaveTemplateNode.getElementsByTagName('input');
	s = l[0];
	iSaveTemplate.value=s.value;
	submitbutton('save');
}

function createContent(cid,title, width) {
		try {
			dlgbox = new jt_DialogBox(true);
		}
		catch (E) {
			alert('Probleme creation Dialog ' + cid + ':' + E);
		}
		content = document.getElementById(cid);
		dlgbox.setTitle(title);
		dlgbox.setContent(content.innerHTML);
		dlgbox.setWidth(width);
  	dlgbox.moveTo(-1,-1);
  	return (dlgbox);
}

dlgBrowse = null;
dlgTemplate = null;
dlgSaveTemplate = null;

function showLoadTemplate()
{
  if (dlgTemplate==null)
    dlgTemplate = createContent('loadtmpl','<?php echo JText::_('COM_HECMAILING_LOAD_TEMPLATE'); ?>', 400);    
  dlgTemplate.show();
 	dlgTemplate.moveTo(-1,-1);
  return false;  
}

function showSaveTemplate()
{
  if (dlgSaveTemplate==null)
  	dlgSaveTemplate = createContent('savetmpl','<?php echo JText::_('COM_HECMAILING_SAVE_TEMPLATE'); ?>', 400);    
  dlgSaveTemplate.show();
  dlgSaveTemplate.moveTo(-1,-1);
  return false;  
}

function cancelSaveTmpl()
{
  dlgSaveTemplate.hide();
}

function cancel()
{
   dlgTemplate.hide();
}

function showBrowse()
{
   if (dlgBrowse==null)
   {
     	dlgBrowsePath='';
    	dlgBrowseCurrentDir='';
     	dlgBrowseList='';
     	dlgBrowse = createContent('browse','<?php echo JText::_('COM_HECMAILING_BROWSE_SERVER'); ?>', 330);
    	dlgBrowseNode = dlgBrowse.getContentNode();
  		l = dlgBrowseNode.getElementsByTagName('div');
  		for (i in l)
  		{
  				el = l[i];
  				if (el.id=='liste')
    			{
    					dlgBrowseList=el;
    			}
    			if (el.id=='CurrentDir')
    			{
    					dlgBrowseCurrentDir = el;
    			}
    			if (el.id=='Path')
    			{
    					dlgBrowsePath = el;
    			}
    	}	
    }
    dlgBrowse.show();
    dlgBrowse.moveTo(-1,-1);
    fillList(curdir);
    return false;  
}

function hideBrowse()
{
  if (dlgBrowse!=null) dlgBrowse.hide();
  return false;  
}

// Add attachment row (file input)
function addAttachment()
{
 		var count = document.getElementById("attachcount");
 		var tab=document.getElementById("attachmentbody");
    var row=document.createElement("tr");
    var cell0 = document.createElement("td");
    n=0;
    n=count.value;
    n++;
    var iFile = document.createElement("input");
    iFile.name= 'attach'+n;
    iFile.id= 'attach'+n;
    iFile.type="file";
    iFile.style.width="100%";
    tab.appendChild(row);
    row.appendChild(cell0);
    cell0.appendChild(iFile);
 		count.value=n;
}

function selectDir()
{
	var lst=dlgBrowseList;
	var curdir = dlgBrowseCurrentDir.innerHTML;
	if (lst.substr(0,1) == '@')
	{
		lst = lst.substr(1);
		if (lst=='..')
		{
			n=-1;
			for(i=curdir.length-1;i>0;i--)
			{
				if (curdir.substr(i,1)=='/')
				{
						n=i;
						break;
				}
			}
  		newdir=curdir.substr(0,n);
  	}
  	else
  		newdir = curdir+'/'+lst 
		var poststr = "dir=" + encodeURI( newdir ) ;
		makePOSTRequest('<?php echo JURI::current()?>', poststr+"&task=getdir&format=raw&option=com_hecmailing");
  }
}

function selectFile()
{
		var count = document.getElementById("localcount");
 		var tab=document.getElementById("attachmentbody");
  	dlgnode = dlgBrowse.getContentNode();
 		sel = getSelected(dlgBrowseList);
 		if (curdir.length>0) ledir=curdir+'/';
 		else ledir='/'
 		for (i=0;i<sel.length;i++)
 		{
      row=document.createElement("TR");
      cell0 = document.createElement("TD");
      n=0;
      n=count.value;
      n++;
      var iFile = document.createElement("input");
      iFile.name= 'local'+n;
      iFile.id= 'local'+n;
      iFile.type="hidden";
      iFile.value = base_dir+ledir+sel[i];
      cell0.appendChild(iFile);
      iChk=document.createElement('input');
      iChk.name= 'chklocal'+n;
      iChk.id= 'chklocal'+n;
      iChk.checked=true;
      iChk.type='checkbox';
      iTxt = document.createTextNode('  ' + base_dir + ledir +  sel[i]);
      cell0.appendChild(iChk);
      cell0.appendChild(iTxt);
      tab.appendChild(row);
      row.appendChild(cell0);
   		count.value=n;
   }
   hideBrowse();
}

function addElement(divListe,path, isfolder)
{
	var a = document.createElement('a');
	num=divListe.childNodes.length;
  if (isfolder) // Dir
  {
  	a.id = 'folder'+num; 
  	a.ondblclick= function() { dbclick(this);return false; }
  	img = document.createElement('img');
  	img.src="<?php echo JURI::base( true )."/components/com_hecmailing/images/folder.gif"?>";
  	img.width=16;
  	img.height=16;
  	a.appendChild(img);
  	txt=document.createTextNode("  " + path);
  	a.appendChild(txt);
  }
  else
  {
  	a.id = 'file'+num;
  	a.onclick = function() { select(this);return false; }
  	chk = document.createElement('input');
  	chk.type='Checkbox';
  	chk.id= 'chk'+ a.id;
  	chk.name = path;
  	a.appendChild(chk);
  	txt=document.createTextNode(path);
  	a.appendChild(txt);
  }
  a.name=path;
  divListe.appendChild(a);
}

function resetList(divListe)
{
	obj=divListe;
	try {
    if(obj.hasChildNodes() && obj.childNodes) {
      while(obj.firstChild) {
        obj.removeChild(obj.firstChild);
      }
    }
  }
  catch(e) {
    //  do nothing, or uncomment the error message
    //alert(e.message);
  }
}

function getSelected(divListe)
{
	ret=new Array();
	lesCheck = divListe.getElementsByTagName('input');
	for (i=0;i< lesCheck.length;i++)
	{
		chk=lesCheck[i];
		if (chk.type=='checkbox')
		{
  		if (chk.checked)
  			ret.push(chk.name);
  	}
	}
	return ret;
}

function dbclick(param)
{
	if (param.name=='..')
	{
			k=-1;
			for(i=curdir.length-1;i>0;i--)
			{
				if (curdir.substr(i,1)=='/')
				{
						k=i;
						break;
				}
			}
			newdir=curdir.substr(0,k);
	}
	else
	{
  		newdir=curdir+'/'+ param.name;			
  }
  fillList( newdir);
}

function select(elmt)
{
	var chk = elmt.getElementsByTagName('input');
	chk=chk[0];
	chk.checked=!chk.checked;
}

var http_request = false;

function makePOSTRequest(url, parameters) 
{
    http_request = false;
    if (window.XMLHttpRequest) 
    { // Mozilla, Safari,...
       http_request = new XMLHttpRequest();
       if (http_request.overrideMimeType) 
       {
       		// set type accordingly to anticipated content type
          http_request.overrideMimeType('text/html');
       }
    } 
    else if (window.ActiveXObject) 
    { // IE
       try 
       {
          http_request = new ActiveXObject("Msxml2.XMLHTTP");
       } 
       catch (e) 
       {
          try 
          {
             http_request = new ActiveXObject("Microsoft.XMLHTTP");
          } 
          catch (e) {}
       }
    }
    if (!http_request) 
    {
       alert('Cannot create XMLHTTP instance');
       return false;
    }
    http_request.onreadystatechange = alertContents;
    http_request.open('POST', url, true);
    http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http_request.setRequestHeader("Content-length", parameters.length);
    http_request.setRequestHeader("Connection", "close");
    http_request.send(parameters);
}
var curdir='';

function alertContents() {
  if (http_request.readyState == 4) 
  {
     if (http_request.status == 200) 
     {
       	result = http_request.responseText;
				list=dlgBrowseList;	
				ret = result.split('|');
				resetList(list);
				n=true;
				for (i=0;i<ret.length-1;i++)           
				{
					 if (n)
					 {
  				 		curdir = ret[i];
  				 		n=false;
  				 }
  				 else
  				 {
  				 		elmt=ret[i];
  				 		var isfolder=false;
  				 		if (elmt.substr(0,1) == '@')
  						{
  								elmt = elmt.substr(1);
  								isfolder=true;
  						}	
  				 		addElement(list,elmt, isfolder);
  				 }
  			}           
  			cdir=dlgBrowseCurrentDir; 
  			cdir.innerHTML=curdir;
  			dlgBrowsePath.innerHTML = curdir;
     }
     else 
     {
        alert("<?php echo JText::_('COM_HECMAILING_BROWSE_PROBLEM'); ?> :" + http_request.status);
     }
  }
}

function fillList(dirname)
{
		list=dlgBrowseList;
		resetList(list);
		div = document.createElement('div');
		div.style.textAlign="center";
		div.style.width="100%";
		div.style.height="100%";
		img = document.createElement('img');
  	img.src="<?php echo JURI::base( true )."/components/com_hecmailing/images/ajax-loader.gif"?>";
  	l = (list.clientWidth-50)/2;
  	h = (list.clientHeight-50)/2;
  	img.style.marginLeft= l+"px";
  	img.style.marginTop= h+"px";
  	div.appendChild(img);
  	list.appendChild(div);
  	if (dirname==undefined)
  	{
  		dirname='';
  	}
   	var poststr = "option=com_hecmailing";
  	if (dirname!='')
  	{
  	  poststr = poststr + "&dir=" + encodeURI(  dirname ) ;
  	}
	  makePOSTRequest('<?php echo JURI::current()?>', poststr+'&task=getdir&format=raw');
}

function checksend()
{
	var grp = document.getElementById("groupe");
	val = grp.options[grp.selectedIndex].value;
	if (val<0)
	{
		alert('<?php echo JText::_('COM_HECMAILING_MSG_SELECT_GROUP'); ?>');
		return false;
	}
	var subject = document.getElementById("subject").value;
	if (subject.length==0)
	{
		alert('<?php echo JText::_('COM_HECMAILING_MSG_EMPTY_SUBJECT'); ?>');
		return false;
	}
	submitbutton('send');
}
<?php echo $this->rights; ?>
var current_group=0;
function showManageButton(selectBox)
{
	var btn = document.getElementById("manage_button");
	current_group=selectBox.options[selectBox.options.selectedIndex].value;
	flag=rights[current_group];
	if ((flag & 6)>0)
	{
		btn.style.visibility = 'visible';
	}
	else
	{
		btn.style.visibility = 'hidden';
	}
}
function manage_group()
{
	window.open("index2.php?option=com_hecmailing&task=manage_group&tmpl=component&idgroup='; ?>"+current_group,"<?php JText::_('MANAGE_GROUP') ?>","directories=no,location=no,menubar=no,resizable=yes,scrollbars=yes,status=yes,toolbar=no,width=800,height=600");
}
</script>
</div>

<form action="<?php echo JURI::current(); ?>" method="post" name="adminForm" id="adminForm" ENCTYPE="multipart/form-data">
<div class="componentheading"><?php echo JText::_('COM_HECMAILING_MAILING'); ?></div>
<div id="component-hecmailing">

</div>
<table class="toolbar"><tr>
<td class="button" id="User Toolbar-send">
  <a href="#" onclick="javascript: checksend();return false;"  class="toolbar">
    <span class="icon-32-send" title="<?php echo JText::_('COM_HECMAILING_SEND_INFO'); ?>"></span><?php echo JText::_('COM_HECMAILING_SEND'); ?></a></td>
<td class="button" id="User Toolbar-cancel">
  <a href="#" onclick="javascript: submitbutton('cancel');return false;"  class="toolbar">
    <span class="icon-32-cancel" title="<?php echo JText::_('COM_HECMAILING_CANCEL_MSG'); ?>"></span><?php echo JText::_('COM_HECMAILING_CANCEL'); ?></a></td>
<td class="spacer"></td><td class="spacer"></td><td class="spacer"></td><td class="spacer"></td>            
<td class="button" id="User Toolbar-save">
  <a href="#" onclick="javascript: showSaveTemplate();return false;"  class="toolbar">
    <span class="icon-32-save" title="<?php echo JText::_('COM_HECMAILING_SAVE_INFO'); ?>"></span><?php echo JText::_('COM_HECMAILING_SAVE'); ?></a></td>
<td class="button" id="User Toolbar-archive">
  <a href="#" onclick="javascript: showLoadTemplate();return false;"  class="toolbar">
    <span class="icon-32-archive" title="<?php echo JText::_('COM_HECMAILING_LOAD_TEMPLATE')?>"></span><?php echo JText::_('COM_HECMAILING_LOAD_TEMPLATE'); ?></a>
</td>
<td>&nbsp;</td>
<td class="button" id="User Toolbar-log">
  <a href="index.php?option=com_hecmailing&task=log" class="toolbar">
    <span class="icon-32-log" title="<?php echo JText::_('COM_HECMAILING_SHOW LOG')?>"></span><?php echo JText::_('COM_HECMAILING_SHOW_LOG'); ?></a>
</td>
</tr></table> 
<?php 
  echo $this->msg;

?>
<hr><br>
<table width="100%" class="admintable" style="valign:top">

  <tr valign="top"><td class="key"><?php echo JText::_('COM_HECMAILING_SENDER'); ?> :</td><td><?php echo $this->from; ?></td></tr>
  
  <tr valign="top"><td class="key"><?php echo JText::_('COM_HECMAILING_GROUP'); ?> :</td><td><?php echo $this->groupes; ?><button id="manage_button" style="visibility:hidden;" onClick="manage_group();return false;">MANAGE</button></td></tr>
  
  <tr valign="top"><td class="key"><?php echo JText::_('COM_HECMAILING_USE_PROFILE'); ?> :</td><td><input type="checkbox" name="useprofil" value="1" id="useprofil" <?php echo $this->default_use_profil; ?>> <small><?php echo JText::_('COM_HECMAILING_USE_PROFILE_TEXT'); ?></small></td></tr>
  
  <tr valign="top"><td class="key"><?php echo JText::_('COM_HECMAILING_BACKUP_MAIL'); ?> :</td><td><input type="checkbox" name="backup_mail" value="1" id="backup_mail" <?php echo $this->backup_mail; ?>> <small><?php echo JText::_('COM_HECMAILING_BACKUP_MAIL_TEXT'); ?></small></td></tr>
  
  <tr valign="top"><td class="key"><?php echo JText::_('COM_HECMAILING_CONTENT_IMAGE'); ?> :</td><td><input type="checkbox" name="incorpore" value="1" id="incorpore" <?php echo $this->image_incorpore; ?>> <small><?php echo JText::_('COM_HECMAILING_CONTENT_IMAGE_TEXT'); ?></small></td></tr>
  
  <tr valign="top"><td class="key"><?php echo JText::_('COM_HECMAILING_SUBJECT'); ?> :</td><td><input style="width:100%"  type="text" id="subject" name="subject" value="<?php echo $this->subject; ?>"></td></tr>
  
  <tr valign="top"><td class="key"><?php echo JText::_('COM_HECMAILING_ATTACHMENT'); ?> :</td><td>
  <table id="attachment" name="attachment">
    <tbody id="attachmentbody" name="attachmentbody">
    	<tr><td>
    		<button onclick="javascript:addAttachment();return false;"><?php echo JText::_('COM_HECMAILING_ADD_ATTACHMENT'); ?></button>
    		
    		<input type="button" value="<?php echo JText::_('COM_HECMAILING_BROWSE_SERVER'); ?>" onclick="javascript: showBrowse(); return false;" />
    	</td></tr>
  
  
  <?php
    $ilocal=0;
    foreach($this->attachment as $file)
    {
    	$ilocal++;
    	echo"<tr><td><input type=\"hidden\" name=\"local".$ilocal."\" id=\"local".$ilocal."\" value=\"".$file."\"><input type=\"checkbox\" name=\"chklocal".$ilocal."\" id=\"chklocal".$ilocal."\" checked=\"checked\">".$file."</td></tr>";
    }
    $iattach=0 ;
    for ($i=0;$i<$this->upload_input_count;$i++)
    {
    	$iattach++;
    	echo"<tr><td><input type=\"file\" name=\"attach".$iattach."\" id=\"attach".$iattach."\" ></td></tr>";
    
    }
  ?>
  </tbody></table>
  </td></tr>
  <tr valign="top"><td class="key"><?php echo JText::_('COM_HECMAILING_BODY'); ?> :</td><td>
  <?php
  $editor =& JFactory::getEditor();
  echo $editor->display('body', $this->body, $this->width, $this->height, '60', '20', true);
  ?>
  <input type="hidden" name="localcount" id="localcount" value="<?php echo $ilocal; ?>"><input type="hidden" name="attachcount" id="attachcount" value="<?php echo $iattach; ?>"></td></tr>
</table>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" id="option" value="com_hecmailing">
<!--<input type="hidden" name="view" id="view" value="form">-->
<input type="hidden" name="task" id="task" value="">
<input type="hidden" name="idTemplate" id="idTemplate" value="0">
<input type="hidden" name="saveTemplate" id="saveTemplate" value="">
</form>



