<?php
//On demarre les sessions
session_start();

/*******************************************	***********
----------------Configuration Obligatoire--------------
Veuillez modifier les variables ci-dessous pour que l'
espace membre puisse fonctionner correctement.
******************************************************/
//Admin 
$is_admin = "X";

//On se connecte a la base de donnee
try
{
	//$bdd = new PDO('mysql:host=kzq7tb92.sql-pro.online.net;dbname=kzq7tb92', 'kzq7tb92', 'Galaxy13');
	$bdd = new PDO('mysql:host=localhost;dbname=testsba;charset=utf8', 'root', '');
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
//Email du webmaster
$mail_webmaster = 'pierre0aguilar@gmail.com';

//Adresse du dossier de la top site	
$url_root = 'http://www.example.com/';

// Bootstrap CSS
$boot_css = 'css/bootstrap/css/bootstrap.css';

// Requêtes SQL 
$query_user = '
SELECT 
	mdp,
	id,
	admin
FROM 
	USERS
WHERE 
	email= ?
';

$query_inscription = '
SELECT 
	id 
FROM 
	USERS 
WHERE 
	nom=?
';

$query_inscription_2 = '
SELECT 
 id 
FROM 
 USERS 
WHERE 
 email=?
';

$query_nb_points_qualif= '
SELECT
    points_gagnes pts
FROM
    PRONOS_QUALIF
WHERE
    id_joueur = ?
';

$query_supp_prono = '
DELETE FROM 
	PRONOS_MATCHS 
WHERE 
	id_joueur = :id_player 
	AND id_match = :id_match
';

$query_affich_prono = '
SELECT 
	C.nom equipe_1, 
	C.drap_url drap_1, 
	A.score_equipe_1, 
	D.nom equipe_2, 
	D.drap_url drap_2, 
	A.score_equipe_2, 
	A.points_gagnes,
	B.id idm,
	B.date_match,
    (B.date_match - INTERVAL 15 MINUTE) date_lim,
	B.score_equipe_1 score_reel_1,
	B.score_equipe_2 score_reel_2
FROM 
	PRONOS_MATCHS A, 
	MATCHS B, 
	TEAMS C, 
	TEAMS D
WHERE 
	A.id_joueur = ? 
	AND A.id_match = B.id 
	AND C.id = B.id_equipe_1 
	AND D.id = B.id_equipe_2 
ORDER BY 
	B.DATE_MATCH;
';

$query_affich_matchs_joues ='
SELECT
	C.nom equipe_1,
	D.nom equipe_2,
	C.drap_url drap_1,  
	D.drap_url drap_2, 
	B.score_equipe_1,
	B.score_equipe_2,
	B.id
FROM 
	MATCHS B, 
	TEAMS C, 
	TEAMS D
WHERE
	C.id = B.id_equipe_1 
	AND D.id = B.id_equipe_2
	AND (B.date_match - INTERVAL 15 MINUTE) < NOW()
ORDER BY
	B.DATE_MATCH desc;
';

$query_affich_info_match ='
SELECT
	C.nom equipe_1,
	D.nom equipe_2,
	C.drap_url drap_1,  
	D.drap_url drap_2, 
	B.score_equipe_1,
	B.score_equipe_2,
	B.id
FROM 
	MATCHS B, 
	TEAMS C, 
	TEAMS D
WHERE
	C.id = B.id_equipe_1 
	AND D.id = B.id_equipe_2
	AND B.id = ?
ORDER BY
	B.id;
';

$query_prono_q = '
SELECT
    *
FROM
    PRONOS_QUALIF
WHERE
    ID_JOUEUR = ?
AND 
    ID_PREMIER > 0;
';

$query_affich_prono_tous_joueurs = '
SELECT 
	C.nom equipe_1, 
	C.drap_url drap_1, 
	A.score_equipe_1, 
	D.nom equipe_2, 
	D.drap_url drap_2, 
	A.score_equipe_2, 
	A.points_gagnes,
	B.id idm,
	B.date_match,
    (B.date_match - INTERVAL 15 MINUTE) date_lim,
	B.score_equipe_1 score_reel_1,
	B.score_equipe_2 score_reel_2,
	U.nom
FROM 
	PRONOS_MATCHS A, 
	MATCHS B, 
	TEAMS C, 
	TEAMS D,
	USERS U
WHERE 
	A.id_match = B.id 
	AND C.id = B.id_equipe_1 
	AND D.id = B.id_equipe_2 
	AND U.id = A.id_joueur
	AND B.id = ?
ORDER BY 
	A.points_gagnes desc;
';

$query_select_tous_joueurs = '
SELECT
	id,
	nom
FROM
	USERS
WHERE nom NOT LIKE \'ABANDON\'
ORDER BY
	nom;
';

$query_select_nom_joueur ='
SELECT
	nom
FROM 
	users
WHERE 
	id = ?;
';

$query_affich_prono_qualif = '
SELECT 
	ID_1_GP_A, 
	ID_1_GP_B, 
	ID_1_GP_C, 
	ID_1_GP_D, 
	ID_1_GP_E, 
	ID_1_GP_F, 
	ID_1_GP_G,
	ID_1_GP_H,
	ID_2_GP_A, 
	ID_2_GP_B, 
	ID_2_GP_C, 
	ID_2_GP_D, 
	ID_2_GP_E, 
	ID_2_GP_F, 
	ID_2_GP_G,
	ID_2_GP_H
FROM 
	PRONOS_QUALIF
WHERE 
	id_joueur = ?
';

$query_affich_prono_qualif2 = '
SELECT 
	ID_PREMIER, 
	ID_SECOND, 
	ID_TROISIEME, 

FROM 
	PRONOS_QUALIF
WHERE 
	id_joueur = ?
';

$query_affich_prono_qf_gagnant = '
SELECT 
	ID_PREMIER, 
	ID_SECOND, 
	ID_TROISIEME,
	A.nom team_a,
	B.nom team_b,
	C.nom team_c,
	A.drap_url drap_url_a,
	B.drap_url drap_url_b,
	C.drap_url drap_url_c
FROM 
	PRONOS_QUALIF D, TEAMS A, TEAMS B, TEAMS C
WHERE 
	D.id_joueur = ?
AND
	ID_PREMIER IS NOT NULL
AND
	ID_SECOND IS NOT NULL
AND
	ID_TROISIEME IS NOT NULL
AND
	A.ID = D.ID_PREMIER
AND
	B.ID = D.ID_SECOND
AND
	C.ID = D.ID_TROISIEME
';
	
$query_prono_1 = '
INSERT INTO 
	PRONOS_MATCHS(
		id_joueur, 
		id_match, 
		score_equipe_1, 
		score_equipe_2
	) 
	VALUES(
		:id_player,
		:id_match,
		:score_a, 
		:score_b
	)
';

$query_prono_2 = '
SELECT 
	B.id idmatch, 
	A.nom name_a, 
	C.nom name_b, 
	A.drap_url drap_a, 
	C.drap_url drap_b, 
	(DATE_MATCH - INTERVAL 15 MINUTE) date_lim 
FROM 
	TEAMS A,
	TEAMS C, 
	MATCHS B 
WHERE 
	B.id not in (select id_match from PRONOS_MATCHS where id_joueur = ?) 
	AND A.id = B.id_equipe_1 
	AND C.id = B.id_equipe_2
	AND DATE_MATCH - INTERVAL 15 MINUTE > CURRENT_TIMESTAMP 
ORDER BY 
	DATE_MATCH
';
	
$query_prono_qualif = '
SELECT 
	nom, 
	id
FROM 
	TEAMS
WHERE 
	id in (SELECT distinct id_equipe_1 FROM MATCHS WHERE GROUPE_PHASE = ?)
';

$query_prono_qualif2 = '
SELECT 
	distinct nom,
	id
FROM 
	TEAMS
';

$query_trait_qualif1 = '
SELECT 
	id 
FROM 
	TEAMS 
WHERE 
	nom = ?
';

$query_aff_qualif_2 = '
SELECT 
	nom, drap_url 
FROM 
	TEAMS 
WHERE 
	id = ?
';
//$query_trait_qualif2 = 'INSERT INTO PRONOS_QUALIF(id_joueur, ?, ?) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE ? = ?, ? = ?';

//$query_trait_qualif2 = 'insert into PRONOS_QUALIF';

$insert_tendance = '
UPDATE 
	USERS 
SET 
	tendance=? 
WHERE 
	id=?
';

$set_score = '
UPDATE 
	MATCHS 
SET 
	score_equipe_1=?, 
	score_equipe_2=? 
WHERE id=?
';

$get_users_ranking = '
SELECT 
	id 
FROM 
	USERS 
ORDER BY points DESC, nom
';

$get_all_pronostics = '
SELECT 
	PM.id_joueur, 
	PM.id_match, 
	PM.score_equipe_1 AS prono_equipe_1, 
	PM.score_equipe_2 AS prono_equipe_2, 
	PM.id_gagnant, 
	PM.points_gagnes,
	M.score_equipe_1 AS resultat_equipe_1,
	M.score_equipe_2 AS resultat_equipe_2
FROM 
	PRONOS_MATCHS PM, 
	MATCHS M
WHERE 
	M.id = PM.id_match
	AND M.score_equipe_1 IS NOT NULL
	AND M.score_equipe_2 IS NOT NULL
';

$insert_prono_score = '
UPDATE
	PRONOS_MATCHS
SET
	points_gagnes=?
WHERE
	id_joueur=?
	AND id_match=?
';

$compute_users_score = '
UPDATE
	USERS US
SET
	US.points = (SELECT SUM(points_gagnes) FROM PRONOS_MATCHS PM WHERE PM.id_joueur = US.id)
';

$get_played_games = '
SELECT
	MA.id,
	(SELECT nom FROM TEAMS WHERE id = MA.id_equipe_1) AS nom_equipe_1,
	(SELECT nom FROM TEAMS WHERE id = MA.id_equipe_2) AS nom_equipe_2
FROM
	MATCHS MA
WHERE
	MA.score_equipe_1 IS NULL
	AND MA.score_equipe_2 IS NULL
';

$creer_nouvelle_equipe = '
INSERT INTO TEAMS
	SELECT
		MAX(A.ID) + 1,
		:nom_equipe,
		:image_equipe,
		null
	FROM TEAMS A
';

$creer_nouveau_match = '	
INSERT INTO MATCHS
	SELECT
		MAX(A.ID) + 1,
		STR_TO_DATE(:date_match, \'%Y-%m-%d %H:%i:%s\'), 
		"",
		B.ID,
		NULL,
		NULL,
		C.ID,
		0
	FROM MATCHS A, TEAMS B, TEAMS C
	WHERE B.NOM = :nom_equipe_domicile
	AND C.NOM = :nom_equipe_exterieur
';

$select_all_teams = '
SELECT 
 nom 
FROM 
 TEAMS 
ORDER BY NOM
';

$query_select_competitions = '
SELECT
	id,
	nom,
    date_debut
FROM
	COMPETITION
ORDER BY
	date_debut;
';

/******************************************************
----------------Configuration Optionelle---------------
******************************************************/

//Nom du fichier de laccueil
$url_home = 'index_wc.php';

//Nom du design
$design = 'default';

/******************************************************
----------------Configuration cotes---------------
******************************************************/

//Nom du fichier de laccueil
$url_xml = 'http://xml.cdn.betclic.com/odds_en.xml';

?>