<?php
include('config.php');
include('admin_api.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<!--<meta http-equiv="refresh" content="10" > -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- Intégration du CSS Bootstrap -->
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" /> 		
        <title>Créer équipe</title>
    </head>
	<body>
        <?php include('admin_navbar.php'); ?>
		<!-- header -->
    	<div class="header">
        	<h1>Créer une nouvelle équipe</h1>
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
					$saved_image = upload_image($_POST['image_equipe']);
					if ($saved_image != 1){
						creer_nouvelle_equipe($_POST['nom_equipe'], $saved_image);
					}		
				}
				
				?>
					<table class="table table-striped table-bordered table-hover">  
						<thead>  
						  <tr>  
							<th class="left">Nom equipe</th>  
							<th class="text-right">Image equipe</th> 			
						  </tr>  
						</thead> 
						
						<tbody> 
						<form action="admin_creer_equipe.php" method="post">
						<input type="hidden" name="envoi" value="yes">
							<tr>
								<td>
								<input type="text" name="nom_equipe" style="width:600px;height:20px;"/><br />
								</td>
								<td class="text-right">
								<input type="text" name="image_equipe"  class="text-right" style="width:600px;height:20px;"/><br />
								</td>	
								
							</tr>															
						</tbody>  
						<tfoot> 
						<tr>                                   
							<td class="text-center"><input type="submit" value="Creer equipe" class="text-center" /></td>                                         
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