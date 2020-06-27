<?php
/**
 * Gestion de l'accueil
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

if ($estConnecte) 
    {
     $cat= $_SESSION['cat'];
    }
   

if ($estConnecte &&  $cat=="uti")
    {
    include 'vues/v_accueil.php';
    }
else
    {
    if ($estConnecte &&  $cat=="adm")
    {
    include 'vues/v_accueil_1.php';
    }
 else {   
    include 'vues/v_connexion.php';
 }
}
