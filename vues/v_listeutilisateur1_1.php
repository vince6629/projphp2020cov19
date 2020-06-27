<!DOCTYPE html>
<html>
    

    
<div class="panel panel-primary">
<div class="panel-heading">Fiche de frais de l'utilisateur</div>


<div class="panel panel-info">
    <div class="panel-heading">Liste</div>   

    
                
    <div class="col-md-4">
        
        <form action="index.php?uc=admin1&action=cas1"
              method="post" role="form">
            <div class="form-group">
                <label for="listeexcep" accesskey="n">1er étape / Selection de l'utilisateur : </label>
            <select id="listeexcep" name="listeexcep" class="form-control">
                

                                   

            <?php
//                            
     
 
                           
                    foreach ($tableutilisateur as $tableutilisateu)
                    {
                           
                                
                                
                            
                            
                                ?>
                          
                                <option selected value="<?php echo $tableutilisateu[0] ?>">                     
                                    <?php
                                    
                                    echo ($tableutilisateu[1])
                                    ?>
                                    
                                </option>
                                <?php
                            
                               
                    }
 
 
              
                    ?>
            </select>
        </div>
<!--            <input id="ok" type="submit" value="Valider" name="boutton1" class="btn btn-success" 
                   role="button">
        </form>-->

    </div>
    <div class="col-md-4">
<!--        <form action="index.php?uc=admin1&action=cas1"
              method="post" role="form">-->
            <div class="form-group">
                <label for="listeexcep_s1" accesskey="n">2ième étape / Selection du mois : </label>
            <select id="listeexcep" name="listeexcep_s1" class="form-control">
                

                                   

            <?php
//                            
     
 
                           
                    foreach ($tablesMois_m as $tablesMois_ml)
                    {
                           
                                
                                
                            
                            
                                ?>
                          
                                <option selected value="<?php echo $tablesMois_ml['mois'] ?>">                     
                                    <?php
                                    
                                    echo ($tablesMois_ml['mois'])
                                    ?>
                                    
                                </option>
                                <?php
                            
                               
                    }
 
 
              
                    ?>
            </select>
        </div>
            <input id="ok" type="submit" value="Valider" name="boutton1" class="btn btn-success" 
                   role="button">
        </form>

        
        
        
        
        
    </div>
    
    
</div>
 






