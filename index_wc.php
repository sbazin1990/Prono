<?php
include('config.php')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!-- Int&eacute;gration du CSS Bootstrap -->
        <link href="<?php echo $boot_css; ?>" rel="stylesheet" media="screen"> 
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />  		  		
		<link href="<?php echo $design; ?>/images/imag.ico" rel="icon"/>
        <title>Accueil</title>
    </head>
    <body>
        <?php
        include('navbar.php');    
        ?>
        <div class="content" id="page">
    	<div class="header">
        	<h2> Pronostics Coupe du monde 2014 </h1>
	    </div>
        <div class="content">
<?php
//On affiche un message de bienvenue, si lutilisateur est connecte, on affiche son pseudo
?>

<?php
if(isset($_SESSION['username']))
{
?>
<a class="but-conec" href="connexion.php" style="font-size:12pt"><button type="button" class="btn btn-success"><FONT COLOR="white">Se d&eacute;connecter</FONT></button></a>
<?php
}
else
{
//Sinon, on lui donne un lien pour sinscrire et un autre pour se connecter
?>
<div class="conec">
<a  href="sinscrire.php" style="font-size:12pt"><button type="button" class="btn btn-primary"><FONT COLOR="white">Inscription</FONT></button></a>
<a  href="connexion.php" style="font-size:12pt"><button type="button" class="btn btn-success"><FONT COLOR="white">Se connecter</FONT></button></a>
</div>
<?php
}
?>
<div class="instruction">
</br>
<p class="text-error">><strong> MAJ : Les inscriptions sont termin&eacute;es.</strong> </p>
</br>
<p class="text-success"><strong> La cagnotte </strong></h3>
<p class="text-error">><strong> Pour participer à la cagnotte, cliquez sur le lien suivant <a href="https://www.leetchi.com/c/prono-cdm-2014">cagnotte</a> </strong> </p>
<p><strong> 10 euros la participation - date limite : Vendredi 13 Juin 18h00 </strong> </p>
</br>
<p class="text-success"><strong> Pr&eacute;sentation </strong></h3>
<p><strong> Le joueur pronostique sur deux tableaux : </strong> </p>
<ul>
<li> 	Pronostics sur tous les matchs de la comp&eacute;tition (onglet <a href="pronostics.php">Prono matchs</a>)  </li>
<li> 	Pronostics sur les &eacute;quipes qui sortent de la phase de poules + pronostics sur le podium de la comp&eacute;tition (onglet <a href="pronostics.php">Prono qualifi&eacute;s</a>)  </li>
</ul>
<p class="text-error"> <strong>Attention 1 :</strong> Tout match non pronostiqu&eacute; rapporte automatiquement 0 point </p>
<p class="text-error"> <strong>Attention 2 :</strong> Tout pronostic doit &ecirc;tre r&eacute;alis&eacute; avant sa date limite (15 min avant le d&eacute;but d'un match ou avant le premier match de la CDM dans le cas de la partie Qualifi&eacute;)  </p>
<p> Vous pouvez consulter et modifier vos pronostics d&eacute;j&agrave; valid&eacutes &agrave; tout moment depuis l'onglet <a href="">Vos pronostics</a> </p>
<p class="text-error"> <strong>Attention 3 :</strong> Pour &ecirc;tre pris en compte, un pronostic doit obligatoirement &ecirc;tre valid&eacute (bouton sauvegarder)</p>

<p> L'historique des pronostics de tous les joueurs pour les matchs d&eacutej&agrave effectu&eacutes est disponible depuis l'onglet <a href="">Historique</a> </p> </br> 
<p> Contact : lespronoscdm2014 (at) gmail (point) com</p> </br>
</br>

<p class="text-success"><strong> Les r&egrave;gles du jeu </strong></h3>
<p><strong> Le d&eacute;compte des points : </strong> </p>
<ul>
<li> Pour la partie qualifi&eacute;s : </li>
<ul>
<li>15 points pour le premier du groupe </li>
<li>10 points pour le second du groupe</li>

<li>50 points pour le vainqueur final </li>
<li>30 points pour le finaliste </li>
<li>20 points pour le troisi&egrave;me </li>
</ul> </br>

<li> Pour les matchs :  </li>	
<ul>
	<li> 
		<b>Points "Bonne issue du match"</b> : Un pronostic sur la bonne issue d'un match rapporte 10 points (Victoire d'une equipe ou match nul) </br>
		Exemple : R&eacute;sultat du match : 2 - 1</br>
		Prono A : 3 - 1 => 10 point "Bonne issue du match"</br>
		Prono B : 1 - 2 => 0 point "Bonne issue du match"</br>
	</li>

	<li> Si le parieur a pronostiqu&eacute; la bonne issue du match, des points bonus sont accord&eacute;s en fonction de la pr&eacute;cision du pronostic :</br>
		<ul>
			<li>
				<b>Bonus "&Eacute;cart de but"</b> : 1 point si l'&eacute;cart de but est correct </br>
				Exemple : R&eacute;sultat du match : 2 - 1</br>
				Prono A : 3 - 1 => 0 point "&Eacute;cart de but"</br>
				Prono B : 3 - 2 => 1 point "&Eacute;cart de but"</br>
			</li>
			<li>
				<b>Bonus "Pr&eacute;cision du resultat"</b> : 4 points maximum, diminu&eacute;s de 1 pour chaque but d'&eacute;cart entre le pronostic et le score r&eacute;el.</br>
				Exemple : R&eacute;sultat du match : 2 - 1</br>
				Prono A : 5 - 1 => 1 point "Pr&eacute;cision du r&eacute;sultat"</br>
				Prono B : 3 - 2 => 2 points "Pr&eacute;cision du r&eacute;sultat"</br>
				Prono C : 2 - 1 => 4 points "Pr&eacute;cision du r&eacute;sultat"</br>
			</li>

		</ul> 
	</li>
	<li> 
		Le tableau ci-dessous r&eacute;sume diff&eacute;rents cas possibles, avec le nombre de points attribu&eacute;s :
	</li>
</ul>
</ul>
</br>
</br>
<div>
	<table class="table table-striped table-bordered table-hover table-condensed tabdemo">
					<thead>  
					  <tr >   
						<th class="text-centered">Score R&eacute;el du match</th> 
						<th class="text-centered">Pronostic</th> 
						<th class="text-centered">Points gagn&eacute;s</th> 
					  </tr>  
					</thead>
					<tbody>
					 <tr>  
						<td class="text-centered">0 - 0</td>  
						<td class="text-centered">1 - 0</td> 
						<td class="text-centered">0 point</td> 
					  </tr>	
					 <tr>  
						<td class="text-centered">0 - 0</td>  
						<td class="text-centered">1 - 1</td> 
						<td class="text-centered">13 points(10 + 1 + 2)</td> 
					  </tr>	 
					  <tr>
					  <td class="text-centered">0 - 0</td>  
						<td class="text-centered">0 - 0</td> 
						<td class="text-centered">15 points (10 + 1 + 4)</td> 
					  </tr>					  
					  <tr>
					  <td class="text-centered">1 - 2</td>  
						<td class="text-centered">1 - 0</td> 
						<td class="text-centered">0 point</td> 
					  </tr>
					  <tr>
					  <td class="text-centered">1 - 0</td>  
						<td class="text-centered">3 - 1</td> 
						<td class="text-centered">11 points (10 + 0 + 1)</td> 
					  </tr>
					  <tr>
					  <td class="text-centered">1 - 2</td>  
						<td class="text-centered">2 - 2</td> 
						<td class="text-centered">0 point</td> 
					  </tr>
					    <tr>
					  <td class="text-centered">1 - 2</td>  
						<td class="text-centered">1 - 3</td> 
						<td class="text-centered">13 points (10 + 0 + 3)</td> 
					  </tr>
					</tbody>
					</table>

			
		</div>
		</div>
		
	</body>
</html>