
<?php
/* Fichier à supprimer */
   $ciblefichier=filter_input(INPUT_GET, 'nomfich', FILTER_SANITIZE_STRING);
   //$ciblefichier1="C:\xampp\htdocs\dossexamenappligsb\e4p1gsb2020\justificatif" & $ciblefichier;
   echo $ciblefichier;
   
   $fichier=$ciblefichier;

   
     unlink($fichier);
     
    header('Location: index.php?uc=gererFrais&action=saisirFrais');
   
   
?>