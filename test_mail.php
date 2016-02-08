<?php
//Parametres : 
// - $mdp : Mot de passe du joueur, g�n�r� al�atoirement
// - $adresse_joueur : Adresse mail � laquelle on fait l'envoi du mail
function envoyer_mail_mdp($mdp, $adresse_joueur){
	$mail = $adresse_joueur; // D�claration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn|capgemini).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====D�claration des messages au format texte et au format HTML.
	$message_html = "<html><head></head><body><b>Merci de vous �tre inscrit sur prono-cdm-2014</b><br />Votre login est : <i>".$adresse_joueur."</i><br />Votre mot de passe est : <i>".$mdp."</i></body></html>";
	//==========
	 
	//=====Cr�ation de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====D�finition du sujet.
	$sujet = "Confirmation d'inscription a prono-cdm-2014";
	//=========
	 
	//=====Cr�ation du header de l'e-mail.
	$header = "From: \"Pronostics CDM 2014 \"<webmaster@php-multi-quantal-95.online.net>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========
	 
	//=====Cr�ation du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//==========
	 
	//=====Envoi de l'e-mail.
	mail($mail,$sujet,$message,$header);
	//==========

}

function renvoyer_mail_mdp($mdp, $adresse_joueur){
	$mail = $adresse_joueur; // D�claration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====D�claration des messages au format texte et au format HTML.
	$message_html = "<html><head></head><body><b>Voici vos identifiants</b><br />Votre login est : <i>".$adresse_joueur."</i><br />Votre mot de passe est : <i>".$mdp."</i></body></html>";
	//==========
	 
	//=====Cr�ation de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	 
	//=====D�finition du sujet.
	$sujet = "Confirmation d'inscription a prono cdm 2014";
	//=========
	 
	//=====Cr�ation du header de l'e-mail.
	$header = "From: \"Pronostics CDM 2014 \"".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	
	

	//==========
	 
	//=====Cr�ation du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//==========
	 
	//=====Envoi de l'e-mail.
	mail($mail,$sujet,$message,$header);
	//==========

}
?>