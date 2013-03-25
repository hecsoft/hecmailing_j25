function createContent(cid,title, width) {
	dlgbox = new jt_DialogBox(true);
	if (title=='')
		dlgbox.setTitle(document.getElementById(cid+"_title").innerHTML);
	else
		dlgbox.setTitle(title);
	dlgbox.setContent(document.getElementById(cid).innerHTML);
	dlgbox.setWidth(width);
	btnnewuser = document.getElementById('btnnewuser');
	x = 30;
	y = 100;
	dlgbox.moveTo(x,y);
	return (dlgbox);
}

var dlg1 = null;
var dlg2 = null;
var dlg3 = null;
var dlg4 = null;
var dlg5 = null;
var dlg6 = null;
var dlg7 = null;
var newuser=null;	
var newmail=null;
var newgroupe=null;
var newuserperm=null;	
var newgroupeperm=null;
var msgdelitem=null;
var newuserpermsend=null;
var newuserpermmanage=null;
var newuserpermgrant=null;
var newgrouppermsend=null;
var newgrouppermmanage=null;
var newgrouppermgrant=null;
var base_url="../";
function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	// do field validation
	if ( form.name.value == "" ) {
		alert( submit_MustName );
	} else {
		submitform( pressbutton );
	}
}
function showImport()
{
    var mydiv = document.getElementById('dialog_import');
	if (mydiv.style.display== 'none')
	{
		mydiv.style.display = 'block';
	}
	else
	{
		mydiv.style.display = 'none';
	}
    return false;  
}
function showAddNewUser()
{
   	if (dlg1 == null) 
   	{
		dlg1 = createContent('dialog','', 300);
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

function showAddNewUserPerm()
{
  	if (dlg5 == null) 
  	{
  		dlg5 = createContent('dialog5','', 300);
  		dlgNode = dlg5.getContentNode();
		l = dlgNode.getElementsByTagName('select');
		for (i in l)
		{
			el = l[i];
			if (el.id=='newuser')
			{
				newuserperm=el;
			}
		}
		l = dlgNode.getElementsByTagName('input');
		for (i in l)
		{
			el = l[i];
			if (el.id=='right_send')
			{
				newuserpermsend=el;
			}
			else if (el.id=='right_manage')
			{
				newuserpermmanage=el;
			}
			else if (el.id=='right_grant')
			{
				newuserpermgrant=el;
			}
		}	
  	}
	dlg5.show();
  	return false;  
}

function showAddNewMail()
{
    if (dlg4 == null) 
    {
		dlg4 = createContent('dialog4','', 300);
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
	   	dlg2 = createContent('dialog2','', 300);
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

function showAddNewGroupePerm()
{
    if (dlg6==null)
    {
    	dlg6 = createContent('dialog6','', 300);
    	dlgNode = dlg6.getContentNode();
		l = dlgNode.getElementsByTagName('select');
		for (i in l)
		{
			el = l[i];
			if (el.id=='newgroupe')
			{
				newgroupeperm=el;
			}
		}
		l = dlgNode.getElementsByTagName('input');
		for (i in l)
		{
			el = l[i];
			if (el.id=='rightg_send')
			{
				newgrouppermsend=el;
			}
			else if (el.id=='rightg_manage')
			{
				newgrouppermmanage=el;
			}
			else if (el.id=='rightg_grant')
			{
				newgrouppermgrant=el;
			}
		}			
    }
    dlg6.show();
    return false;  
}

function showDeleteEntry()
{
    var table = document.getElementById("detail"); 
    var rowCount = 0;
    rowCount=table.rows.length;  
    nb=0;
    for(var i=0; i<rowCount; i++) 
    {  
        var row = table.rows[i]; 
        try
        {
	        var chkbox = row.cells[0].childNodes[0]; 
	        if(null != chkbox && true == chkbox.checked) 
	        {
	            nb++;         
	        }
        }
        catch(err)
        { }
    }
    
    if (nb>0)
    {
    
	      if (dlg3==null) {
	      	dlg3 = createContent('dialog3','', 300);
	      	dlgNode = dlg3.getContentNode();
			l = dlgNode.getElementsByTagName('div');
			for (i in l)
			{
				el = l[i];
				if (el.id=='dialog3_msg')
				{
					msgdelitem=el;
				}
			}
	      }
	      
	      if (msgdelitem!=null)
	    	  msgdelitem.innerHTML = text_wantremove+' '+nb+' '+text_items; 
	      dlg3.show();
    }
    else
    {
      alert(text_noitem);
    }
    return false;  
}    



function showDeletePermEntry()
{
    
    var table = document.getElementById("permissions");  
    var rowCount = table.rows.length;  
    nb=0;
    for(var i=0; i<rowCount; i++) 
    {  
        var row = table.rows[i];  
        try
        {
	        var chkbox = row.cells[0].childNodes[0];  
	        if(null != chkbox && true == chkbox.checked) 
	        {
	            nb++;         
	        }  
        }
        catch(err) {}
        
    }
    if (nb>0)
    {
    	var msg = document.getElementById("dialog7_msg");
      if (dlg7==null)
      	dlg7 = createContent('dialog7','', 300);
      dlg7.show();
      msg.innerHTML = text_wantremove+nb+' '+text_perms; 
    }
    else
    {
      alert(text_noperm);
    }
    return false;  
}    

function addUser()
{
    var nbnew = document.getElementById("nbnew");
    dlg1.hide();
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
    img.src=base_url+"components/com_hecmailing/images/user16.png";
    textnode1=document.createTextNode(text_user);
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

function addUserPerm()
{
	var nbnew = document.getElementById("nbnewperm");
	dlg5.hide();
	user=newuserperm;
	tab=document.getElementById("permissions");
	tabBody=tab.getElementsByTagName("TBODY").item(0);
	row=document.createElement("TR");
	cell0 = document.createElement("TD");
	cell1 = document.createElement("TD");
	cell2 = document.createElement("TD");
	cell3 = document.createElement("TD");
	cell4 = document.createElement("TD");
	cell5 = document.createElement("TD");
	chknode = document.createElement("input");
	n=0;
	n=nbnew.value;
	n++;

	chknode.name= 'suppressnewperm'+n;
	chknode.id= 'suppressnewperm'+n;
	chknode.value=0;
	chknode.type="checkbox";
	
	chksend = document.createElement("input");
	chksend.name= 'newperm_send'+n;
	chksend.value="1";
	chksend.id= 'newperm_send'+n;
	chksend.checked=newuserpermsend.checked;
	chksend.type="checkbox";
	
	chkmanage = document.createElement("input");
	chkmanage.name= 'newperm_manage'+n;
	chkmanage.value="1";
	chkmanage.id= 'newperm_manage'+n;
	chkmanage.checked=newuserpermmanage.checked;
	chkmanage.type="checkbox";
	
	chkgrant = document.createElement("input");
	chkgrant.name= 'newperm_grant'+n;
	chkgrant.id= 'newperm_grant'+n;
	chkgrant.value="1";
	chkgrant.checked=newuserpermgrant.checked;
	chkgrant.type="checkbox";
	
	
	img = document.createElement("img");
	img.src=base_url+"components/com_hecmailing/images/user16.png";
	textnode1=document.createTextNode(text_user);
	textnode2=document.createTextNode(user.options[user.selectedIndex].text);
	hid = document.createElement("input");
	hid.name= 'newperm'+n;
	hid.id= 'newperm'+n;
	hid.type="hidden";
	hid.value= "2;"+user.value;
	cell0.appendChild(chknode);
	cell1.appendChild(img);
	cell1.appendChild(textnode1);
	cell2.appendChild(textnode2);
	cell0.appendChild(hid);
	cell3.appendChild(chksend);
	cell4.appendChild(chkmanage);
	cell5.appendChild(chkgrant);
	row.appendChild(cell0);
	row.appendChild(cell1);
	row.appendChild(cell2);
	row.appendChild(cell3);
	row.appendChild(cell4);
	row.appendChild(cell5);
	tabBody.appendChild(row);
	nbnew.value=n;
}

function addMail()
{
	var nbnew = document.getElementById("nbnew");
	dlg4.hide();
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
	img.src=base_url+"components/com_hecmailing/images/email16.png";
	textnode1=document.createTextNode(text_mail);
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
	dlg2.hide();
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
	img.src=base_url+"components/com_hecmailing/images/group16.png";
	hid.value= "3;"+grp.value;
	chknode.name= 'suppressnew'+n;
	chknode.id= 'suppressnew'+n;
	chknode.value=0;
	chknode.type="checkbox";
	textnode1=document.createTextNode(text_group);
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

function addGroupePerm()
{
	var nbnew = document.getElementById("nbnewperm");
	dlg6.hide();
	grp = newgroupeperm;
	tab=document.getElementById("permissions");
	tabBody=tab.getElementsByTagName("TBODY").item(0);
	row=document.createElement("TR");
	cell0 = document.createElement("TD");
	cell1 = document.createElement("TD");
	cell2 = document.createElement("TD");
	cell3 = document.createElement("TD");
	cell4 = document.createElement("TD");
	cell5 = document.createElement("TD");

	chknode = document.createElement("input");
	n=0;
	n=nbnew.value;
	n++;
	hid = document.createElement("input");
	hid.name= 'newperm'+n;
	hid.id= 'newperm'+n;
	hid.type="hidden";
	img = document.createElement("img");
	img.src=base_url+"components/com_hecmailing/images/group16.png";
	hid.value= "3;"+grp.value;
	chknode.name= 'suppressnewperm'+n;
	chknode.id= 'suppressnewperm'+n;
	chknode.value=0;
	chknode.type="checkbox";
	
	chksend = document.createElement("input");
	chksend.name= 'newperm_send'+n;
	chksend.id= 'newperm_send'+n;
	chksend.checked=newgrouppermsend.checked;
	chksend.type="checkbox";
	
	chkmanage = document.createElement("input");
	chkmanage.name= 'newperm_manage'+n;
	chkmanage.id= 'newperm_manage'+n;
	chkmanage.checked=newgrouppermmanage.checked;
	chkmanage.type="checkbox";
	
	chkgrant = document.createElement("input");
	chkgrant.name= 'newperm_grant'+n;
	chkgrant.id= 'newperm_grant'+n;
	chkgrant.checked=newgrouppermgrant.checked;
	chkgrant.type="checkbox";

	
	
	textnode1=document.createTextNode(text_group);
	textnode2=document.createTextNode(grp.options[grp.selectedIndex].text);
	cell0.appendChild(chknode);
	cell0.appendChild(hid);
	cell1.appendChild(img);
	cell1.appendChild(textnode1);
	cell2.appendChild(textnode2);
	cell3.appendChild(chksend);
	cell4.appendChild(chkmanage);
	cell5.appendChild(chkgrant);
	row.appendChild(cell0);
	row.appendChild(cell1);
	row.appendChild(cell2);
	row.appendChild(cell3);
	row.appendChild(cell4);
	row.appendChild(cell5);
	tabBody.appendChild(row);
	nbnew.value=n;
}

function deleteRows() {  
	try {  
		dlg3.hide();
		var todel = document.getElementById('todel');
		var table = document.getElementById("detail");  
		var rowCount = table.rows.length;  
        for(var i=0; i<rowCount; i++) {  
        	var row = table.rows[i];
        	try
        	{
	            var chkbox = row.cells[0].childNodes[0];  
	            if(null != chkbox && true == chkbox.checked) {
	            	todel.value+=chkbox.value+';';
	                table.deleteRow(i);  
	                rowCount--;  
	                i--;  
	            }
        	}
        	catch(err) {}
      }  
   }catch(e) {  
     alert(e);  
   }  
}  



function deleteRowsPerm() {  
	try {  
        dlg7.hide();
        var todel = document.getElementById('todelperm');
        var table = document.getElementById("permissions");  
        var rowCount = table.rows.length;  
        for(var i=0; i<rowCount; i++) {  
			 var row = table.rows[i]; 
			 try
			 {
				 var chkbox = row.cells[0].childNodes[0];  
				 if(null != chkbox && true == chkbox.checked) {
					 todel.value+=chkbox.value+';';
					 table.deleteRow(i);  
					 rowCount--;  
	     			i--;  
	            }
			 } catch(err) {}
        }  
     }catch(e) {  
       alert(e);  
    }  
}  

function cancel()
{
	if (dlg1!=null)  dlg1.hide();
	if (dlg2!=null) dlg2.hide();
	if (dlg3!=null) dlg3.hide();
	if (dlg4!=null) dlg4.hide();
	if (dlg5!=null) dlg5.hide();
	if (dlg6!=null) dlg6.hide();
	if (dlg7!=null) dlg7.hide();
}

	