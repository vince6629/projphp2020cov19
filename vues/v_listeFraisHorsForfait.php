<?php
/**
 * Vue Liste des frais hors forfait
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
?>
<hr>  


<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>           
                <tr>
                    <td> <?php echo $date ?></td>
                    <td> <?php echo $libelle ?></td>
                    <td><?php echo $montant ?></td>
                    <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                           onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
                         
                </tr>
                <?php              
            }
            ?>
            </tbody>  
        </table>
        
    </div>
    
    
    
     
     <div class="panel panel-info">
        <div class="panel-heading">Liste des justificatifs donnés</div>
        <table class="table table-bordered table-responsive">
                    <?php
                    
                    $scandir = scandir(dirname(__FILE__,2)."/justificatif/".$_SESSION['idVisiteur']."/");
                    $rep=dirname(__FILE__,2)."/justificatif/".$_SESSION['idVisiteur']."/";
                    //echo $rep;
                    echo(dirname((__FILE__)));
                    $lien = dirname(__FILE__,2)."/justificatif";
                    foreach ($scandir as $fichier){
                    if($fichier == '.' || $fichier == '..')
                    {
                    }
                    else
                    {
                     
                    ?>
<!--                    <a href="<?php echo $rep.$fichier ?>/<?php echo $fichier ?>"><?php echo $fichier ?></a>-->
                    <a href="http://localhost:8081/dossexamenappligsb/e4p1gsb2020/justificatif/<?php echo $_SESSION['idVisiteur'] ?>/<?php echo $fichier ?>"><?php echo $fichier ?></a>
                   <a href="http://localhost:8081/dossexamenappligsb/e4p1gsb2020/efface.php?nomfich=<?php echo $rep.$fichier ?>" 
                           onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce justificatif</a>
                  
                    <?php
                    }
                    //echo $fichier;
                    }
                    ?>
        </table>
     </div>
    

  
</div>

<div class="row">
    <h3>Nouvel élément hors forfait</h3>
    <div class="col-md-4">
        <form action="index.php?uc=gererFrais&action=validerCreationFrais" enctype="multipart/form-data" 
              method="post" role="form">
            <div class="form-group">
                <label for="txtDateHF">Date (jj/mm/aaaa): </label>
                <input type="text" id="txtDateHF" name="dateFrais" 
                       class="form-control" id="text">
            </div>
            <!--<div class="form-group">
                <label for="txtDateHF">Date (jj/mm/aaaa): </label>
                <input type="date" id="txtDateHF" name="dateFrais" 
                       class="form-control" id="text">
            </div>-->
            <div class="form-group">
                <label for="txtLibelleHF">Libellé</label>             
                <input type="text" id="txtLibelleHF" name="libelle" 
                       class="form-control" id="text">
            </div> 
            <div class="form-group">
                <label for="txtMontantHF">Montant : </label>
                <div class="input-group">
                    <span class="input-group-addon">€</span>
                    <input type="text" id="txtMontantHF" name="montant" 
                           class="form-control" value="">
                </div>
            </div>

<!--            <button class="btn btn-success" type="submit">Ajouter</button>
            <button class="btn btn-danger" type="reset">Effacer</button>-->

<!--        </form>-->
        <!--partie upload du fichier à téléverser"-->
        <!--<form enctype="multipart/form-data" action="fileupload.php" method="post">-->
            <div class="form-group">
            <label for="Justificatif">Justificatif : </label>   
            </div>
        
            <div class="panel panel-info">
            <div class="panel-heading">Le Justificatif fourni :</div>
            <!--span class="input-group-addon">trombone</span>-->
                <table class="table table-bordered table-responsive">
                    <thead>
                      
                    </thead>
                    <tbody>
                        <tr>
                            <th>    
<!--                                    <div class="d-flex align-items-center justify-content-center p-3 py-5 mb-2 bg-light rounded" style="font-size: 2em">-->
                                    <svg class="bi bi-paperclip" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.5 3a2.5 2.5 0 015 0v9a1.5 1.5 0 01-3 0V5a.5.5 0 011 0v7a.5.5 0 001 0V3a1.5 1.5 0 10-3 0v9a2.5 2.5 0 005 0V5a.5.5 0 011 0v7a3.5 3.5 0 11-7 0V3z" clip-rule="evenodd"/>
                                    </svg>
                                    <!--</div>-->
                            </th>
                            <th>
                                <input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
                                <input type="file" name="monfichier"/>
                            </th>
<!--                            <th>
                            Transfère le fichier
                            
                            </th>-->
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--</div>-->
            <button class="btn btn-success" type="submit">Ajouter</button>
            <button class="btn btn-danger" type="reset">Effacer</button>
         </form>
    
    </div>
</div>

 