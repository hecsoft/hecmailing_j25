<?php

defined('_JEXEC') or die('Restricted access');

/**
* @version 0.9.0
* @package hecMailing for Joomla
* @copyright Copyright (C) 2008 Hecsoft All rights reserved.
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

    // First make sure that this version of Joomla is 1.5 or greater

    $version = new JVersion();

    if ( (real)$version->RELEASE < 1.5 ) {

        echo "<h1 style=\"color: red;\">The 'hecMailing' package will only work on Joomla version 1.5 or later!</h1>";

        return false;

        }



   

    require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_hecmailing'.DS.'update.php');

    HecMailingUpdate::update_hecmailing_table();



   
    echo '<div class="header">HEC Mailing component succesfully installed! <br>';



   
    ?>

    </div>

    <h2>DESCRIPTION:</h2>
    <p>
      Ce composant pour joomla 1.5 permet l'envoi de mail a une liste de diffusion par des utilisateurs autoris&eacute;s &acute; partir du frontend.<br>
      Vous pouvez cr&eacute;er plusieurs groupes. Chaque groupe peut contenir des utilisateur joomla, des groupes joomla ou des adresses e-mail<br>
      Ce composant utilise l'&eacute;diteur par d&eacute;faut et peut envoyer des images (images stock&eacute;es sur votre site ou attach&eacute;es).<br>
      Il est aussi capable d'envoyer des pi&egrave;ces jointes (&agrave; partir de votre disque ou du site)&lt;br&gt;
      Un syst&egrave;me de template est disponible (sauvegarde d'un mail).
    </p>
    <hr>
    <p>
    	This joomla 1.5 extension allow authorized user to send html mail to distribution lists (groups) from the frontend.<br>
			You can create many groups from backend. A group can contain joomla user, joomla group or other e-mail address.<br>
			This component use default editor and is able to send images (remote image with link or attached!) and have a template system.
			It can also send attachment (from your local disk or from website)<br>
    </p>
    <br>
    <h2>PARAMETRAGE:</h2>
    <p>Si vous utilisez le module de contact, après l'installation, vous devez vous rendre sur le site de reCaptcha (<a href="http://recaptcha.net/whyrecaptcha.html" >http://recaptcha.net/whyrecaptcha.html</a>) afin d'obtenir un jeu de cl&eacute; (priv&eacute; et public) que vous saisirez dans l'écran des paramètres.<br>
    	<ul><li>Cr&eacute;er un compte</li>
    		<li>A partir de votre compte, ajouter votre site puis 'Create Key'</li>
    		<li>Ouvrir l'interface d'administration puis ouvrir le composant hecMailing</li>
    		<li>Cliquer sur Param&egrave;tres</li>
    		<li>Copier/Coller la cl&eacute; priv&eacute;e dans le champ 'ReCaptcha private Key'</li>
    		<li>Copier/Coller la cl&eacute; public dans le champ 'ReCaptcha public Key'</li>
    		<li>Sauver. Votre module Contact est prêt à fonctionner</li>
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
    	0.9.0 : Bug #3013589 : Message "Delete Failed" lors envoi mail avec PJ (locale) sans sauvegarde dans log
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
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sauvegarde des emails envoyes.
 		0.4.0 (nov 2009) : Correction structure table hecmailing_groupdetail (champ gdet_id_detail doit etre en auto increment pour pouvoir supprimer des entrees)<br>>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ajout langue Allemand (Merci &acute; Ingo pour sa traduction) pour le front-end<br>
 		0.3.0 (oct 2009) :  Prise en compte groupe "Tous utilisateurs" et affichage nombre mails envoy&eacute;s<br>
 		0.2.0 (juil 2009) : Correction probleme affichage image lors utilisation template<br>
 		0.1.0 (avril 2009) : Version Alpha1<br>

    </p>

	<p><i>
		0.9.0 : Bug #3013589 : Fixe "Delete Failed" message when send e-mail with attachment (from local) and no save in log
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2970606 Contact : Can't add or edit contact<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2975181 General : Add some missing translations<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975177 General : Use jt dialog box instead of self made<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975179 Contact : Change captcha --> Use ReCaptcha<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Request #2975183 Contact : If user is logged, fill name and email fields<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bug #2975175 Contact : No body for contact email<br>
		0.8.2 : Bug #2913937 Problem with group<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Translate buttons (Add user, Add email, Add Group and Delete) in English <br>
		0.8.1 : Bug #18750	Bad URL for link / URL lien erron&eacute;e
														Bug #19566	LogDetail : mail sent ok list is too large / Liste des destinataire ok et erreur trop large
														Bug #19567	E-mail sent : Embedded image is not shown in email sent detail / Les images incorpor&eacute;es ne sont pas visibles dans le d&eacute;tail des eamil envoy&eacute;s
														Bug #19568	E-mail sent detail : error when no attachment / Erreur lorsqu'il n'y a aucun fichier joint
														Bug #19569	send again email : error when no attachment/ Erreur lorsqu'il n'y a aucun fichier joint
		
		0.8.0 : Allow send image in body (not from external link)
    0.7.0 : Allow add attachment when send an email<br>
 	  0.6.0 : Contact form<br>
    0.5.0 : Correct bug send From<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Save sended email
 		0.4.0 (nov 2009) : Change hecmailing_groupdetail table (field gdet_id_detail must be auto increment in order to delete entries)<br>>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add deutch language for front end (Thanks to Ingo)<br>
 		0.3.0 (oct 2009) :  Use "All User" flag<br>
 		0.2.0 (juil 2009) : Correct image problem in template load<br>
 		0.1.0 (avril 2009) : First Version<br>

    </i></p>



    <p>
    		Vous pouvez utiliser le gestionnaire de bug disponible <a href="http://sourceforge.net/tracker/?group_id=281865&atid=1195720">ici</a> pour decrire vos problemes et envoyer vos suggestions.<br>
				
        Please report bugs and suggestions with <a href="http://sourceforge.net/tracker/?group_id=281865&atid=1195720">HEC Mailing tracker</a>.

    </p>

    <?php



    return true;

}

?>