<?php
/**
 * 161019 modification
 * Index du projet GSB
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

require_once 'includes/fct.inc.php';
require_once 'includes/class.pdogsb.inc.php';


session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();

//il est disposé unvar_dump pour comprendre et afficher l'objet estConnecte en décommentant
var_dump($estConnecte);


if ($estConnecte) 
    {
     $cat= $_SESSION['cat'];
    }
    
// Le if dessous permet de gérer le parcours de la connection selon si l'utilisateur est admin  ou classique
    
if (!$estConnecte)
{
require 'vues/v_entete.php';
}
 else {
     if($cat=="adm")
     {
//      require 'v_entete_1_1.php';   
      require 'vues/v_entete_1.php'; 
     }
     else
     {
      require 'vues/v_entete.php';   
     }      
}
echo'index';
var_dump($uc);
$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
// filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING); le 'uc' donne son nom et son type qui est un filtre
echo'index';
var_dump($uc);


if ($uc && !$estConnecte) {
   
    $uc = 'connexion';
    
} elseif (empty($uc)) {
    var_dump("ZZZ");
    $uc = 'accueil';
    var_dump($uc);
}


switch ($uc) {
case 'connexion':
    include 'controleurs/c_connexion.php';
    break;
case 'accueil':
    include 'controleurs/c_accueil.php';
    break;
case 'gererFrais':
    include 'controleurs/c_gererFrais.php';
    break;
case 'etatFrais':
    include 'controleurs/c_etatFrais.php';
    break;
case 'admin':
    include 'controleurs/c_etatFrais_1.php';
    break;
case 'admin1':
    include 'controleurs/c_etatFrais_1_1.php';
    break;
case 'etatutilisateur':
    include 'controleurs/c_etatutilisateur.php';
    break;
case 'etatutilisateur2':
    include 'controleurs/c_etatutilisateur2.php';
    break;

case 'deconnexion':
    include 'controleurs/c_deconnexion.php';
    break;
}
require 'vues/v_pied.php';



