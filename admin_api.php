<?php
	/*Fonction utilisées par toutes les pages admins
	Liste des fonctions :
		creer_nouveau_match
		creer_nouvelle_equipe
		upload_image
		generer_nom_fichier
		log2
		error2
		error_sql	
	*/

	//
	// Creation d'un nouveau match
	//
	function creer_nouveau_match($nom_equipe_domicile, $nom_equipe_exterieur, $date_match, $heure_match)
	{
		global $bdd;
		global $creer_nouveau_match;
		$fulldate = $date_match." ".$heure_match;
		$req = $bdd->prepare($creer_nouveau_match);
		if (!$req->execute(array('date_match' => $fulldate,'nom_equipe_domicile' => $nom_equipe_domicile, 'nom_equipe_exterieur' => $nom_equipe_exterieur)))
		{
			error_sql($req);
			return 1;
		}
		else{
			log2("Match ajouté : ".$nom_equipe_domicile." vs ".$nom_equipe_exterieur." le ".$fulldate);
		}		
	}
	
	function creer_nouvelle_equipe($nom_equipe, $image_equipe)
	{
		global $bdd;
		global $creer_nouvelle_equipe;
		$req = $bdd->prepare($creer_nouvelle_equipe);
		if (!$req->execute(array('nom_equipe' => $_POST['nom_equipe'], 'image_equipe' => $image_equipe)))
		{
			error_sql($req);
		}
		else{
			log2("Equipe ajouté : ".$nom_equipe);
		}			
	}
	
	function upload_image($url_image)
	{
		try{
			$nom_fichier = generer_nom_fichier();
			$extension = get_extension_fichier($url_image);
			$file = file_get_contents($url_image);
			$nom_image = 'image/'.$nom_fichier.'.'.$extension;
			file_put_contents($nom_image,$file);
			return $nom_image;	
		}
		catch (Exception $e){
			error2($e->getMessage());
			return 1;
		}	
	}
	
	function generer_nom_fichier() 
	{
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$nom_fichier = '';
		for ($i=0; $i<10; $i++) {
			$j = rand(0,35);
			$nom_fichier .= $characters[$j];
		}
		return $nom_fichier;
	}
	
	function get_extension_fichier($url_image)
	{
		$extension = substr($url_image,strlen($url_image)-3,3);
		return $extension;
	}

	function log2($message)
	{
		$date_courante = date('Y-m-d H:i:s');
		$message_a_envoyer = $date_courante."   ".$message."\n";
		$monfichier = fopen('log.txt', 'a+');
		fputs($monfichier, $message_a_envoyer);
		fclose($monfichier);
	}
	
	function error2($message)
	{
		$date_courante = date('Y-m-d H:i:s');
		$message_a_envoyer = $date_courante."    ERROR   ".$message."\n";
		$monfichier = fopen('log.txt', 'a+');
		fputs($monfichier, $message_a_envoyer);
		fclose($monfichier);
	}
	
	function error_sql($req)
	{
		$message = "(" . $req->errorCode(). ") " . $req->errorInfo()[2];
		$date_courante = date('Y-m-d H:i:s');
		$message_a_envoyer = $date_courante."    ERROR SQL   ".$message."\n";
		$monfichier = fopen('log.txt', 'a+');
		fputs($monfichier, $message_a_envoyer);
		fclose($monfichier);
	}
	
	/**
    *Chargement du XML avec les cotes des matchs. URL du XML définit dans le fichier de config
    **/
    function charger_xml($url_xml)
    {
        $dom = new DomDocument;
        $dom->validateOnParse = true;
        $dom->load($url_xml);
        return $dom;
    }

    /**
    *Retourne un tableau de structure avec les cotes de tous les matchs de la compet en input
    **/
    function retourner_cotes_compet_from_xml($dom, $compet)
    {
        $tab_cotes_compet = array();
        $compet_find = false;
        $match_res_found = false;
        $listeEvent = $dom->getElementsByTagName('event');
        foreach($listeEvent as $event){
            if ($event->hasAttribute("name")) {
                if ($event->getAttribute("name") == $compet){
                    $compet_find = true;
                    $event->getAttribute("name");
                    foreach($event->childNodes as $node){ //boucle sur les matchs
                        $id_match_xml =  $node->getAttribute("name"); 
                        $node3 = $node ->firstChild; // balise bets
                        foreach($node3->childNodes as $node4){ //boucle sur les différents type de paris
                            if ($node4->hasAttribute("name")){
                                if ($node4->getAttribute("name") == "Match Result"){
                                    $match_res_found = true;
                                    $str_cotes = new Struct_cotes();
                                    foreach($node4->childNodes as $node5){
                                        if ($node5->hasAttribute("odd")){
                                            if ($node5->hasAttribute("name")){
                                                if ($node5->getAttribute("name") == "%1%"){
                                                    $str_cotes->cote_equipe_a = $node5->getAttribute("odd");
                                                }
                                                if ($node5->getAttribute("name") == "Draw"){
                                                    $str_cotes->cote_match_nul = $node5->getAttribute("odd");
                                                }
                                                if ($node5->getAttribute("name") == "%2%"){
                                                    $str_cotes->cote_equipe_b = $node5->getAttribute("odd");
                                                }
                                            }
                                        }
                                    }
                                    $tab_cotes_compet[$id_match_xml] = $str_cotes;
                                }    
                            }
                            if ($match_res_found == true)
                            {
                                $match_res_found = false;
                                break;
                            }
                        }
                    }
                }
            }
            if ($compet_find == true)
            {
                break;
            }
        }
        return $tab_cotes_compet;
    }
?>