<!--en dessous pour voir à ce moment du programme la valeur choisi dans le taleau généré suite à l'interrogation de la base de donnée-->

<?php
//echo('Vue valeur unedateauti :'.$unedatauti[0]);
//if (isset($userselection)) {
//    echo 'Cette variable --> user selection -- existe, donc je peux la faire afficher';
//    echo $userselection;
//    echo 'la variable NOM --> user_nom -- existe, donc je peux la faire afficher';
//    echo $iduser_nom;
//}
?>


<?php
//echo ('le tableau iduser');
//var_dump($iduser);
//echo ('le tableau unedatauti');
//var_dump($unedatauti);
?>



<?php
if(isset($_POST['boutton1'])){
    $selecta=$_POST['listeexcep'];
    
//  echo 'C était la valeur suivante dans le select '. $selecta. '<br/> !';
}
?>



<h2> Fiches utilisateurs</h2>

<?php
if(isset($unedatauti[0])){
echo ('Nom de l utilisateur :'.$unedatauti[0]);
}
?>

<div class="row">
    <div class="col-md-4">
        <h3>Etat : suivi /validation :
            <?php
            if (isset ($userselection)){
//                echo 'debut';
//                echo $userselection;
//                echo 'fin';
            }
            ?>
        </h3>
    </div>
</div>

<div class="row">
    
                
    <div class="col-md-4">
        <form action="index.php?uc=etatutilisateur&action=selectionnerutilisateur"
              method="post" role="form">
            <div class="form-group">
                <label for="listeexcep" accesskey="n">1er étape / Selection de l'utilisateur : </label>
            <select id="listeexcep" name="listeexcep" class="form-control">
                
<!--                <option value="choix1">choix1</option>-->
                <?php
                            if (isset($selecta))
                            {
                            ?>
                            <option select value="<?php echo $selecta ?>">                     

                            <?php
//                            echo $selecta;
                            ?>
                            <?php
                            echo ($unedatauti[0]);
                            ?>
                            
                                    
                            </option>
                            <?php
                            }
 else{
     
 
                           
                    foreach ($lesdata as $unedata)
                    {
                            $iduser = $unedata[0];
//                           $iduser = '555';
                           
                            if ($iduser == $userselection)
                                
                                
                            
                            {
                                ?>
<!--                            $iduser-->
                                <option selected value="<?php echo $iduser ?>">                     
                                    <?php
                                    
                                    echo ($unedata[1].' // ID => '. $unedata[0])
                                    ?>
                                    
                                </option>
                                <?php
                            }
                                else
                                {
                                ?>
                                <option value="<?php echo $iduser ?>">
                                    <?php
                                     echo ($unedata[1].' / ID => '. $unedata[0])
                                    ?>
                                </option>
                                <?php
                                }
                    }
 }
 
              
                    ?>
            </select>
        </div>
            <input id="ok" type="submit" value="Valider" name="boutton1" class="btn btn-success" 
                   role="button">
        </form>
    </div>
    
   
    <div class="col-md-4">
        <form action="index.php?uc=etatutilisateur&action=listefraisutilisateur"
              method="post" role="form">
            
        <p>
            <input type="hidden" name="valeur01" value="<?php echo $idz?>" />
            <input type="hidden" name="valeur02" value="<?php echo $unedatauti[0]?>" />
        </p>
            
            
            
            
            
            
            

            
<!--    liste box avec seulement les mois concernés-->

<!--            <div class="form-group">
                <label for="listeexcep1" accesskey="n">Utilisateur choisi : </label>
                
            <select id="listeexcep1" name="listeexcep1" class="form-control">
                <option value="-->
                    <?php 
//                    echo $idz
                    ?>
<!--                        ">-->
                            <?php
//                            echo $idz
                                    ?>
<!--                </option>
            </select>
                
            </div>-->

            <div class="form-group">
                <label for="lstMois" accesskey="n">2ième étape / Choix du mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    
                    <?php
                    foreach ($lesMoisp as $unMois) {
                        $mois = $unMois['mois'];
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        if ($mois == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $mois ?>">
                                <?php echo $numMois . ' m // ' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $mois ?>">
                                <?php echo $numMois . ' m / ' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?>    

                </select>
            </div>
            
            <input id="ok" type="submit" value="Validerrrrrrr" class="btn btn-success" 
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                   role="button">
           
           
        </form>
    </div>
  
    
    
    <h2> fin </h2>
</div>

