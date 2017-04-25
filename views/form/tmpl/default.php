<?php 

defined ('_JEXEC') or die ('restricted access'); 
jimport('joomla.html.html');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/css/toolbar.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/css/dialog.css" type="text/css" media="screen" />');
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/libraries/jt/jt_DialogBox.css" type="text/css" />');
$mainframe->addCustomHeadTag ('<script src="components/com_hecmailing/libraries/jt/dom-drag.js" type="text/javascript"></script>');
//echo '<script src="components/com_hecmailing/libraries/jt/dom-drag.js" type="text/javascript"></script>\n';
$mainframe->addCustomHeadTag ('<script src="components/com_hecmailing/libraries/jt/jt_.js" type="text/javascript"></script>');
//echo '<script src="components/com_hecmailing/libraries/jt/jt_.js" type="text/javascript"></script>';
$mainframe->addCustomHeadTag ('<script src="components/com_hecmailing/libraries/jt/jt_DialogBox.js" type="text/javascript"></script>');
//echo '<script src="components/com_hecmailing/libraries/jt/jt_DialogBox.js" type="text/javascript"></script>';
$mainframe->addCustomHeadTag ('<link rel="stylesheet" href="components/com_hecmailing/libraries/jt/veils.css" type="text/css" />');

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
  <!--<div class="dlgheader"><h1><?php echo JText::_('LOAD_TEMPLATE'); ?></h1></div>-->
  <div class="image"><img src="components/com_hecmailing/images/disk.gif" width="64px"></div>
  <div class="content"><center><br/>
    <?php echo JText::_('SELECT_TEMPLATE_BELOW'); ?><br/><br/>
<?php echo JText::_('TEMPLATE')." : ".$this->saved;?><br/><br/></center>
  </div>
  <div class="buttons"><center>
    <button onclick="javascript:loadTemplate();return false;">
      <img src="components/com_hecmailing/images/ok16.png" ><?php echo JText::_('LOAD'); ?>
    </button>
    <button onclick="javascript:cancel();return false;">
      <img src="components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('CANCEL'); ?>
    </button></center>
  </div>
  
</div>
<div id="savetmpl" class="hecdialog" >
  <!--<div class="dlgheader"><h1><?php echo JText::_('SAVE_TEMPLATE'); ?></h1></div>-->
  <div class="image"><img src="components/com_hecmailing/images/disk.gif" width="64px"></div>
  <div class="content"><center><br/>
    <?php echo JText::_('SAVE_TEMPLATE_INFO'); ?><br/><br/>
<?php echo JText::_('SAVE_TEMPLATE_LABEL') ?><input type="text" id="tmplName" Name="tmplName" /><br/><br/></center>
  </div>
  <div class="buttons"><center>
    <button onclick="javascript:saveTemplate();return false;">
      <img src="components/com_hecmailing/images/ok16.png" ><?php echo JText::_('SAVE_TEMPLATE_BUTTON'); ?>
    </button>
    <button onclick="javascript:cancelSaveTmpl();return false;">
      <img src="components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('CANCEL'); ?>
    </button></center>
  </div>
  
</div>

<div id="browse" class="hecdialog" style="height:470px;width:330px;" >
  <!--<div class="dlgheader" style="width:320px" style="display:none;" ><h1><?php echo JText::_('BROWSE FILES'); ?></h1></div>-->
  
  <div class="content" style="height:390px;" ><div id="Path" style="height:20px;"></div><div id="CurrentDir" style="display:none;"></div>
  	<!--<div class="image"><img src="components/com_hecmailing/images/disk.gif" width="64px"></div>-->
  	
    <div id="liste" name="liste" class="liste" style="width:300px;height:350px;">.<br>..
    </div>
  </div>
  <div class="buttons">
    <button onclick="javascript:selectFile();return false;">
      <img src="components/com_hecmailing/images/ok16.png" ><?php echo JText::_('LOAD'); ?>
    </button>
    <button onclick="javascript:hideBrowse();return false;">
      <img src="components/com_hecmailing/images/cancel16.png" ><?php echo JText::_('CANCEL'); ?>
    </button>
  </div>
  
</div>

<div id="msgbox">
<script language="javascript" type="text/javascript">

jt_DialogBox.imagePath = 'components/com_hecmailing/libraries/jt/';
var root_dir='<?php echo realpath(JPATH_ROOT).$this->browse_path; ?>';
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
    		dlgTemplate = createContent('loadtmpl','<?php echo JText::_('LOAD_TEMPLATE'); ?>', 400);    
        dlgTemplate.show();
      
        return false;  
    }

	function showSaveTemplate()
	{
    if (dlgSaveTemplate==null)
		dlgSaveTemplate = createContent('savetmpl','<?php echo JText::_('SAVE_TEMPLATE'); ?>', 400);    
    dlgSaveTemplate.show();
  
    return false;  
}
	function cancelSaveTmpl()
    {
            //document.getElementById("loadtmpl").style.visibility = "hidden";
            
            dlgSaveTemplate.hide();
    }
 function cancel()
    {
            //document.getElementById("loadtmpl").style.visibility = "hidden";
            
            dlgTemplate.hide();
    }
    
    function showBrowse()
		{
				
        if (dlgBrowse==null)
        {
        	dlgBrowsePath='';
        	dlgBrowseCurrentDir='';
        	dlgBrowseList='';
        	dlgBrowse = createContent('browse','<?php echo JText::_('BROWSE FILES'); ?>', 330);
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
      	fillList(curdir);
        return false;  
    }
    
     function hideBrowse()
		{
        //document.getElementById("browse").style.visibility = "hidden";
        if (dlgBrowse!=null) dlgBrowse.hide();
      
        return false;  
    }
    
 function addAttachment()
 {
 		
 		var count = document.getElementById("attachcount");
 		
 		var tab=document.getElementById("attachment");
 		
    row=document.createElement("TR");
    
    cell0 = document.createElement("TD");
    n=0;
    n=count.value;
    n++;
    iFile = document.createElement("input");
    iFile.name= 'attach'+n;
    iFile.id= 'attach'+n;
    iFile.type="file";
    iFile.style.width="100%";
    cell0.appendChild(iFile);
    row.appendChild(cell0);
    tab.appendChild(row);
 		count.value=n;
 		
}


function selectDir()
{
	
	
	//var lst=document.getElementById("files").value;
	var lst=dlgBrowseList;
	
	var curdir = dlgBrowseCurrentDir.innerHTML; //document.getElementById("CurrentDir").innerHTML;
	
	
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
		
		//alert ('Voir ' + newdir);
		var poststr = "dir=" + encodeURI( root_dir + '/' + newdir ) ;
	
		makePOSTRequest('components/com_hecmailing/libraries/getDir.php', poststr);
	}
	//curdir.innerHTML = curdir.innerHTML+"/"+lst.value;
}

function selectFile()
{
		var count = document.getElementById("localcount");
 		
 		var tab=document.getElementById("attachment");
 		//var list = document.getElementById("liste");
 		
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
    iFile = document.createElement("input");
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
    row.appendChild(cell0);
    tab.appendChild(row);
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
  	img.src="components/com_hecmailing/images/folder.gif";
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
	//lesCheck = divListe.getElementsByTagName('a');
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
            	//list = document.getElementById('liste');
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
							cdir=dlgBrowseCurrentDir; //document.getElementById('CurrentDir');
							cdir.innerHTML=curdir;
							dlgBrowsePath.innerHTML = '<?php echo $this->browse_path; ?>'+curdir;
         }
         else 
         {
            alert("<?php echo JText::_('BROWSE_PROBLEM'); ?>");
            //alert('ERROR');
         }
      }
   }

function fillList(dirname)
{
		//list = document.getElementById('liste');
		
		list=dlgBrowseList;
		resetList(list);
		div = document.createElement('div');
		div.style.textAlign="center";
		div.style.width="100%";
		div.style.height="100%";
		img = document.createElement('img');
  	img.src="components/com_hecmailing/images/ajax-loader.gif";
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
  	var poststr = "root=" + encodeURI( root_dir );
		if (dirname=='')
		{
			
			poststr = poststr ;
			
			
		}
		else
		{
		  poststr = poststr +  "&dir=" + encodeURI(  dirname ) ;
		 
			
		}
		
		makePOSTRequest('components/com_hecmailing/libraries/getDir.php', poststr);
}
function checksend()
{
	var grp = document.getElementById("groupe");
	val = grp.options[grp.selectedIndex].value;
	if (val<0)
	{
		alert('<?php echo JText::_('MSG_SELECT_GROUP'); ?>');
		return false;
	}
	var subject = document.getElementById("subject").value;
	
	if (subject.length==0)
	{
		alert('<?php echo JText::_('MSG_EMPTY_SUBJECT'); ?>');
		return false;
	}
	
	submitbutton('send');
}
</script>

</div>
<form action="index.php" method="post" name="adminForm" id="adminForm" ENCTYPE="multipart/form-data">

<div class="componentheading"><?php echo JText::_('MAILING'); ?></div>
<div id="component-hecmailing">
</div>

<table class="toolbar"><tr>
<td class="button" id="User Toolbar-send">
  <a href="#" onclick="javascript: checksend();return false;"  class="toolbar">
    <span class="icon-32-send" title="<?php echo JText::_('SEND_INFO'); ?>"></span><?php echo JText::_('Send'); ?></a></td>
<td class="button" id="User Toolbar-cancel">
  <a href="#" onclick="javascript: submitbutton('cancel');return false;"  class="toolbar">
    <span class="icon-32-cancel" title="<?php echo JText::_('CANCEL_MSG'); ?>"></span><?php echo JText::_('Cancel'); ?></a></td>
<td class="spacer"></td><td class="spacer"></td><td class="spacer"></td><td class="spacer"></td>
<td class="button" id="User Toolbar-save">
  <a href="#" onclick="javascript: showSaveTemplate();return false;"  class="toolbar">
    <span class="icon-32-save" title="<?php echo JText::_('SAVE_INFO'); ?>"></span><?php echo JText::_('SAVE'); ?></a></td>

<td class="button" id="User Toolbar-archive">
  <a href="#" onclick="javascript: showLoadTemplate();return false;"  class="toolbar">
    <span class="icon-32-archive" title="<?php echo JText::_('LOAD_TEMPLATE')?>"></span><?php echo JText::_('LOAD_TEMPLATE'); ?></a>
</td>
<td>&nbsp;</td>
<td class="button" id="User Toolbar-log">
  <a href="index.php?option=com_hecmailing&task=log" class="toolbar">
    <span class="icon-32-log" title="<?php echo JText::_('SHOW LOG')?>"></span><?php echo JText::_('SHOW_LOG'); ?></a>
</td>

</tr></table> 

<?php echo $this->msg;

  $obj=$this->obj; 

?>
<hr><br>

<table width="100%" class="admintable" style="valign:top">

<tr valign="top"><td class="key"><?php echo JText::_('SENDER'); ?> :</td><td><?php echo $this->from; ?></td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('GROUP'); ?> :</td><td><?php echo $this->groupes; ?></td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('USE_PROFILE'); ?> :</td><td><input type="checkbox" name="useprofil" value="1" id="useprofil" <?php echo $this->default_use_profil; ?>> <small><?php echo JText::_('USE_PROFILE_TEXT'); ?></small></td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('BACKUP_MAIL'); ?> :</td><td><input type="checkbox" name="backup_mail" value="1" id="backup_mail" <?php echo $this->backup_mail; ?>> <small><?php echo JText::_('BACKUP_MAIL_TEXT'); ?></small></td></tr>

<tr valign="top"><td class="key"><?php echo JText::_('CONTENT_IMAGE'); ?> :</td><td><input type="checkbox" name="incorpore" value="1" id="incorpore" <?php echo $this->image_incorpore; ?>> <small><?php echo JText::_('CONTENT_IMAGE_TEXT'); ?></small></td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('SUBJECT'); ?> :</td><td><input style="width:100%"  type="text" id="subject" name="subject" value="<?=$this->subject; ?>"></td></tr>
<tr valign="top"><td class="key"><?php echo JText::_('ATTACHMENT'); ?> :</td><td>
<table id="attachment" name="attachment">
	<tr><td>
		<button onclick="javascript:addAttachment();return false;"><?php echo JText::_('ADD_ATTACHMENT'); ?></button>
		<input type="hidden" name="attachcount" id="attachcount" value="0">
		<input type="button" value="<?php echo JText::_('BROWSE_SERVER'); ?>" onclick="javascript: showBrowse(); return false;" />
	</td></tr>
<?php
$ilocal=0;

foreach($this->attachment as $file)
{
	$ilocal++;
	echo"<tr><td><input type=\"hidden\" name=\"local".$ilocal."\" id=\"local".$ilocal."\" value=\"".$file."\"><input type=\"checkbox\" name=\"chklocal".$ilocal."\" id=\"chklocal".$ilocal."\" checked=\"checked\">".$file."</td></tr>";
	
}
?>
</table>

	</td></tr>
	
<tr valign="top"><td class="key"><?php echo JText::_('BODY'); ?> :</td><td>

<?php

/*<textarea id="desc" width="300px" cols="50"  name="desc" rows="4"><?=$obj->desc </textarea>*/

$editor =& JFactory::getEditor();

echo $editor->display('body', $this->body, $this->width, $this->height, '60', '20', true);

?>

<input type="hidden" name="localcount" id="localcount" value="<?php echo $ilocal ?>"></td></tr>

</table>


<?php echo JHTML::_( 'form.token' ); ?>

<input type="hidden" name="option" id="option" value="com_hecmailing">
<!--<input type="hidden" name="view" id="view" value="form">-->
<input type="hidden" name="task" id="task" value="">
<input type="hidden" name="idTemplate" id="idTemplate" value="0">
<input type="hidden" name="saveTemplate" id="saveTemplate" value="">

</form>

