<?php
include('config.php');
include('admin_api.php');
?>

<!DOCTYPE html>
<html>
    <head>
		<!--<meta http-equiv="refresh" content="10" > -->
        <meta charset="utf-8" />
		<!-- Intégration du CSS Bootstrap -->
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" /> 
		<?php include('jquery_fonctions.php'); ?>
		
        <title>Créer équipe</title>
		</head>
		<body>
        <?php include('admin_navbar.php'); ?>
		<!-- header -->
    	<div class="header">
        	<h1>Créer un nouveau match</h1>
	    </div>
			
		<!-- content -->
        <div class="content" id="page">
        <?php
		// Message à afficher en fin de page
		$message = null;
		// Accessible uniquement si le user est log
		if(isset($_SESSION['username']))
		{
			// Accessible uniquement si le user est admin
			if(isset($_SESSION['admin']) && $_SESSION['admin'] == $is_admin)
			{
				// S'exécute uniquement si le user a posté le résultats des matchs
				if(isset($_POST['envoi']) && $_POST['envoi'] == 'yes')
				{
					creer_nouveau_match($_POST['nom_equipe_domicile'],$_POST['nom_equipe_exterieur'],$_POST['date_match'],$_POST['heure_match']);					
				}
				
				$req2 = $bdd->prepare($select_all_teams);
				
				
				?>
					<table class="table table-striped table-bordered table-hover">  
						<thead>  
						  <tr>  
							<th class="left">Equipe Domicile</th>  
							<th class="text-right">Equipe Exterieur</th>	
							<th class="text-right">Jour Match</th>
							<th class="text-right">Heure Match</th>
						  </tr>  
						</thead> 
						
						<tbody> 
						<form action="admin_creer_match.php" method="post">
						<input type="hidden" name="envoi" value="yes">
							<tr>
								<td>
								<select name="nom_equipe_domicile">
									<?php 
									$req2->execute(array());
									while ($dnn = $req2->fetch())
									{
										echo '<option value="'.$dnn['nom'].'">'.$dnn['nom'].'</option>';
									}
									?>	
								</select>
								</td>
								<td class="text-right">
								<select name="nom_equipe_exterieur">
									<?php 
									$req2->execute(array());
									while ($dnn = $req2->fetch())
									{
										echo '<option value="'.$dnn['nom'].'">'.$dnn['nom'].'</option>';
									}
									?>	
								</select>
								</td>
								<td class="text-right">
								<input type="text" name="date_match" id="datepicker"  class="text-right" style="width:150px;height:20px;" /><br />
								</td>
								<td class="text-right">
								<input type="text" name="heure_match" id="timepicker"  class="text-right" style="width:150px;height:20px;" /><br />
								</td>									
								
							</tr>															
						</tbody>  
						<tfoot> 
						<tr>                                   
							<td class="text-center"><input type="submit" value="Creer match" class="text-center" /></td>                                         
							</form>
						</tr>                    
						</tfoot>
					</table>
				<?php
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