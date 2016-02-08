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
        	<h4> Pronostics de la partie qualifi&eacute;s </h4>
	    </div>
        <div class="content" id="page">
        <?php
		if(isset($_SESSION['username']))
		{
		$req = $bdd->prepare($query_select_tous_joueurs);
		$req->execute(array());
		?>
		<!-- On affiche une combobox avec la liste des matchs deja passes -->
		<div align="center"> 
		<form class ="form-qualif" method="post" action="affichage_pronos_qualifies.php">
			<select name="choix">
				<option value=""></option>
			<?php 
				while ($dnn = $req->fetch())
				{
					echo '<option value="'.$dnn['id'].'-'.$dnn['nom'].'">'.$dnn['nom'].'</option>';
				}
			?>	
			</select>
			<br /><input class="btn btn-default" name="send" type="submit" value="Valider le choix">
		</form>
		</div>
		
		<?php 
			if(isset($_POST['send'])){
				list($data_id, $data_name) = explode("-", $_POST['choix'], 2);
			
					?>
		<table class="table table-striped table-bordered table-hover">  
							<form action="supprimer_prono.php" method="post">
							<CAPTION class="cap"> <?php echo $data_name?> </CAPTION>
							<thead>  
							
							 <tr>  
								<th class="left">Groupe</th>  
								<th class="text-center">Qualifie 1</th> 
								<th class="text-center">Qualifie 2</th> 								
							 </tr> 
							</thead> 
					
		<?php
		$req = $bdd->prepare($query_affich_prono_qualif);
		$req->execute(array($data_id));
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
		$reqa->execute(array($_POST['choix']));
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