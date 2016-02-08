<?php
include('config.php');
function afficher_tendance_logo($tendance)
{
	if (gmp_sign($tendance) == 0) 
	{ 
		return "image/egal.png"; 
	} 
	elseif (gmp_sign($tendance) == 1) 
	{ 
		return "image/haut.jpg"; 
	} 
	else 
	{ 
		return "image/bas.jpg"; 
	}
}
function afficher_tendance($tendance)
{
	if (gmp_sign($tendance) == 0) 
	{ 
		return " ( - place(s) )"; 
	} 
	elseif (gmp_sign($tendance) == 1) 
	{ 
		return " (+" . $tendance . " place(s) )"; 
	} 
	else 
	{ 
		return " (" . $tendance . " place(s) )"; 
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Intégration du CSS Bootstrap -->
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Classement</title>
    </head>
    <body>
        <?php
        include('navbar.php');    
        ?>
    	<div class="header">
            <h4> Classement </br><small> &euro; = participants &agrave; la cagnotte</small></h4>
	    </div>
        <div class="content" id="page">
<table class="table table-striped table-bordered table-hover">
    	<thead>  
        <tr>  
            <td class="text-center"><strong>Position</strong></td>
            <td class="text-center"><strong>Nom d'utilisateur</strong></td>
            <td class="text-center"><strong>Nombre de points</strong></td>
			<td class="text-center"><strong>Tendance</strong></td>
			
        </tr>  
        </thead> 
        <tbody> 
<?php

//On recupere les identifiants, les pseudos et les emails des utilisateurs
$req = $bdd->query('select id, nom, points, tendance, has_paid from USERS order by points desc, nom');
$j = 1;
while ($dnn = $req->fetch())
{
    if ( $dnn['has_paid'] == 1 )
    {   
?>
        <tr>
            <td class="text-center"><FONT COLOR="green"><strong><?php echo $j; ?></strong></FONT></td>
            <td class="text-center"><FONT COLOR="green"><strong><?php echo htmlentities($dnn['nom'], ENT_QUOTES, 'utf-8'); ?> &euro; </strong></FONT></td>
            <td class="text-center"><FONT COLOR="green"><strong><?php echo $dnn['points']; ?></strong></FONT></td>
            <td class="text-center"><img class="text-left img-circle fleches" src="<?php echo afficher_tendance_logo($dnn['tendance']) ?>" alt="" width= "10%"><a><?php echo afficher_tendance($dnn['tendance']) ?></a></td>
        </tr>
    <?php
        

    }
    else
    {
        if ( $j == 1 )
        {
?>
        <tr>
            <td class="text-center"><strong><?php echo $j; ?></strong></td>
            <td class="text-center"><strong><?php echo htmlentities($dnn['nom'], ENT_QUOTES, 'utf-8'); ?></strong></td>
            <td class="text-center"><strong><?php echo $dnn['points']; ?></strong></td>
            <td class="text-center"><img class="text-left img-circle fleches" src="<?php echo afficher_tendance_logo($dnn['tendance']) ?>" alt="" width= "10%"><a><?php echo afficher_tendance($dnn['tendance']) ?></a></td>
        </tr>
    <?php
        }
        else
        {
        ?>
        <tr>
            <td class="text-center"><?php echo $j; ?></td>
            <td class="text-center"><?php echo htmlentities($dnn['nom'], ENT_QUOTES, 'utf-8'); ?></td>
            <td class="text-center"><?php echo $dnn['points']; ?></td>
            <td class="text-center"><img class="text-left img-circle fleches" src="<?php echo afficher_tendance_logo($dnn['tendance']) ?>" alt="" width= "10%"><a><?php echo afficher_tendance($dnn['tendance']) ?></a></td>
        </tr>
        <?php
        }
    }
$j++;
}
$req->closeCursor(); // Termine le traitement de la requête
?>
</tbody> 
</table>
		
		</div>	
	</body>
</html>