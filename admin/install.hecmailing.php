<?php

defined('_JEXEC') or die('Restricted access');

/**
* @version 1.7.1
* @package hecMailing for Joomla
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


function com_install()
{
	$Component_Version="1.7.1 beta";
    // First make sure that this version of Joomla is 1.5 or greater
    $version = new JVersion();
    if ( (real)$version->RELEASE < 1.5 ) {
        echo "<h1 style=\"color: red;\">The 'hecMailing' package will only work on Joomla version 1.5 or later!</h1>";
        return false;
    }

    require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_hecmailing'.DS.'update.php');
    HecMailingUpdate::update_hecmailing_table();

    echo '<div class="header">Le composant HEC Mailing '.$Component_Version.' a &eacute;t&eacute; install&eacute; avec succ&egrave;s! </div>';
    echo '<div class="header">HEC Mailing '.$Component_Version.' component succesfully installed! </div>';
  	echo '<div class="header">HEC Mailing '.$Component_Version.'  ist erfolgreich installiert worden</div>';
	  echo '<div class="header">HEC Mailing '.$Component_Version.'  werd met successen geplaatst</div><br>';
	  echo '<hr>';
   
    ?>

    </div>

    <h2>DESCRIPTION:</h2>
    <p>
      Ce composant pour joomla 1.5+ (compatible 1.6, 1.7) permet l'envoi de mail a une liste de diffusion par des utilisateurs autoris&eacute;s &acute; partir du frontend.<br>
      Vous pouvez cr&eacute;er plusieurs groupes. Chaque groupe peut contenir des utilisateur joomla, des groupes joomla ou des adresses e-mail<br>
      Ce composant utilise l'&eacute;diteur par d&eacute;faut et peut envoyer des images (images stock&eacute;es sur votre site ou attach&eacute;es).<br>
      Il est aussi capable d'envoyer des pi&egrave;ces jointes (&agrave; partir de votre disque ou du site)&lt;br&gt;
      Un syst&egrave;me de template est disponible (sauvegarde d'un mail).
    </p>
    <hr>
    <p>
    	This joomla 1.5+ (1.6 and 1.7 compliant) extension allow authorized user to send html mail to distribution lists (groups) from the frontend.<br>
			You can create many groups from backend. A group can contain joomla user, joomla group or other e-mail address.<br>
			This component use default editor and is able to send images (remote image with link or attached!) and have a template system.
			It can also send attachment (from your local disk or from website)<br>
    </p>
    
    <br>
    <h2>PARAMETRAGE:</h2>
    <p>Si vous utilisez le module de contact, apr&egrave;s l'installation, vous devez vous rendre sur le site de reCaptcha (<a href="http://recaptcha.net/whyrecaptcha.html" >http://recaptcha.net/whyrecaptcha.html</a>) afin d'obtenir un jeu de cl&eacute; (priv&eacute; et public) que vous saisirez dans l'&eacute;cran des param&egrave;tres.<br>
    	<ul><li>Cr&eacute;er un compte</li>
    		<li>A partir de votre compte, ajouter votre site puis 'Create Key'</li>
    		<li>Ouvrir l'interface d'administration puis ouvrir le composant hecMailing</li>
    		<li>Cliquer sur Param&egrave;tres</li>
    		<li>Copier/Coller la cl&eacute; priv&eacute;e dans le champ 'ReCaptcha private Key'</li>
    		<li>Copier/Coller la cl&eacute; public dans le champ 'ReCaptcha public Key'</li>
    		<li>Sauver. Votre module Contact est pr&ecirc;t &agrave; fonctionner</li>
    	</ul>
    </p>
    		<p><i>If you use Contact module, after install, you need to go to reCaptcha website (<a href="http://recaptcha.net/whyrecaptcha.html" >http://recaptcha.net/whyrecaptcha.html</a>) to get keys (private and public). Theses keys will be put in hecMailing parameter screen.<br>
    			How to :<br>
    	<ul><li>Create an account on reCaptcha website</li>
    		<li>Click on 'MY ACCOUNT', 'Add a New Site'and 'Create Key'</li>
    		<li>Open admin backend of your website and choose hecMailing from component menu</li>
    		<li>Click on Parameters</li>
    		<li>Copy/Paste the  private key in 'ReCaptcha private Key' field</li>
    		<li>Copy/Paste the  public key in 'ReCaptcha private Key' field</li>
    		<li>Save. Your Contact module is ready</li>
    	</ul>
    	</i><p>
    <h2>Change Log</h2>
    <p>
	 1.7.1  Correct Group Management problems<br>
                        Add template for contact<br>
						Correct Admin menu problem<br>
	1.7.0   Version compatible avec joomla 1.6/1.7 et +<br>
	0.13.5 Remplace &lt;?= par &lt;?php echo pour afficher les variables en html afin d'&ecirc;tre compatible lorsque l'option short_open_tag est d&eacute;sactiv&eacute;e<br>
	0.13.4  Ajout possibilit&eacute; d'afficher plusieurs lignes pour ajouter des fichier en pi&egrave;ce jointe<br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modification m&eacute;thode ajout pi&egrave;ce joint pour IE8<br>         
    0.13.3  Ajout compatibilit&eacute; PHP 5.0.x<br>
    0.13.2 Correction problème regression admin<br>
	  0.13.1 Traduction ressources en Allemand de la version 0.13.0 par Ingo<br>
		0.13.0 Import liste email dans un groupe a partir d'un fichier (regression dans la version 0.12.0)<br>
		0.12.0 Bug : Correction probl&egrave;me envoi &agrave; tous les utilisateur lorsque groupe s&eacute;lectionn&eacute;<br>
		0.11.0		Compatible joomfish <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Suppression des quelques Warnings (wamp/easy php) <br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N'utilise plus global $mainframe afin d'&ecirc;tre compatible avec joomla 1.6 <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mise &agrave; jour automatique du composant <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ajout bouton Don  <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Afficher les param&egrave;tres directement dans le form au lieu de cliquer sur le bouton  <br>
    	0.10.0 Permissions sur les groupes pour limiter l'envoi aux groupes autoris&eacute;s<br>
    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Import liste email dans un groupe a partir d'un fichier<br>
    	0.9.1  D&eacute;placement fichier install.hecmailing.php du sous r&eacute;pertoire admin vers la racin (probl&agrave;me d'installation sur certains sites)<br>
    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ajout traduction en Allemand pour l'administration (traduction avec yahoo  :( )<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demande de contact : Envoi &agrave; tous les destinataire &agrave; la fois (plut&ocirc;t que un par un auparavant)<br>

    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modifications effectu&eacute;es par Arjan Mels :<br>
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ajout traduction n&eacute;erlandais<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Correction des liens et des chemins (dans controller.php & views default.php) pour permettre l'utilisation de joomla dans des sous-r&eacute;pertoires<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Petites correction du fichier d'installation (afin d'inclure certaines images manquantes)<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Int&eacute;gration de getdir dans hecmailing.php afin de pouvoir utiliser les fonctionalit&eacute;s de s&eacute;curit&eacute; de Joomla.<br>
    	0.9.0 : Request #3016614 : Suppression des e-mail envoy&eacute;s<br>
    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #3013589 : Message "Delete Failed" lors envoi mail avec PJ (locale) sans sauvegarde dans log<br/>
    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2970606 Contact : Probl&egrave;me ajout ou edition contact<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2975181 General : Ajout traductions manquantes<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975177 General : Utilisation de la librairie jt dialog box &agrave; la place des messagebox propri&eacute;taires<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975179 Contact : remplacement de l'ancien captcha par ReCaptcha<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975183 Contact : Pour les utilisateurs connect&eacute;s, le nom et l'e-mail sont pr&eacute;-remplis<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2975175 Contact : Probleme corps du message vide<br>
    0.8.2 : Bug #2913937 Probleme ajout groupe<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Traduction Anglaise de boutons (Ajout utilisateur, Ajout  email, Ajout  Groupe  et Supprimer)<br>
    0.8.1 :Bug #18750	Bad URL for link<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #19566	LogDetail : mail sent ok list is too large <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #19567	E-mail sent : Embedded image is not shown in email sent detail <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #19568	E-mail sent detail : error when no attachment <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #19569	send again email : error when no attachment<br />
		
    0.8.0 : Ajout fonctionnalite images incorpor&eacute;es<br>
    0.7.0 : Ajout fonctionnalite piece jointe lors envoi de messages<br>
 	  0.6.0 : Ajout fonctionnalite contact<br>
    0.5.0 : Correction probleme adresse/nom envoye par.<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sauvegarde des emails envoyes.<br>
 		0.4.0 (nov 2009) : Correction structure table hecmailing_groupdetail (champ gdet_id_detail doit etre en auto increment pour pouvoir supprimer des entrees)<br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ajout langue Allemand (Merci &acute; Ingo pour sa traduction) pour le front-end<br>
 		0.3.0 (oct 2009) :  Prise en compte groupe "Tous utilisateurs" et affichage nombre mails envoy&eacute;s<br>
 		0.2.0 (juil 2009) : Correction probleme affichage image lors utilisation template<br>
 		0.1.0 (avril 2009) : Version Alpha1<br>

    </p>

	<p><i>
	1.7.0 Joomla 1.6/1.7 compliant<br>
	0.13.5 Replace &lt;?= with &lt;?php echo to display a variable in html to be compliant when short_open_tag is not activated (php.ini)<br>
	0.13.4 Choose default upload input count<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Add attachment method to be IE8 compliant<br>
	  0.13.3 Add PHP 5.0.x compliance<br>
	0.13.2 Regression fixed<br>
	0.13.1 German translations by Ingo<br>
	    0.13.0 Import email list from file to group (which was accidentaly removed in 0.12.0)<br>
		0.12.0 Bug : Contact send to all users and not selected group<br>
		0.11.0		joomfish compliant<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Some Notice deleted (wamp/easy php) <br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Don't use global $mainframe to be compliant with joomla 1.6 <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Auto update of the component <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add Donation button  <br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Show parametrers in form (and not with button)   <br>
	  0.10.0 : Send group permission to allow to send only to allowed groups<br/>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Import email list from file to group<br>
	  0.9.1 : Move file install.hecmailing.php from admin subdirectory to root (install problem on some websites)<br>
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Added Backend Deutch translation (yahoo translator :( )<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Added Send contact to all email at the same time (before, one message per mail address)<br>

	  		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modifications by Arjan Mels :<br/>
		      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Added Dutch translation<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Corrected many links/paths (in controller.php & form views default.php) to allow joomla installation in subdirectory<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Small corrections to installtion xml file (to include some missing images)<br/>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;getdir integrated into hecmailing.php to be able to use Joomla security features<br/>
    	
		0.9.0 : Request #3016614 : Suppress sent email<br/>
    			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #3013589 : Fixe "Delete Failed" message when send e-mail with attachment (from local) and no save in log<br/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2970606 Contact : Can't add or edit contact<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2975181 General : Add some missing translations<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975177 General : Use jt dialog box instead of self made<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975179 Contact : Change captcha --> Use ReCaptcha<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975183 Contact : If user is logged, fill name and email fields<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2975175 Contact : No body for contact email<br>
		0.8.2 : Bug #2913937 Problem with group<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Translate buttons (Add user, Add email, Add Group and Delete) in English <br>
		0.8.1 : Bug #18750	Bad URL for link / URL lien erron&eacute;e
														Bug #19566	LogDetail : mail sent ok list is too large / Liste des destinataire ok et erreur trop large<br/>
														Bug #19567	E-mail sent : Embedded image is not shown in email sent detail / Les images incorpor&eacute;es ne sont pas visibles dans le d&eacute;tail des eamil envoy&eacute;s<br/>
														Bug #19568	E-mail sent detail : error when no attachment / Erreur lorsqu'il n'y a aucun fichier joint<br/>
														Bug #19569	send again email : error when no attachment/ Erreur lorsqu'il n'y a aucun fichier joint<br/>
		
		0.8.0 : Allow send image in body (not from external link)<br/>
    0.7.0 : Allow add attachment when send an email<br>
 	  0.6.0 : Contact form<br>
    0.5.0 : Correct bug send From<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Save sended email<br/>
 		0.4.0 (nov 2009) : Change hecmailing_groupdetail table (field gdet_id_detail must be auto increment in order to delete entries)<br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add deutch language for front end (Thanks to Ingo)<br>
 		0.3.0 (oct 2009) :  Use "All User" flag<br>
 		0.2.0 (juil 2009) : Correct image problem in template load<br>
 		0.1.0 (avril 2009) : First Version<br>

    </i></p>



    <p>
    		Vous pouvez utiliser le gestionnaire de bug disponible <a href="http://sourceforge.net/tracker/?group_id=281865&atid=1195720">ici</a> pour decrire vos problemes et envoyer vos suggestions.<br>
				
        Please report bugs and suggestions with <a href="http://sourceforge.net/tracker/?group_id=281865&atid=1195720">HEC Mailing tracker</a>.

    </p>

    <h2>Contributors :</h2>
    &nbsp;<i>Herv&eacute; CYR</i>: Project leader and main developper<br>
    &nbsp;<i>Arjan Mels</i>: Project contributor (version 0.9.1, many bug/feature correction and dutch translation)<br>  
    &nbsp;<i>Ingo</i>: Project contributor (deutch translation)<br>
    <?php



    return true;

}

?>