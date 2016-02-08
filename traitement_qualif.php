<?php

include('config.php');



if (isset($_POST['envoi']) &&  isset($_POST['check']) && $_POST['envoi'] == "yes") 

{

	$options = $_POST['check']; 

	foreach($options as $colonne)

	{
        $qualif_id_1 = "ID_1_GP_" . $colonne;
        $qualif_id_2 = "ID_2_GP_" . $colonne;

        $qualif_value_1 = substr($_POST["1_" . $colonne], 2);
        $qualif_value_2 = substr($_POST["2_" . $colonne], 2);

        $test1 = "ID_1_GP_A";
        //$query_trait_qualif3 = 'update PRONOS_QUALIF set ' . $$qualif_id_1 . ' = 4';
        $query_trait_qualif2 = 'INSERT INTO PRONOS_QUALIF(id_joueur, ' . $qualif_id_1 . ', ' . $qualif_id_2 . ') VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE ' . $qualif_id_1 . ' = ?, ' . $qualif_id_2 . ' = ?';

        //On rajoute les prono_qualif en base
 		$req = $bdd->prepare($query_trait_qualif2);
        
       
		$req->execute(array(
							$_SESSION['userid'],							
							$qualif_value_1,
                            $qualif_value_2,
                            $qualif_value_1,
							$qualif_value_2                        
							));

	}

	header('Location: prono_qualif.php');

}

elseif (isset($_POST['envoi']) &&  isset($_POST['check2']) && $_POST['envoi'] == "yes")
{

	$colonne = $_POST['check2']; 


	$qualif_value_1 = substr($_POST['ID_PREMIER'], 2);
	$qualif_value_2 = substr($_POST['ID_SECOND'], 2);
	$qualif_value_3 = substr($_POST['ID_TROISIEME'], 2);

	//$query_trait_qualif3 = 'update PRONOS_QUALIF set ' . $$qualif_id_1 . ' = 4';
	$query_trait_qualif2 = 'INSERT INTO PRONOS_QUALIF(id_joueur, id_premier, id_second, id_troisieme) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE id_premier = ?, id_second = ?, id_troisieme = ?';

	//On rajoute les prono_qualif en base
	$req = $bdd->prepare($query_trait_qualif2);
	
   
	$req->execute(array(
						$_SESSION['userid'],							
						$qualif_value_1,
						$qualif_value_2,
						$qualif_value_3,
						$qualif_value_1,
						$qualif_value_2,
						$qualif_value_3                       
						));



	header('Location: prono_qualif.php');

}
else 

{
	header('Location: prono_qualif.php');
}

?>