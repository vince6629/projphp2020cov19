<?php
/**
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

if ($estConnecte) 
    {
     $cat= $_SESSION['cat'];
    }
    
if (!$estConnecte)
{
require 'vues/v_entete.php';
header("Refresh: 3;URL=index.php");
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



if ($estConnecte) 
    {
    
    echo ('valeur utilisateur validé');
    
    echo ($_POST['valeur1']);
    echo ($_POST['valeur2']);
    echo ($_POST['valeur3']);
    
    $idsuser=$_POST['valeur1'];
    $ms=$_POST['valeur2'];
    $ttg=$_POST['valeur3'];
    
    $pdo->mval($idsuser,$ms,$ttg);
    

       
    
    }




    

