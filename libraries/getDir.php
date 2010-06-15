<?php
	/* On vérifie si le script appelant ce service web est bien sur le même serveur */
	$ref = $_SERVER['HTTP_REFERER'];
	$uri = $_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	$ref_tab = split('/', $ref);
	$ser_tab = split('/', $uri);
	$uri_serveur='';
	$j=2;
	$ok=true;
	for ($i=0;$i<count($ser_tab)-4;$i++)
	{
		if ($ref_tab[$j]!=$ser_tab[$i])
		{
			$ok=false;
			break;
		}
		$j++;
	}
	
	
	if ($ok)
	{
		$dir = $_POST["dir"];
		$root = $_POST["root"];
		if ($dir != '')
		{
			echo $dir.'|';
			$dir = $root . $dir;
		}
		else
		{
			echo '|';
			$dir=$root;
		}
		
		//$dir='/home/hecsoft/www/hecsoft/'.$dir;
		echo '@..|';
		
		// Open a known directory, and proceed to read its contents
		if (is_dir($dir)) 
		{
	    if ($dh = opendir($dir)) {
	        while (($file = readdir($dh)) !== false) {
	        	if (is_dir($dir .'/'. $file))
	        	{
	        		if ($file !='.' && $file!='..')
	            	echo '@'.$file. "|";
	          }
	          
	        }
	        closedir($dh);
	    }
	    if ($dh = opendir($dir)) {
	        while (($file = readdir($dh)) !== false) {
	        	if (!is_dir($dir .'/'. $file))
	        	{
	        		if ($file !='.' && $file!='..')
	            	echo $file. "|";
	          }
	          
	        }
	        closedir($dh);
	    }
		}
	}
	else
	{
		echo "|NOT ALLOWED|";
		
	}
	
  
?>