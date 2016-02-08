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
        <title>Vos pronostics</title>
    </head>
    <body>
        <?php
        include('navbar.php');    
		$is_end_prono_qualif = date('2014-06-13 18:00:00') < date('Y-m-d H:i:s');
        ?>
    	<div class="header">
        	<h4> Vos pronostics sur les matchs </h4>
	    </div>
        <div class="content" id="page">
        <?php
		if(isset($_SESSION['username']))
		{
		?>
<table class="table table-striped table-bordered table-hover">  
					<form action="supprimer_prono.php" method="post">
					<input type="hidden" name="envoi" value="yes">
					<thead>  
					
					  <tr>  
						<th class="left">Equipe A</th>  
						<th class="text-centered">Votre pronostic</th> 
						<th class="left">Equipe B</th>
						<th class="text-centered"><input class="btn btn-default text-centered" type="submit" value="Effacer" /></th>
						<th class="text-centered">Score final</th>
						<th class="text-centered">Points gagn&eacute;s</th>
					  </tr>  
					</thead> 
			
<?php
// On affiche uniquement les matchs dèja pronostiquer mais pour lesquels le match n'a pas eu lieu encore
$req = $bdd->prepare($query_affich_prono);
$req->execute(array($_SESSION['userid']));
//$i = 0;
$tab_date_match= array();
while ($dnn = $req->fetch())
{
    $tab_date_match[$dnn['idm']] = $dnn['date_lim'];
	$is_match_already_played = $dnn['date_lim'] < date('Y-m-d H:i:s');
	//$matchs2[$i] = $dnn['idm'];
?>
	<tr>
		<td class="widthCell1"><img src="<?php echo $dnn['drap_1'] ?>" class="drapeau" alt="" width="20px" height="20px"><?php echo $dnn['equipe_1']; ?></td>
    	<td class="text-centered"><?php echo $dnn['score_equipe_1']; ?> - <?php echo $dnn['score_equipe_2']; ?></td>
		<td class="widthCell2"><img src="<?php echo $dnn['drap_2'] ?>" class="drapeau" alt="" width="20px" height="20px"><?php echo $dnn['equipe_2']; ?></td>
		<td class="text-centered">
			<input type="checkbox" 	name="check[]" value="<?php echo $dnn['idm']; ?>" <?php
			if($is_match_already_played){
				echo " disabled ";
			}
			?>/>
		</td>
		<td class="text-centered"><?php
			if($is_match_already_played){
				if(is_numeric($dnn['score_reel_1'])){
					echo $dnn['score_reel_1'].' - '.$dnn['score_reel_2'];
				}
				else{
					echo "X";	
				}
			}
			else{
				echo "X";
			} 
		?></td>
		<td class="text-centered"><?php
			if($is_match_already_played){
				echo $dnn['points_gagnes'];
			}
			else{
				echo "X";
			} 
		?></td>
	</tr>
	
<?php
}
$_SESSION['datelim2']=$tab_date_match;
$req->closeCursor();
	 // Termine le traitement de la requête
//$_SESSION['matchs2']=$matchs2;
?>
</form>
</table>

    	<div class="header">
        	<h4> Vos pronostics sur les qualifi&eacute;s de la phase de poules </h4>
	    </div>
        <div class="content">
				<?php
		if(isset($_SESSION['username']))
		{
		?>
		<table class="table table-striped table-bordered table-hover">  
							<form action="supprimer_prono.php" method="post">
							<input type="hidden" name="envoi" value="yes">
							<thead>  
							
							 <tr>  
								<th class="left">Groupe</th>  
								<th class="text-center">Qualifie 1</th> 
								<th class="text-center">Qualifie 2</th> 
								<th class="text-centered"><input class="btn btn-default text-center" type="submit" value="Effacer" /></th>
								
							 </tr> 
							</thead> 
					
		<?php
		$req = $bdd->prepare($query_affich_prono_qualif);
		$req->execute(array($_SESSION['userid']));
		//$i = 0;
		if ($req->rowCount() != 0)
		{
			while ($dnn = $req->fetch())
			{
				
				$tab_qualif_1 = get_qualif($dnn, 1);
				$tab_qualif_2 = get_qualif($dnn, 2);
				//$matchs2[$i] = $dnn['idm'];
				foreach ($tab_qualif_1 as $group => $qualif )
				{
					// on recupere le nom de la team
					$req = $bdd->prepare($query_aff_qualif_2);
					$req->execute(array($qualif));
					$dn = $req->fetch();
					if (array_key_exists($group, $tab_qualif_2))
					{
						$qualif_2 = $tab_qualif_2[$group];
						// on recupere le nom de la team
						$reqB = $bdd->prepare($query_aff_qualif_2);
						$reqB->execute(array($qualif_2));
						$dn2 = $reqB->fetch();
			?>
				<tr>
					<td class="left">Groupe <?php echo $group; ?></td>
					<td class="widthCell1"><img src="<?php echo $dn['drap_url'] ?>" class="drapeau" alt="" width="20px" height="20px"><?php echo $dn['nom']; ?></td>
					<td class="widthCell2"><img src="<?php echo $dn2['drap_url'] ?>" class="drapeau" alt="" width="20px" height="20px"><?php echo $dn2['nom'] ?></td>
					<td class="text-centered">
						<input type="checkbox" 	name="check2[]" value="<?php echo $group; ?>" <?php
						if($is_end_prono_qualif){
							echo " disabled ";
						}
						?>/>
					</td>

					
				</tr>
				
			<?php
					}
				}
			}
			$req->closeCursor();

		}
			 // Termine le traitement de la requête
		//$_SESSION['matchs2']=$matchs2;
       
		$reqa = $bdd->prepare($query_nb_points_qualif);
		$reqa->execute(array($_SESSION['userid']));
		//$i = 0;
		if ($reqa->rowCount() != 0)
		{
			$res = $reqa->fetch();
		?>
            <tr>
					<td class="left"><strong>Nombre total de points gagnes</strong></td>
					<td class="widthCell1" colspan="3"><?php echo $res['pts'] ?></td>	
			</tr>
		</form>
		</table>
		<?php
        }
        $reqa->closeCursor();
		}
		?>

		</div>
		
		<div class="header">
        	<h4> Vos pronostics sur les vainqueurs de la comp&eacutetition </h4>
	    </div>
        <div class="content">
				<?php
		if(isset($_SESSION['username']))
		{
		?>
		<table class="table table-striped table-bordered table-hover">  
							<form action="supprimer_prono.php" method="post">
							<input type="hidden" name="envoi" value="yes">
							<thead>  					
							  <tr>  
								<th class="left">Gagnant</th>  
								<th class="text-center">Deuxi&egrave;me</th> 
								<th class="text-center">Troisi&egrave;me</th> 
								<th class="text-centered"><input class="btn btn-default text-center" type="submit" value="Effacer" /></th>
							  </tr>  
							</thead>  
					
		<?php
		$req = $bdd->prepare($query_affich_prono_qf_gagnant);
		$req->execute(array($_SESSION['userid']));
		//$i = 0;
		if ($req->rowCount() != 0)
		{
			$dnn = $req->fetch();
			//$is_end_prono_qualif = date('2014-06-12 21:00:00') < date('Y-m-d H:i:s');
				//$matchs2[$i] = $dnn['idm'];
			?>
				<tr>
					<td class="widthCell1"><img src="<?php echo $dnn['drap_url_a'] ?>" class="drapeau" alt="" width="20px" height="20px"><?php echo $dnn['team_a']; ?></td>
					<td class="widthCell2"><img src="<?php echo $dnn['drap_url_b'] ?>" class="drapeau" alt="" width="20px" height="20px"><?php echo $dnn['team_b'] ?></td>
					<td class="widthCell2"><img src="<?php echo $dnn['drap_url_c'] ?>" class="drapeau" alt="" width="20px" height="20px"><?php echo $dnn['team_c'] ?></td>
					<td class="text-centered">
						<input type="checkbox" 	name="check3" value="OK" <?php
						if($is_end_prono_qualif){
							echo " disabled ";
						}
						?>/>
					</td>				
				</tr>				
			<?php
		
			$req->closeCursor();
		}
			 // Termine le traitement de la requête
		//$_SESSION['matchs2']=$matchs2;
		?>
		</form>
		</table>
		<?php
		}
		?>

		</div>
		
		
		
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