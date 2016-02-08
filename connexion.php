<?php
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Intégration du CSS Bootstrap -->
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />  		
        <title>Connexion</title>
    </head>		
    <body>		<div id="page">
		 <?php
        include('navbar.php');    
        ?>
    	<div class="header">
        	<h1> Connexion </h1>
	    </div>
<?php
//Si lutilisateur est connecte, on le deconecte
if(isset($_SESSION['username']))
{
	//On le deconecte en supprimant simplement les sessions username et userid
	unset($_SESSION['username'], $_SESSION['userid']);
?>
<div class="message">Vous avez bien &eacute;t&eacute; d&eacute;connect&eacute;.<br />
<a href="<?php echo $url_home; ?>">Accueil</a></div>
<?php
}
else
{
	$ousername = '';
	$_SESSION['admin'] = 0;
	//On verifie si le formulaire a ete envoye
	if(isset($_POST['username'], $_POST['password']))
	{
				
		//On echappe les variables pour pouvoir les mettre dans des requetes SQL
		if(get_magic_quotes_gpc())
		{
			$ousername = stripslashes($_POST['username']);
			$username = trim(stripslashes($_POST['username']));
			$password = stripslashes($_POST['password']);
		}
		else
		{
			$username = trim($_POST['username']);
			$password = $_POST['password'];
		}
		//On recupere le mot de passe de lutilisateur
		$req = $bdd->prepare($query_user);
		$req->execute(array($username));
		$dn = $req->fetch();
		//On le compare a celui quil a entre et on verifie si le membre existe
		if($dn['mdp']==$password and $req->rowCount()>0)
		{
			//Si le mot de passe es bon, on ne vas pas afficher le formulaire
			$form = false;
			//On enregistre son pseudo dans la session username et son identifiant dans la session userid
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['userid'] = $dn['id'];
			$_SESSION['admin'] = $dn['admin'];

				//special admin : on propose la page admin 
			if(isset($_SESSION['admin']) && $_SESSION['admin'] == $is_admin)
			{	
				header('Location: admin.php');
			}
			else
			{
				header('Location: index_wc.php'); 
			}

		}
		else
		{
			//Sinon, on indique que la combinaison nest pas bonne
			$form = true;
			$message = 'La combinaison que vous avez entr&eacute; n\'est pas bonne.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
		//On affiche un message sil y a lieu
	if(isset($message))
	{
		echo '<div class="message">'.$message.'</div>';
	}
	//On affiche le formulaire
?>
<div class="content">
    <form role="form" action="connexion.php" method="post">
        <div class="form-group">
            <label for="username"><strong>Email</strong></label><input class="form-control" type="text" name="username" id="username" value="<?php echo htmlentities($ousername, ENT_QUOTES, 'utf-8'); ?>" /><br />
            <label for="password"><strong>Mot de passe</strong></label><input class="form-control" type="password" name="password" id="password" /><br />
            <input class="btn btn-default" type="submit" value="Connexion" /><br /> 
			<a href="sinscrire.php">Pas encore inscrit ?</a> <br />
			<!--<a href="renvoi_mdp.php">J'ai perdu mon mot de passe</a> -->
		</div>
    </form>
</div>
<?php
	}
}
?>
				</div>
	</body>		
</html>