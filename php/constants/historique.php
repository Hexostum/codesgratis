<?php

define('FP_TYPE_CGCODE',0); // VALIDATION CGCODES

define('FP_TYPE_TOMBOLA',14); // gain au jeu de hasard
define('FP_TYPE_R_TOMBOLA',-14); //achat d'un tickets
define('FP_TYPE_PARRAIN_TOMBOLA' , 15); // gain du parrain au jeu de hasard

define('FP_TYPE_IGG',77); // Gain IG
define('FP_TYPE_IGG_C',78); // Gain IG
define('FP_TYPE_R_IGG',-77); // Recharge pour le jeu de hasard

define('FP_TYPE_HASARD',1); // Gain au jeu de hasard
define('FP_TYPE_R_HASARD',-1); // Recharge pour le jeu de hasard
define('FP_TYPE_PARRAIN_HASARD' , 2);

define('FP_TYPE_PUB',3); 
define('FP_TYPE_R_PUBS1',-3); // Recharge pour les pubs aux clics
define('FP_TYPE_R_PUBS1PLUS',-13); // Recharge pour les pubs aux clics avec des points plus
define('FP_TYPE_PARRAIN_PUB',4);

define('FP_TYPE_PAGES',5);
define('FP_TYPE_PARRAIN_PAGES',6);

define('FP_TYPE_IG',7); // INSTANT GAGNANT

define('FP_TYPE_COMMANDE',-10); // COMMANDE
define('FP_TYPE_COMMANDE_PLUS',-9); // commande avec des points plus 
define('FP_TYPE_COMMANDE_R',10); // Rembousement de commande

define('FP_TYPE_FILLEULS', -11); // ACHATS FILLEULS
define('FP_TYPE_FILLEULSR', 11); // ACHATS FILLEULS 

define('FP_TYPE_CLANS_CONCOURS',12); // GAINS au concours des clans
define('FP_TYPE_CLANS_CONCOURS_PARRAIN',13); // GAINS AU CONCOURS DES CLANS (parrain)

define('FP_TYPE_CONCOURS_C',20); // CADEAUX.
?>