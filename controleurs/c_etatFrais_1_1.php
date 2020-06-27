<?php
/**
 * Gestion de l'affichage des frais
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

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = $_SESSION['idVisiteur'];

switch ($action) {
case 'cas0':
    
    $tableutilisateur=$pdo->getutilisateurfichemodifiable();
    $tablesMois_m=$pdo->getLesMoisDisponibles_m();
    include 'vues/v_listeutilisateur1_1.php';
    break;
    
case 'cas1':

    $iu1 =filter_input(INPUT_POST, 'listeexcep', FILTER_SANITIZE_STRING);
    
    //var_dump($iu1);
    $iu1_s1 =filter_input(INPUT_POST, 'listeexcep_s1', FILTER_SANITIZE_STRING);
    //var_dump($iu1_s1);
    $testaffich=1;
    $tablelignedefrais=$pdo->gettablelignedefrais ($iu1, $iu1_s1);
    $tablelignedefraishorsforfait=$pdo->gettablelignedefraishorsforfait($iu1, $iu1_s1);
    //var_dump($tablelignedefraishorsforfait);
    include 'vues/v_listeutilisateur1_2.php';
    break;

case 'cas2':

    $testaffich=2;
    
    $iu1 =$_POST['valeuriu1'];

    $iu1_s1 =$_POST['valeuriu1_s1'];
    
    //  echo 'borne A';
    // var_dump($iu1);
    // echo 'borne B';
    // var_dump($iu1_s1);
    
    $tfrais =$_POST['t_frais'];
    
    //echo 'borne C';
    //var_dump($tfrais);
       
    
    if ($tfrais=='f1')
    {
    $iu1ligne1 =$_POST['valeuriu1ligne1'];
    $iu1ligne2 =$_POST['valeuriu1ligne2'];
    $iu1ligne3 =$_POST['valeuriu1ligne3'];
    $iu1ligne4 =$_POST['valeuriu1ligne4'];
    // var_dump($iu1ligne1);
    }
    
      
    
    
     if ($tfrais=='f2')
     {
    $iu1hfligne1 =$_POST['valeuriu1hfligne1'];
    $iu1hfligne2 =$_POST['valeuriu1hfligne2'];
    $iu1hfligne3 =$_POST['valeuriu1hfligne3'];
    $iu1hfligne4 =$_POST['valeuriu1hfligne4'];
    $iu1hfligne5 =$_POST['valeuriu1hfligne5'];
    // var_dump($iu1hfligne1);
     }
     
    // echo 'ok2';
    
    $tablelignedefrais=$pdo->gettablelignedefrais ($iu1,$iu1_s1);
    
    $tablelignedefraishorsforfait=$pdo->gettablelignedefraishorsforfait($iu1, $iu1_s1);
    
    include 'vues/v_listeutilisateur1_2.php';
    break;

case 'cas3':
    
    $iu1 =$_POST['valeuriu1'];
    $iu1_s1 =$_POST['valeuriu1_s1'];
    
    $testaffich=3;
    // echo 'ok3';
    
//    id
    $achamp1=$_POST['champm1'];
    
//    mois
    $achamp2=$_POST['champm2'];
    
// type de hors forfait
    $achamp3=$_POST['champm3'];
    
// quantité
    $achamp4=$_POST['champm4'];
    

    // var_dump($achamp1);
    // var_dump($achamp2);
    // var_dump($achamp3);
    // var_dump($achamp4);
    
   

    $ggg = $pdo->gettablelignedefraisprecis ($iu1, $iu1_s1,$achamp3);
    
    // echo'Vue ggg';
    // var_dump($ggg[0]);
    
    $pdo->modiftablelignedefraisprecis($iu1,$iu1_s1,$achamp3,$achamp4);
   // include 'vues/v_listeutilisateur1_2.php';
    break;

case 'cas4':
    
    $iu1_2 =$_POST['2valeuriu1'];
    $iu1_s1_2 =$_POST['2valeuriu1_s1'];
    
    $testaffich=4;
    // echo 'ok4';
    
    //    id
    $achamp1hf=$_POST['champm1hf'];
    
//    mois
    $achamp2hf=$_POST['champm2hf'];
    
// libellefrais
    $achamp3hf=$_POST['champm3hf'];
    
    // date
$achamp4hf=$_POST['champm4hf'];
    
// montant
    $achamp5hf=$_POST['champm5hf'];
    
    
    // var_dump($achamp1hf);
    // var_dump($achamp2hf);
    // var_dump($achamp3hf);
    // var_dump($achamp4hf);
    // var_dump($achamp5hf);
  
    
$ggg2 = $pdo->gettablelignedefraisprecishf ($iu1_2, $iu1_s1_2,$achamp3hf,$achamp4hf);
    
    //echo'Vue ggg2';
    //var_dump($ggg2[0]);
    
    $pdo->modiftablelignedefraisprecishf($iu1_2,$iu1_s1_2,$achamp3hf,$achamp4hf,$achamp5hf);
 //   include 'vues/v_listeutilisateur1_2.php';
    break;
    
}
