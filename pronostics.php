
<?php
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<!--<meta http-equiv="refresh" content="10" > -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- Intégration du CSS Bootstrap -->
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" /> 		
        <title>Pronostics</title>
    </head>
    <body>
		<div class="content" id="page">
        <?php
        include('navbar.php');    
        ?>
    	<div class="header">
        	<h4> Matchs &agrave; pronostiquer </br><small><FONT COLOR="green">  N'oubliez pas de valider vos pronostics avec le bouton Sauvegarder en bas de page </FONT></small> </h4>
	    </div>
        <div class="content">
        <?php
		if(isset($_SESSION['username']))
		{
		?>
			<?php
			if(isset($_POST['envoi']))
			{
				if($_POST['envoi'] == 'yes')
				{
					$id_player = $_SESSION['userid'];				
					foreach($_SESSION['matchs'] as $match)
					{				
						// Insertion des pronostics du joueur dans la table score_match
						$scorea = "equipe_a_" . $match;
						$scoreb = "equipe_b_" . $match;
						//echo "score a :" . $_POST[$scorea];
						if(isset($_POST[$scorea]) && isset($_POST[$scoreb]))
						{
							if((($_POST[$scorea] != NULL) && ($_POST[$scoreb] != NULL)) && 
									((is_numeric($_POST[$scorea]) || is_numeric($_POST[$scoreb])) || ($_POST[$scorea] == 0 || $_POST[$scoreb] == 0)))
							{
								$tab_date = $_SESSION['datelim'];
								if ($tab_date[$match] > date('Y-m-d H:i:s'))
								{
									$req = $bdd->prepare($query_prono_1);
									
									$req->execute(array(
									'id_player' => $id_player,
									'id_match' => $match,
									'score_a' => $_POST[$scorea],
									'score_b' => $_POST[$scoreb]
									));
								}
								else
								{
									$message = "Date de paris dépassée (15 min avant le début du match)";
								}
							}
						}
					}
				}
			}
			$req = $bdd->prepare($query_prono_2);
			$req->execute(array($_SESSION['userid']));
			if ($req->rowCount() != 0)
			{
			?>
			<table class="table table-striped table-bordered table-hover table-condensed widthTable">  
					<thead>  
					  <tr >  
						<th>Equipe A</th>  
						<th class="text-center">Score Equipe A</th> 
						<th class="text-center">Score Equipe B</th> 
						<th>Equipe B</th> 
						<th class="widthDateLimite">Date limite</th> 						
					  </tr>  
					</thead> 
					
					<tbody> 
					<form action="pronostics.php" method="post">
					<input type="hidden" name="envoi" value="yes">
					<?php
					$i = 0;
					while ($dnn = $req->fetch())
					{
						$matchs[$i] = $dnn['idmatch'];
						$tab_date_max[$dnn['idmatch']] = $dnn['date_lim'];
					?>
						<tr >
							<td class="widthCell1">
							<img src="<?php echo $dnn['drap_a'] ?>" class="drapeau" alt="" width="20px" height="20px" hspace="20px"><!--<label class="widthCell drap" for="equipe_a_">--><?php echo $dnn['name_a']; ?></label>
							</td>
							<td class="text-center">
							<input type="number" min=0 name="equipe_a_<?php echo $dnn['idmatch']  ?>" style="width:40px;height:15px;"/><br />
							</td>
							<td class="text-center">
							<input type="number" min=0 name="equipe_b_<?php echo $dnn['idmatch']; ?>"  class="text-right" style="width:40px;height:15px;"/><br />
							</td>	
							<td class="widthCell2">
							<img src="<?php echo $dnn['drap_b'] ?>" class="drapeau" alt="" width="20px" height="20px"><!--<label class="widthCell drap" for="equipe_b_">--><?php echo $dnn['name_b']; ?></label>
							</td>
							<td class="widthDateLimite">
							<label class="widthDateLimite" for="time"><?php echo $dnn['date_lim']; ?></label>
							</td>							
						</tr>									
					<?php
						$i++;
					}
					$_SESSION['matchs']=$matchs;
					$_SESSION['datelim']=$tab_date_max;
					$req->closeCursor(); // Termine le traitement de la requète					
					?>		
					</tbody>  
                    <tfoot> 
                    <tr>
						<td colspan="5" class="text-center"><input class="btn btn-default text-center" type="submit" value="Sauvegarder" class="text-center" /></td>                                        
                        </form>
                    </tr>                    
                    </tfoot>
			</table>
            
			<?php
			}
			else
			{
				$message1 = 'Aucun matchs &agrave; pronostiquer !';
			}
		
			?>	
		</div>
		<?php
		}
		else
		{
			$message2 = 'Connectez vous pour acceder &agrave; cette page';
		}
		if(isset($message))
		{
			echo '<div class="message">'.$message.'</div>';
		}
		if(isset($message1))
		{
			echo '<div class="message">'.$message1.'</div>';
		}
		if(isset($message2))
		{
			echo '<div class="message"><a href="connexion.php">'.$message2.'</a></div>';
		}
		?>	
		</div>
	</body>
</html>