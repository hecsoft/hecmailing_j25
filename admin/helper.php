<?php
/**
 * @version 1.8.2
 * @package hecmailing
 * @copyright 2009-2013 Hecsoft.net
 * @license http://www.gnu.org/licenses/gpl-3.0.html
 * @link http://joomla.hecsoft.net
 * @author H Cyr
 **/
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

function getComponentVersion()
{
	jimport('joomla.application.helper');
	$file = JApplicationHelper::parseXMLInstallFile(JPATH_COMPONENT_ADMINISTRATOR . DS . 'hecmailing.xml');
	if($file) {
		return $file['version'];
	}
	else
	{
		static $warned = false;
		if(!$warned)
		{
			$app =& JFactory::getApplication();
			$app->enqueueMessage('Fallback component version used!');
			$warned = true;
		}
		return '1.5.1'; // fallback call
	}
}

function getRemoteFile($url)
{
   // get the host name and url path
   $parsedUrl = parse_url($url);
   $host = $parsedUrl['host'];
   if (isset($parsedUrl['path'])) {
      $path = $parsedUrl['path'];
   } else {
      // the url is pointing to the host like http://www.mysite.com
      $path = '/';
   }

   if (isset($parsedUrl['query'])) {
      $path .= '?' . $parsedUrl['query'];
   } 

   if (isset($parsedUrl['port'])) {
      $port = $parsedUrl['port'];
   } else {
      // most sites use port 80
      $port = '80';
   }

   $timeout = 10;
   $response = ''; 
   // connect to the remote server 
   $fp = @fsockopen($host, '80', $errno, $errstr, $timeout ); 

   if( !$fp ) { 
      echo "Cannot retrieve $url";
   } else {
      // send the necessary headers to get the file 
      fputs($fp, "GET $path HTTP/1.0\r\n" .
                 "Host: $host\r\n" .
                 "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
                 "Accept: */*\r\n" .
                 "Accept-Language: en-us,en;q=0.5\r\n" .
                 "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
                 "Keep-Alive: 300\r\n" .
                 "Connection: keep-alive\r\n" .
                 "Referer: http://$host\r\n\r\n");

      // retrieve the response from the remote server 
      while ( $line = fread( $fp, 4096 ) ) { 
         $response .= $line;
      } 

      fclose( $fp );

      // strip the headers
      $pos      = strpos($response, "\r\n\r\n");
      $response = substr($response, $pos + 4);
   }

   // return the file content 
   return $response;
}



function getLatestComponentVersion($url)
{

    
   $content=getRemoteFile($url);

	  // $content=file($url);
  
  if ($content)
  {
      
      jimport('joomla.utilities.simplexml');
      $doc = new JSimpleXML();
      $ver = '';
      if( $doc->loadString($content))
      {
      
          foreach( $doc->document->children() as $child ) {
                if ($child->name()=='version')
                {
                      $ver = $child->data();
                      break;
                }
          }

		      if ($ver=='')
		      {
		        $app =& JFactory::getApplication();
			     $app->enqueueMessage("No version found");
			     return "";
          }
          else
		        return $ver;
		  }
		  else
		  {
          $app =& JFactory::getApplication();
			    $app->enqueueMessage("Can't load xml content");
			    return "";
      }
		      
		  
	}
	else
	{
	     $app =& JFactory::getApplication();
			 $app->enqueueMessage("Can't get xml content from ".$url);
			 return "";
      
  }
	
	return ''; // fallback call
	
}

function download($src,$dest)
{
    $content = file($src);
    $fd = fopen($dest,"w");
    foreach ($content as $line)
    {
      fwrite($fd,$line);
      }
    fclose($fd);
}

?>