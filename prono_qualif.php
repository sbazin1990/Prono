<?php
include('config.php');
function get_group($dnn, $tab_group)
{
	$tab_out = array();
	foreach ($tab_group as $group)
	{
		if (strlen($group) == 1)
		{
			if ( $dnn['ID_1_GP_' . $group] == 0 || $dnn['ID_2_GP_' . $group] == 0 )
			{
				$tab_out[] = $group;		
			}
		}
		else
		{
			if ( $dnn['ID_' . $group] == 0 )
			{
				$tab_out[] = $group;		
			}
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
        <title>Prono qualifs</title>
    </head>
    <body>
        <?php
        include('navbar.php');    
        ?>
		<div class="content" id="page">
    	<div class="header">
        	<h4> Equipes qualifiées pour les 8èmes de finales </br><small><FONT COLOR="green">  N'oubliez pas de valider vos pronostics avec le bouton Sauver </FONT></small></h4>
	    </div>
        <div class="content">
        <?php
		if(isset($_SESSION['username']))
		{
			$tab_group_init1 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
			$req = $bdd->prepare($query_affich_prono_qualif);
			$req->execute(array($_SESSION['userid']));
			//$i = 0;
			if ($req->rowCount() != 0)
			{
				$dnn = $req->fetch();
				$tab_group = get_group($dnn, $tab_group_init1);
			}
			else
			{
				$tab_group = $tab_group_init1;
			}
		?>
		<form class ="form-qualif" action="traitement_qualif.php" method="post">
			<input type="hidden" name="envoi" value="yes">
		<table class="table table-striped table-bordered table-hover table-condensed">  
			<thead>  					
			  <tr>  
				<th class="left">Groupe</th>  
				<th class="text-center">1er du groupe</th> 
				<th class="text-center">2ème du groupe</th> 
				<th class="text-center"><input class="btn btn-default text-center" type="submit" value="Sauver" /></th>
			  </tr>  
			</thead> 
			
            <?php
			
            foreach($tab_group as $group)
            {
            ?>
			<tr>
				<td class="left"> Groupe <?php echo $group; ?> </td>
                
				<td class="text-center">	
				
				
					<select class="combo_qualif" name="1_<?php echo $group; ?>" type="ComboBox">
					<?php
					echo $group;
					$req = $bdd->prepare($query_prono_qualif);
					
					$req->execute(array("Groupe " . $group));
					//$i = 0;
					while ($dnn = $req->fetch())
					{ ?>
						<option value="1_<?php echo $dnn['id']; ?>"><?php echo $dnn['nom']; ?></option>
					<?php
					}
					$req->closeCursor();
					?>	
					
					</select>
					
				</td>
				<td class="text-center">					
					
					
					<select class="combo_qualif" name="2_<?php echo $group; ?>" type="ComboBox">
					<?php
					// On affiche uniquement les matchs dèja pronostiqués mais pour lesquels le match n'a pas eu lieu encore
					$req = $bdd->prepare($query_prono_qualif);
					$req->execute(array("Groupe " . $group));
					//$i = 0;
					while ($dnn = $req->fetch())
					{ ?>
						<option value="2_<?php echo $dnn['id']; ?>"><?php echo $dnn['nom']; ?></option>
					<?php
					}
					$req->closeCursor();
					?>				
					</select>
					
				</td>
				<?php
				//Si la date limite pour le pari est dépassée, on grise la checkbox
					$date_limite = date('2014-06-13 18:00:00');
					$is_match_already_playedd = $date_limite < date('Y-m-d H:i:s');
				?>
				<td class="text-center"><input type="checkbox" name="check[]" value="<?php echo $group; ?>" <?php
			if($is_match_already_playedd){
				echo " disabled ";
			}
			?> /></td>
			</tr>
			
			
            <?php
            }
            ?> 					
			</form>

		</table>
		</div>
		
		<div class="header">
        	<h4>Trois premiers de la compétition </br><small><FONT COLOR="green">  N'oubliez pas de valider vos pronostics avec le bouton Sauver </FONT></small></h4>
	    </div>
        <div class="content">

		<form class ="form-qualif" action="traitement_qualif.php" method="post">
			<input type="hidden" name="envoi" value="yes">
		<table class="table table-striped table-bordered table-hover table-condensed">  
			<thead>  					
			  <tr>  
				<th class="left">Gagnant</th>  
				<th class="text-center">Deuxième</th> 
				<th class="text-center">Troisième</th> 
				<th class="text-center"><input class="btn btn-default text-center" type="submit" value="Sauver" /></th>
			  </tr>  
			</thead> 
			<?php
            $req_a = $bdd->prepare($query_prono_q);
			$req_a->execute(array($_SESSION['userid']));
            if ($req_a->rowCount() == 0)
			{
            ?>       
			<tr>
				<td class="text-center">	
							
					<select class="combo_qualif" name="ID_PREMIER" type="ComboBox">
					<?php
					$req = $bdd->prepare($query_prono_qualif2);
					
					$req->execute(array());
					//$i = 0;
					while ($dnn = $req->fetch())
					{ ?>
						<option value="1_<?php echo $dnn['id']; ?>"><?php echo $dnn['nom']; ?></option>
					<?php
					}
					$req->closeCursor();
					?>	
					
					</select>
					
				</td>
				<td class="text-center">					
					
					
					<select class="combo_qualif" name="ID_SECOND" type="ComboBox">
					<?php
					$req = $bdd->prepare($query_prono_qualif2);
					$req->execute(array());
					//$i = 0;
					while ($dnn = $req->fetch())
					{ ?>
						<option value="2_<?php echo $dnn['id']; ?>"><?php echo $dnn['nom']; ?></option>
					<?php
					}
					$req->closeCursor();
					?>				
					</select>
					
				</td>
				<td class="text-center">					
					
					
					<select class="combo_qualif" name="ID_TROISIEME" type="ComboBox">
					<?php
					$req = $bdd->prepare($query_prono_qualif2);
					$req->execute(array());
					//$i = 0;
					while ($dnn = $req->fetch())
					{ ?>
						<option value="3_<?php echo $dnn['id']; ?>"><?php echo $dnn['nom']; ?></option>
					<?php
					}
					$req->closeCursor();
					?>				
					</select>
					
				</td>
				<?php
				//Si la date limite pour le pari est dépassée, on grise la checkbox
					$date_limite = date('2014-06-13 18:00:00');
					$is_match_already_playedd = $date_limite < date('Y-m-d H:i:s');
				?>
				<td class="text-center"><input type="checkbox" name="check2" value="GAGNANT" <?php
			if($is_match_already_playedd){
				echo " disabled ";
			}
			?> /></td>
			</tr>
 					
			</form>
            
		</table>
		</div>
		
		
		<?php
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