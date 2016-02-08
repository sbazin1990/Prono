<?php
include('config.php');

if (isset($_POST['envoi']) &&  isset($_POST['check']) && $_POST['envoi'] == "yes") 
{
	$options = $_POST['check']; 
	foreach($options as $match)
	{        $tab_date = $_SESSION['datelim2'];        
		if ($tab_date[$match] > date('Y-m-d H:i:s'))        
		{
			$req = $bdd->prepare($query_supp_prono);

			$req->execute(array(
			'id_player' => $_SESSION['userid'],
			'id_match' => $match
			));     
			header('Location: affichage_prono.php');
		}        
		else         
		{            
			$message = 'Date limite atteinte - Le pronostic est définitif';           
			echo '<div class="message">'.$message.'</div>';        
		}
	}
	
}
elseif (isset($_POST['envoi']) &&  isset($_POST['check2']) && $_POST['envoi'] == "yes") 
{
	$options = $_POST['check2']; 
	foreach($options as $group)
	{               
		if (date('2014-06-13 18:00:00') > date('Y-m-d H:i:s'))      
		{			
			$qualif_id_1 = "ID_1_GP_" . $group;
			$qualif_id_2 = "ID_2_GP_" . $group;
			$query_supp_qualif = 'UPDATE PRONOS_QUALIF SET ' . $qualif_id_1 . ' = 0, ' . $qualif_id_2 . ' = 0 WHERE ID_JOUEUR = ?';

			$req = $bdd->prepare($query_supp_qualif);
			$req->execute(array($_SESSION['userid'])); 
			header('Location: affichage_prono.php');	
		}       
		else        
		{            
			$message = 'Date limite atteinte - Le pronostic est définitif';            
			echo '<div class="message">'.$message.'</div>';        
		}
	}
}	
else
	if (isset($_POST['envoi']) &&  isset($_POST['check3']) && $_POST['envoi'] == "yes") 
	{
		if($_POST['check3'] == "OK")
		{               
			if (date('2014-06-13 18:00:00') > date('Y-m-d H:i:s'))      
			{			
				$query_supp_qualif2 = 'UPDATE PRONOS_QUALIF SET ID_PREMIER = 0, ID_SECOND = 0, ID_TROISIEME = 0 WHERE ID_JOUEUR = ?';

				$req = $bdd->prepare($query_supp_qualif2);
				$req->execute(array($_SESSION['userid'])); 
				header('Location: affichage_prono.php');	
			}       
			else        
			{            
				$message = 'Date limite atteinte - Le pronostic est définitif';            
				echo '<div class="message">'.$message.'</div>';        
			}
		}
	
	}
    else
    {
        header('Location: affichage_prono.php');
    }
?>