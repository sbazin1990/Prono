<?php
include('config.php');

/**
 * Fonction de calcul des tendances à partir du nombre de points des joueurs avant et après l'insertion
 * de matchs. La tendance est mise à jour dans la table USERS.
 */
function calculer_tendance($bdd, $insert_tendance, $tab_position_avant, $tab_position_apres)
{
	foreach($tab_position_avant as $cle => $element)
	{
		if (array_key_exists($cle, $tab_position_apres))
		{
			$pos_apres = $tab_position_apres[$cle];
            echo $pos_apres . ' ---  ';
			$pos_avant = $element;
            echo $pos_avant . ' ---  ';
			$tendance = $pos_avant - $pos_apres;
			// Préparation de la requête
			$req = $bdd->prepare($insert_tendance);
			// Exécution de la requête
			$req->execute(array(
				$tendance,
				$cle											
			));
		}
	}
	return true;
}

/**
 * Fonction de récupération de la position de tous les joueurs à partir de la table USERS.
 * Utile pour le calcul de la tendance.
 */
function calculer_classement($bdd, $get_users_ranking)
{
	// Préparation de la requête
	$req2 = $bdd->prepare($get_users_ranking);
	// Exécution de la requête
	$req2->execute(array());
	$i = 0;
	$tab_pos = array();
	if ($req2->rowCount() != 0)
	{
		while ($dnn2 = $req2->fetch())
		{	
			$i++;
			$tab_pos[$dnn2['id']] = $i;
		}
	}
	return $tab_pos;
}

/**
 * Fonction de calcul des points. Le calcul des points est effectué pour tous les matchs, pour tous les joueurs à chaque calcul.
 */
function calculer_points($bdd, $get_all_pronostics, $insert_prono_score, $compute_users_score)
{
	// Préparation de la requête
	$req = $bdd->prepare($get_all_pronostics);
	// Exécution de la requête
	$req->execute(array());
	
	// Si le requête retourne au moins un pronostic
	if ($req->rowCount() > 0) 
	{
		// On itère sur chaque pronostic
		while ($prono = $req->fetch()) 
		{
			$pts = 0;
			$victoire = false;
			
			$issue_prono = 0;
			$issue_reele = 0;
			if($prono['prono_equipe_1'] == $prono['prono_equipe_2']){
				$issue_prono = 2;
			}
			else if($prono['prono_equipe_1'] > $prono['prono_equipe_2']){
				$issue_prono = 1;
			}
			else{
				$issue_prono = 3;
			}
			
			if($prono['resultat_equipe_1'] == $prono['resultat_equipe_2']){
				$issue_reele = 2;
			}
			else if($prono['resultat_equipe_1'] > $prono['resultat_equipe_2']){
				$issue_reele = 1;
			}
			else{
				$issue_reele = 3;
			}
			
			$victoire = $issue_prono == $issue_reele;
			// Test de la victoire sur prono match null
			
			/*if ($prono['prono_equipe_1'] == $prono['prono_equipe_2']) {
				$victoire = $prono['resultat_equipe_1'] == $prono['resultat_equipe_2'];
			} else {
				$vainqueur_prono = ($prono['prono_equipe_1'] - $prono['prono_equipe_2']) > 0 ? true:false;
				$vainqueur_reel = ($prono['resultat_equipe_1'] - $prono['resultat_equipe_2']) > 0 ? true:false;
				$victoire = $vainqueur_prono == $vainqueur_reel;
			}*/
			
			if ($victoire) {
				// Points attribués pour la victoire (5)
				$pts += 10;
				
				// Points attribués pour l'exactitude du score (4 max 1 de moins pour chaque but de delta)
				$ecart_equipe_1 = abs($prono['prono_equipe_1']-$prono['resultat_equipe_1']);
				$ecart_equipe_2 = abs($prono['prono_equipe_2']-$prono['resultat_equipe_2']);
				
				$pts += max((4-$ecart_equipe_1-$ecart_equipe_2), 0);
				
				// Points attribués pour l'exactitude de l'écart entre les équipes (1 ou 0)
				$ecart_prono = $prono['prono_equipe_1']-$prono['prono_equipe_2'];
				$ecart_reel = $prono['resultat_equipe_1']-$prono['resultat_equipe_2'];
				
				$pts = $ecart_prono == $ecart_reel ? $pts+1:$pts;
			}
			
			// Insertion du nombre de points dans la table des pronostics
			$req2 = $bdd->prepare($insert_prono_score);
			$req2->execute(array(
						$pts,
						$prono['id_joueur'],
						$prono['id_match']
					));
		}
		
		// Les scores ont été calculés pour chaque pronostic, on lance la requête qui somme les scores de chaque joueur et les insère en table
		$req3 = $bdd->prepare($compute_users_score);
		$req3->execute(array());
        return true;
	}
    return false;
}
?>

<!--
Main HTML page
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/bootstrap.css" rel="stylesheet">   
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet"/>
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 		
        <title>Page d'administration</title>
    </head>
    <body>
        <?php include('admin_navbar.php'); ?>
		<!-- header -->
    	<div class="header">
        	<h1>Page d'administration</h1>
	    </div>
		<!-- content -->
        <div class="content" id="page">
        <?php
		// Message à afficher en fin de page
		$message = '';
		// Accessible uniquement si le user est log
		if(isset($_SESSION['username']))
		{
			// Accessible uniquement si le user est admin
			if(isset($_SESSION['admin']) && $_SESSION['admin'] == $is_admin)
			{
				// S'exécute uniquement si le user a posté le résultats des matchs
				if(isset($_POST['envoi']) && $_POST['envoi'] == 'yes')
				{
					// utilisé pour vérifier si au moins un match a été inséré
					$i_return = false;
					// loop sur chaque match entré par l'admin
					foreach($_SESSION['matchs'] as $match)
					{				
						// concaténation pour retrouver le nom des inputs envoyés en POST
						$scorea = "equipe_a_" . $match;
						$scoreb = "equipe_b_" . $match;
						
						// si les inputs sont bien retrouvés
						if(isset($_POST[$scorea]) && isset($_POST[$scoreb]))
						{	
							// si les inputs sont valides
							if((($_POST[$scorea] != NULL) && ($_POST[$scoreb] != NULL)) && 
								((is_numeric($_POST[$scorea]) || is_numeric($_POST[$scoreb])) || ($_POST[$scorea] == 0 || $_POST[$scoreb] == 0)))
							{
								try {
                                echo "  1";
									// au moins un match a été inséré
									$i_return = true;
									$req = $bdd->prepare($set_score);								
									$req->execute(array(
										$_POST[$scorea],
										$_POST[$scoreb],
										$match						
									));
								} catch (Exception $e) {
									$message = 'Erreur grave de connexion BDD !' . $e->getMessage();
								}
							}
							else
							{
								$message = 'Le format du score est invalide !';
							}
						}
					}
					// Si au moins une insertion s'est déroulée
					if ($i_return)
					{
                        echo "  2     ";
						// on définit la position avant d'entrer le (ou les) prochain match
						$tab_position_avant = calculer_classement($bdd, $get_users_ranking);
						// calcul des points pour le joueur
						$i_return = calculer_points($bdd, $get_all_pronostics, $insert_prono_score, $compute_users_score);				
                        echo " lalal";
						if ($i_return)
						{
                            echo "voubo";
							// on définit la position apres d'entrer le (ou les) prochain match
							$tab_position_apres = calculer_classement($bdd, $get_users_ranking);
							// on calcule la tendance à partir de la position avant et la position après
							$i_return = calculer_tendance($bdd, $insert_tendance, $tab_position_avant, $tab_position_apres);
						}
					}
					if (!$i_return)
					{
						$message = 'Problème lors du traitement points et position';
					}
				}
				$req = $bdd->prepare($get_played_games);
				$req->execute(array($_SESSION['userid']));
				if ($req->rowCount() != 0)
				{
				?>
					<table class="table table-striped table-bordered table-hover">  
						<thead>  
						  <tr>  
							<th class="left">Equipe A</th>  
							<th class="left">Score Equipe A</th> 
							<th class="text-right">Score Equipe B</th> 
							<th class="text-right">Equipe B</th> 			
						  </tr>  
						</thead> 
						
						<tbody> 
						<form action="admin.php" method="post">
						<input type="hidden" name="envoi" value="yes">
						<?php
						$i = 0;
						while ($dnn = $req->fetch())
						{
							$matchs[$i] = $dnn['id'];
						?>
							<tr>
								<td>
								<label for="equipe_a"><?php echo $dnn['nom_equipe_1']; ?></label>
								</td>
								<td>
								<input type="number" min=0 name="equipe_a_<?php echo $dnn['id']  ?>" style="width:40px;height:20px;"/><br />
								</td>
								<td class="text-right">
								<input type="number" min=0 name="equipe_b_<?php echo $dnn['id']; ?>"  class="text-right" style="width:40px;height:20px;"/><br />
								</td>	
								<td class="text-right">
								<label class="text-right" for="equipe_b"><?php echo $dnn['nom_equipe_2']; ?></label>
								</td>
							</tr>									
						<?php
							$i++;
						}
						$_SESSION['matchs']=$matchs;					
						$req->closeCursor(); // Termine le traitement de la requête					
						?>							
						</tbody>  
						<tfoot> 
						<tr>                                   
							<td class="text-center"><input type="submit" value="Sauvegarder" class="text-center" /></td>                                         
							</form>
						</tr>                    
						</tfoot>
					</table>
				<?php
				}
				else
				{
					$message = 'Aucun match à valider !';
				}
			}
			else 
			{
				$message = 'Page réservée aux administrateurs';
			}
		}
		else
		{
			$message2 = 'Connectez vous pour acceder à cette page';
		}
		if(isset($message))
		{
			echo '<div class="message">'.$message.'</div>';
		}
		if(isset($message2))
		{
			echo '<div class="message"><a href="connexion.php">'.$message2.'</a></div>';
		}
		?>
		</div>
		<!-- footer -->
	</body>
</html>