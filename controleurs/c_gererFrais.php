<?php
/**
 * Gestion des frais
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

$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date('d/m/Y'));
// ici on teste le fait que l'application crée bien de nouvelles lignes
//$mois = '12';
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
case 'saisirFrais':
    if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
        $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
        echo'1er boucle 1er boucle1er boucle1er boucle1er boucle1er boucle';
    }
    break;
case 'validerMajFraisForfait':
    $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    }
    break;
case 'validerCreationFrais':
     
    $dateFrais = filter_input(INPUT_POST, 'dateFrais', FILTER_SANITIZE_STRING);
    $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
    $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    valideInfosFrais($dateFrais, $libelle, $montant);
    if (nbErreurs() != 0) {
        include 'vues/v_erreurs.php';
    } else {
        
        $pdo->creeNouveauFraisHorsForfait(
            $idVisiteur,
            $mois,
            $libelle,
            $dateFrais,
            $montant
        );
        
        $afftesta= $pdo->test();
        echo $afftesta;
    
        
    $nomOrigine = $_FILES['monfichier']['name'];
    echo 'c_gererfrais avant vardump';
        var_dump($nomOrigine);
    echo 'c_gererfrais derriere vardump';
    
    if(empty($nomOrigine)){
    }
    else
    {
    //require './fileupload.php';
    
    //----------------------
    
            //$nomOrigine = $_FILES['monfichier']['name'];
            $elementsChemin = pathinfo($nomOrigine);
            $extensionFichier = $elementsChemin['extension'];
            $extensionsAutorisees = array("jpeg", "jpg", "JPG","gif","pdf");
            if (!(in_array($extensionFichier, $extensionsAutorisees))) {
                echo "Le fichier n'a pas l'extension attendue";
            } else {    
                // Copie dans le repertoire du script avec un nom
                // incluant l'heure a la seconde pres 

                $repertoireDestination = dirname(__FILE__,2)."/justificatif/".$idVisiteur."/";
                //$repertoireDestination = $repertoireDestination&"justificatif/";
                $nomDestination = "fichier_du_".date("YmdHis").".".$extensionFichier;

                if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
                                                 $repertoireDestination.$nomDestination)) {
                    echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
                            " a été déplacé vers ".$repertoireDestination.$nomDestination;
                } else {
                    echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
                            "Le déplacement du fichier temporaire a échoué".
                            " vérifiez l'existence du répertoire ".$repertoireDestination;
                }
            }
    
    //----------------------
    
    }
        
    }
    break;
case 'supprimerFrais':
    $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_STRING);
    $pdo->supprimerFraisHorsForfait($idFrais);
    break;
}
echo'execution fonction';
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
echo'affichage des pages';
require 'vues/v_listeFraisForfait.php';
require 'vues/v_listeFraisHorsForfait.php';
