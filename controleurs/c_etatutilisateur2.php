<?php


$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = $_SESSION['idVisiteur'];


switch ($action) {
    
//    case 'parametrage1':
//        {
//        
//        $lesdata = $pdo->getutilisateur();
//
//        $lesClesu = array_keys($lesdata);
//        $userselection = $lesClesu[0];
//        
//        include 'vues/v_listeutilisateur.php';
//        break;
//        }
        
    case 'selectionnerutilisateur':
        {  
 



//      $idz = $_POST['l'];
        $idz =filter_input(INPUT_POST, 'listeexcep', FILTER_SANITIZE_STRING);
        
//      echo ('Apres le filter'.$idz[0].$idz[1].$idz[2]);

        if (empty($idz[2])){
            $idz_1=$idz[0].$idz[1];
        }
        else{
        if (empty($idz[3])){
        $idz_1=$idz[0].$idz[1].$idz[2];
        }
        else
        {
            $idz_1=$idz[0].$idz[1].$idz[2].$idz[3];
        }
        }

//      echo ('valeur apres concatenation  '.$idz[0].$idz[1].$idz[2]);        
//        var_dump($idz_1);
        
        $lesdata = $pdo->getutilisateur();
        
 //     echo ('Juste avant la fonction getutilisateurx');
        $unedatauti = $pdo->getutilisateurx($idz_1);
//      var_dump($unedatauti);
//      echo('valeur du tableau'.$unedatauti[0]);
       


        $lesClesu = array_keys($lesdata);
        $userselection = $lesClesu[0];
        
        $lesMois = $pdo->getLesMoisDisponiblesspe();
        // Afin de sélectionner par défaut le dernier mois dans la zone de liste
        // on demande toutes les clés, et on prend la première,
        // les mois étant triés décroissants
        
        
        //essai affiche d'une selection dédié
        
        $lesMoisp = $pdo->getLesMoisDisponiblesspe2($idz);
        
        $lesCles = array_keys($lesMois);
        $moisASelectionner = $lesCles[0];

        include 'vues/v_listeutilisateur.php';
        break;
    }
    
    
    
    case 'listefraisutilisateur':
        {
        
        $idz =$_POST['valeur01'];
        $iduser=$idz;
        // $iduser = filter_input(INPUT_POST, 'listeexcep', FILTER_SANITIZE_STRING);
        
        var_dump($iduser);
        $affnomutil =$_POST['valeur02'];
        
        
//        $iduser = filter_input(INPUT_POST, 'lstuser', FILTER_SANITIZE_STRING);
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        
        $lesdata = $pdo->getutilisateur();       
        
        $userselection = $iduser;
        $lesMois = $pdo->getLesMoisDisponiblesspe();
        $moisASelectionner = $leMois;
        
        include 'vues/v_listeutilisateur.php';
        

        //    $idz =filter_input(INPUT_POST, 'listeexcep', FILTER_SANITIZE_STRING);
        $idz =$_POST['valeur01'];
        
        $iduser=$idz;
        
        
        
//        $iduser = filter_input(INPUT_POST, 'lstuser', FILTER_SANITIZE_STRING);
        
        $lesdatap = $pdo->getlistedefrais($iduser,$leMois); 
        
        $tabb1=$pdo->mval1($userselection,$moisASelectionner);
        $tabb2=$pdo->mval2($userselection,$moisASelectionner);
        $tabb3=$pdo->mval3($userselection,$moisASelectionner);
        $tabb4=$pdo->mval4($userselection,$moisASelectionner);
        $tabb5=$pdo->mval5($userselection,$moisASelectionner);
//        echo "<tr><td>......</td>"; 
        
        include 'vues/v_listeutilisateur1.php';
        
        $idz =$_POST['valeur01'];
        $iduser=$idz;
        
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($iduser, $leMois);
        $lesFraisForfait = $pdo->getLesFraisForfait($iduser, $leMois);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($iduser, $leMois);
        $numAnnee = substr($leMois, 0, 4);
        $numMois = substr($leMois, 4, 2);
        $libEtat = $lesInfosFicheFrais['libEtat'];
        $montantValide = $lesInfosFicheFrais['montantValide'];
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
        include 'vues/v_etatFrais_1.php';
        
        break;
        }
    
    

    }
   


