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

        <title>Renvoi mot de passe</title>

    </head>

    <body>

        <?php

        include('navbar.php');    

        ?>

    	<div class="header">

        	<h1> Renvoi mot de passe </h1>

	    </div>

<?php

//Si les infos renvoyé par le formulaire (cf. plus bas) existent on les traite sinon on affiche le formulaire

//On verifie que le formulaire a ete envoye

if(isset($_POST['email']) and $_POST['email']!='')

{

	//On enleve lechappement si get_magic_quotes_gpc est active

	if(get_magic_quotes_gpc())

	{
		$_POST['email'] = stripslashes($_POST['email']);

	}

	$email = trim($_POST['email']);	

	// On vérifie que l'email match l'expression régulière

	if(!filter_var($email, FILTER_VALIDATE_EMAIL))

	{

		$form = true;

		$message = 'L\'adresse email ne respecte pas le bon format.';

	}

	else

	{
		$req = $bdd->prepare($query_user);
		$req->execute(array($username));
		$dn = $req->fetch();

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

    <form role="form" action="renvoi_mdp.php" method="post">

        <div class="form-group">

            <label for="password"><strong>Email</strong></label><input class="form-control" type="text" name="email" /><br />

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