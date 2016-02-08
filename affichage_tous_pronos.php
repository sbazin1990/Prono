<?php
include('config.php');

function get_qualif($dnn, $i)
{
	$tab_out = array();
	$tab_group = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
	foreach ($tab_group as $group)
	{
		if ( $dnn['ID_' . $i . '_GP_' . $group] != 0 )
		{
			$tab_out[$group] = $dnn['ID_' . $i . '_GP_' . $group];		
		}
	}
	return $tab_out;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Intégration du CSS Bootstrap -->
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Pronostics de tous les joueurs</title>
    </head>
    <body>
        <?php
        include('navbar.php');    
        ?>
    	<div class="header">
        	<h4> Pronostics des matchs pass&eacute;s </h4>
	    </div>
        <div class="content" id="page">
        <?php
		if(isset($_SESSION['username']))
		{
		$req = $bdd->prepare($query_affich_matchs_joues);
		$req->execute(array());
		?>
		<!-- On affiche une combobox avec la liste des matchs deja passes -->
		<div align="center"> 
		<form class ="form-qualif" method="post" action="affichage_tous_pronos.php">
			<select name="choix">
				<option value=""></option>
			<?php 
				while ($dnn = $req->fetch())
				{
					echo '<option value="'.$dnn['id'].'">'.$dnn['equipe_1'].' - '.$dnn['equipe_2'].'</option>';
				}
			?>	
			</select>
			<br /><input class="btn btn-default" name="send" type="submit" value="Valider le choix">
		</form>
		</div>
		
		<?php 
			if(isset($_POST['send'])){
			// Premiere requete sql, pour recuperer le match et les flags (un peu sale) du match
			$reqq = $bdd->prepare($query_affich_info_match);
			$reqq->execute(array($_POST['choix']));
			$dnnn = $reqq->fetch()

				?>
			
			<table class="table table-striped table-bordered table-hover table-all-pronos"> 
								<CAPTION class="cap"> <?php echo '<img src="'.$dnnn['drap_1'].'" class="drapeau" alt="" width="20px" height="20px">'.$dnnn['equipe_1'].' '.$dnnn['score_equipe_1'].' - '.$dnnn['score_equipe_2'].' '.$dnnn['equipe_2'].'<img src="'.$dnnn['drap_2'].'" class="drapeau" alt="" width="20px" height="20px">' ?> </CAPTION>
								<thead>  	
								  <tr>  
									<th class="text-centered">Joueur</th>  
									<th class="text-centered">Pari</th> 
									<th class="text-centered">Points</th>
								  </tr>  
								</thead> 
						
			<?php
			
			//Seconde requete, pour afficher les pronos relatifs au match sélectionne
			$reqq = $bdd->prepare($query_affich_prono_tous_joueurs);
			$reqq->execute(array($_POST['choix']));
			while ($dnnn = $reqq->fetch())
			{
			?>
				<tr>
					<td class="text-centered"><?php echo $dnnn['nom'];  ?> </td>
					<td class="text-centered"><?php echo $dnnn['score_equipe_1']; ?> - <?php echo $dnnn['score_equipe_2']; ?></td>
					<td class="text-centered"><?php echo $dnnn['points_gagnes']; ?></td>
				</tr>
				
			<?php
			}
			
			$reqq->closeCursor();
			}
		
		?>
		
		
		
		
		
		
		<?php
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/*$req = $bdd->prepare($query_affich_matchs_joues);
		$req->execute(array());
		
		
		while ($dnn = $req->fetch())
		{		
			?>
			
			<table class="table table-striped table-bordered table-hover table-all-pronos"> 
								<CAPTION class="cap"> <?php echo '<img src="'.$dnn['drap_1'].'" class="drapeau" alt="" width="20px" height="20px">'.$dnn['equipe_1'].' '.$dnn['score_equipe_1'].' - '.$dnn['score_equipe_2'].' '.$dnn['equipe_2'].'<img src="'.$dnn['drap_2'].'" class="drapeau" alt="" width="20px" height="20px">' ?> </CAPTION>
								<thead>  	
								  <tr>  
									<th class="text-centered">Joueur</th>  
									<th class="text-centered">Pari</th> 
									<th class="text-centered">Points</th>
								  </tr>  
								</thead> 
						
			<?php
			// On affiche uniquement les matchs dèja pronostiquer mais pour lesquels le match n'a pas eu lieu encore
			$reqq = $bdd->prepare($query_affich_prono_tous_joueurs);
			$reqq->execute(array($dnn['id']));
			//$i = 0;
			while ($dnnn = $reqq->fetch())
			{
			?>
				<tr>
					<td class="text-centered"><?php echo $dnnn['nom'];  ?> </td>
					<td class="text-centered"><?php echo $dnnn['score_equipe_1']; ?> - <?php echo $dnnn['score_equipe_2']; ?></td>
					<td class="text-centered"><?php echo $dnnn['points_gagnes']; ?></td>
				</tr>
				
			<?php
			}
			
			$reqq->closeCursor();
		}
		$req->closeCursor();
		*/
	 // Termine le traitement de la requête
//$_SESSION['matchs2']=$matchs2;
?>
</form>
</table>
		<?php
		
		}
		else
		{
			$message = 'Connectez vous pour acceder &agrave; cette page';
		}
		if(isset($message))
		{
			echo '<div class="message"><a href="connexion.php">'.$message.'</a></div>';
		}
		?>	
		
		</div>
	</body>
</html>