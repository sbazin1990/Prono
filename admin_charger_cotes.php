<?php
include('config.php');

/**
*Structure données des cotes pour un match
**/
class Struct_cotes {
    public $cote_equipe_a;
    public $cote_match_nul;
    public $cote_equipe_b;
}

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
        <title>Charger cotes</title>
    </head>
	<body>
        <?php include('admin_navbar.php'); ?>
		<!-- header -->
    	<div class="header">
        	<h1>Charger cotes</h1>
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
				// S'exécute uniquement si le user a cliqué sur le bouton "Afficher cotes"
				if(isset($_POST['envoi']) && $_POST['envoi'] == 'yes')
				{
                    $tab_cotes = array();
					$dom = charger_xml($url_xml);
                    $tab_cotes = retourner_cotes_compet_from_xml($dom, $_POST['compet']);
				}		
                // S'exécute uniquement si le user a cliqué sur le bouton "Sauver cotes"
				if(isset($_POST['envoi2']) && $_POST['envoi2'] == 'yes')
				{
                    $tab_cotes_to_db = array();
                    $tab_cotes_to_db = $_SESSION['cotes'];
                    if (isset($tab_cotes_to_db))
                    {
                        //TO DO => CHARGER COTES EN BASE 
                        foreach($tab_cotes_to_db as $cle => $element)
                        {
                            //echo $element->cote_equipe_b;
                        }
                    }
                    else
                    {
                        $message3 = 'Afficher les cotes en premier';
                    }
				}	
                ?>
				<?php 
                    $req = $bdd->prepare($query_select_competitions);
                    $req->execute(array());
                ?>
                <!-- On affiche une combobox avec la liste des Compétitions -->
                <div align="center"> 
                <form class ="form-cotes" method="post" action="admin_charger_cotes.php">
                <input type="hidden" name="envoi" value="yes">
                    <select name="compet">
                        <option value=""></option>
                    <?php 
                        while ($dnn = $req->fetch())
                        {
                            echo '<option value="'.$dnn['nom'].'">'.$dnn['nom'].'</option>';
                        }
                    ?>	
                    </select>
                    <br /><input class="btn btn-default" name="send" type="submit" value="Afficher cotes">
                </form>
                </div>
                <?php 
                if(isset($_POST['envoi'])){
                ?>	
                <!-- Etape 1/2 traitement cotes => table pour afficher toutes les cotes des matchs pour une compétition donnée -->
                <table class="table table-striped table-bordered table-hover">  
                    <thead>  
                        <tr>  
                            <th class="left">Nom match</th>  
                            <th class="text-right">Cotes Victoire Equipe 1</th> 
                            <th class="text-right">Cotes Match Nul</th> 
                            <th class="text-right">Cotes Victoire Equipe 2</th>                             
                        </tr>  
                    </thead> 						
                    <tbody> 
                        <form action="admin_charger_cotes.php" method="post">
                        <input type="hidden" name="envoi2" value="yes">                     
                                <?php      
                                $i = 0;
                                foreach($tab_cotes as $cle => $element)
                                {
                                    $i++;
                                ?>
                                <tr>
                                    <td>
                                    <label for="<?php echo $cle  ?>"><?php echo $cle  ?></label>
                                    </td>
                                    <td class="text-right">
                                    <label for="<?php echo $i  ?>"><?php echo $element->cote_equipe_a ?></label>
                                    </td>	
                                    <td class="text-right">
                                    <label for="<?php echo $i  ?>"><?php echo $element->cote_match_nul ?></label>
                                    </td>	
                                    <td class="text-right">                                
                                    <label for="<?php echo $i  ?>"><?php echo $element->cote_equipe_b  ?></label>
                                    </td>										
                                </tr>	
                                <?php
                                }
                                $_SESSION['cotes'] = $tab_cotes;
                                ?>		                            
                            </tbody>  
                    <tfoot> 
                        <tr>    
                            <!-- Etape 2/2 traitement cotes =>  Bouton pour sauvegarder les cotes en base -->
                            <td class="text-center"><input type="submit" value="Sauver cotes" class="btn btn-default" /></td>                                         
                        </form>
                        </tr>                    
                    </tfoot>
                </table>
                <?php
                }
                ?>
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
        if(isset($message3))
		{
			echo '<div class="message"><a href="connexion.php">'.$message3.'</a></div>';
		}
		?>
		</div>
		<!-- footer -->
	</body>
</html>