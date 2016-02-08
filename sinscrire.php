<?php
// On charge la configuration et on démarre la session dans config.php
include('config.php');
include('test_mail.php');

function generer_mdp() {
	$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
	$pwd = '';
	for ($i=0; $i<4; $i++) {
		$j = rand(0,35);
		$pwd .= $characters[$j];
	}
	return $pwd;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- Intégration du CSS Bootstrap -->
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Inscription</title>
    </head>
    <body>
        <?php
        include('navbar.php');    
        ?>
    	<div class="header">
        	<h1> Inscription </h1>
	    </div>
<?php
//Si les infos renvoyé par le formulaire (cf. plus bas) existent on les traite sinon on affiche le formulaire
//On verifie que le formulaire a ete envoye
if(isset($_POST['username'], $_POST['email']) and $_POST['username']!='' and $_POST['email']!='')
{
	//On enleve lechappement si get_magic_quotes_gpc est active
	if(get_magic_quotes_gpc())
	{
		$_POST['username'] = stripslashes($_POST['username']);
		$_POST['email'] = stripslashes($_POST['email']);
	}
	
	$username = trim($_POST['username']);
	$email = trim($_POST['email']);
	
	// On vérifie que l'email match l'expression régulière
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$form = true;
		$message = 'L\'adresse email ne respecte pas le bon format.';
	}
	else
	{
		// On vérifie qu'il n'y a pas déjà un utilisateur incrit avec ce pseudo
		$rep = $bdd->prepare($query_inscription);
		$rep->execute(array($username));
		if($rep->rowCount()!=0)
		{
			//Sinon, on dit que le pseudo voulu est deja pris
			$form = true;
			$message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
		}
		else
		{
			// On vérifie qu'il n'y a pas déjà un utilisateur inscrit avec cet email
			$rep2 = $bdd->prepare($query_inscription_2);
			$rep2->execute(array($email));
			if($rep2->rowCount()!=0)
			{
				// Sinon, on dit que le pseudo voulu est deja pris
				$form = true;
				$message = 'Un autre utilisateur utilise d&eacute;j&agrave; cette adresse email.';
			}
			else
			{
				// On génère un password et on l'envoie par email
				$password = generer_mdp();
				$points = 0;
				
				// Insertion du user en base
				//On recupere le nombre dutilisateurs pour donner un identifiant a lutilisateur actuel
				$rep3 = $bdd->query('select id from USERS');
				$id = $rep3->rowCount()+1;
				if($bdd->query('insert into USERS(id, nom, mdp, points, email) values ('.$id.', "'.$username.'", "'.$password.'", '.$points.', "'.$email.'")'))
				{
					// Envoi de l'email
					//envoyer_mail_mdp($password, $email);
				
					// Si ca a fonctionne, on affiche pas le formulaire
					$form = false;
					?>
					<div class="message">Vous avez bien &eacute;t&eacute; inscrit. Votre mot de passe vous a &eacute;t&eacute; envoy&eacute; par email.<br />
                    <small><FONT COLOR="green">Si vous n'avez pas re&ccedil;u de mail dans un d&eacute;lai de 5 min, envoyez un mail depuis votre adresse mail d'authentification &agrave; l'adresse suivante : lespronoscdm2014@gmail.com. Votre mot de passe vous sera alors envoy&eacute; rapidement</FONT></small><br />
					<a href="connexion.php">Se connecter</a></div>
					<?php
				}
				else
				{
					//Sinon on dit quil y a eu une erreur
					$form = true;
					$message = 'Une erreur est survenue lors de l\'inscription.';
				}		
			}
		}
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
    <form role="form" action="sinscrire.php" method="post">
        <div class="form-group">
            <label for="username"><strong>Nom d'utilisateur</strong></label><input class="form-control" type="text" name="username" value="<?php if(isset($_POST['username'])){echo htmlentities($_POST['username'], ENT_QUOTES, 'utf-8');} ?>" /><br />
            <label for="password"><strong>Email</strong><span class="small"> </br> (vous y recevrez votre mot de passe) </br>  <FONT COLOR="red">(Nous vous conseillons d'utiliser une adresse mail de type Gmail/Hotmail, &eacute;vitez les adresses professionnelles)</FONT> </span></label><input class="form-control" type="text" name="email" /><br />
            <input class="btn btn-default" type="submit" value="Envoyer" />
		</div>
    </form>
</div>
<?php
}
?>
		<div class="foot"><a href="<?php echo $url_home; ?>">Retour &agrave; l'accueil</a></div>
	</body>
</html>