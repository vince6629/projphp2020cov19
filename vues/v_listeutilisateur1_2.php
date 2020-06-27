<!DOCTYPE html>
<html>
    

    
<div class="panel panel-primary">
<div class="panel-heading">Fiche de frais forfait de l'utilisateur</div>


<div class="panel panel-info">
    <div class="panel-heading">Liste mensuelle</div>   

    <table class="table table-bordered table-responsive">
	<thead>
			
			<td>Id Visiteur</td>
			<td>Mois</td>
                        <td>Idfraisforfait</td>
                        <td>Quantite</td>
			<td>Etat</td>

	</thead>
	<tbody>
        <?php
        if ($testaffich=='1')
        {
        ?>
        
          
	<?php
                
	foreach($tablelignedefrais as $tablelignedefraisd)
	{	
			
        ?>
            
                
                <form action="index.php?uc=admin1&action=cas2" method="post"> 
                <tr>
                <td><?php echo(''.$tablelignedefraisd[0].'') ?></td>
                <td><?php echo(''.$tablelignedefraisd[1].'') ?></td>
                <td><?php echo(''.$tablelignedefraisd[2].'') ?></td>
                <td><?php echo(''.$tablelignedefraisd[3].'') ?></td>
                <td>
                <input type="hidden" name="valeuriu1ligne1" value="<?php echo $tablelignedefraisd[0]?>" />
                <input type="hidden" name="valeuriu1ligne2" value="<?php echo $tablelignedefraisd[1]?>" />
                <input type="hidden" name="valeuriu1ligne3" value="<?php echo $tablelignedefraisd[2]?>" />
                <input type="hidden" name="valeuriu1ligne4" value="<?php echo $tablelignedefraisd[3]?>" />
                
                <input type="hidden" name="valeuriu1" value="<?php echo $iu1?>" />
                <input type="hidden" name="valeuriu1_s1" value="<?php echo $iu1_s1?>" />
                <input type="hidden" name="t_frais" value="f1" />
                <input type="submit" value="Modifier"/></form></td>
                </tr>
                
                
        <?php
        }
        ?>
    
        <?php
        }
        else
        {
        ?>
        
        <?php   
            
            if ($tfrais=='f1')
            {
        ?>
        
                
                <form action="index.php?uc=admin1&action=cas3" method="post">
                <tr>
                <td><input type="text" name="champm1" value="<?php echo(''.$iu1ligne1.'') ?>"/></td>
                <td><input type="text" name="champm2" value="<?php echo(''.$iu1ligne2.'') ?>"/></td>
                <td><input type="text" name="champm3" value="<?php echo(''.$iu1ligne3.'') ?>"/></td>
                <td><input type="text" name="champm4" value="<?php echo(''.$iu1ligne4.'') ?>"/></td>
                <td>
                <input type="hidden" name="valeuriu1" value="<?php echo $iu1?>" />
                <input type="hidden" name="valeuriu1_s1" value="<?php echo $iu1_s1?>" />

                <input type="submit" value="valider"/></form></td>
                </tr>
            
            
            
         <?php
            }
                
             
         ?>
        
        <?php
	}	
	?>
         
	</tbody>
        
    </table>
    
    
    <table class="table table-bordered table-responsive">
        <thead></thead>
    </table>
    
    <table class="table table-bordered table-responsive">
        
    <div class="panel panel-primary">
    <div class="panel-heading">Fiche de frais hors forfait de l'utilisateur</div>


        <div class="panel panel-info">
        <div class="panel-heading">Liste mensuelle</div> 
     <thead>
			
			<td>Id Visiteur</td>
			<td>Mois</td>
                        <td>Libelle</td>
                        <td>Date</td>
			<td>Montant</td>

	</thead>   
        <tbody>
        <?php
        if ($testaffich=='1')
        {
            echo 'cas hors forfait'
        ?>
         
          
	<?php
                
	foreach($tablelignedefraishorsforfait as $tablelignedefraishorsforfaitd)
	{	
			
        ?>
            
                
                <form action="index.php?uc=admin1&action=cas2" method="post"> 
                <tr>
                <td><?php echo(''.$tablelignedefraishorsforfaitd[0].'') ?></td>
                <td><?php echo(''.$tablelignedefraishorsforfaitd[1].'') ?></td>
                <td><?php echo(''.$tablelignedefraishorsforfaitd[2].'') ?></td>
                <td><?php echo(''.$tablelignedefraishorsforfaitd[3].'') ?></td>
                <td><?php echo(''.$tablelignedefraishorsforfaitd[4].'') ?></td>
                <td>
                <input type="hidden" name="valeuriu1hfligne1" value="<?php echo $tablelignedefraishorsforfaitd[0]?>" />
                <input type="hidden" name="valeuriu1hfligne2" value="<?php echo $tablelignedefraishorsforfaitd[1]?>" />
                <input type="hidden" name="valeuriu1hfligne3" value="<?php echo $tablelignedefraishorsforfaitd[2]?>" />
                <input type="hidden" name="valeuriu1hfligne4" value="<?php echo $tablelignedefraishorsforfaitd[3]?>" />
                <input type="hidden" name="valeuriu1hfligne5" value="<?php echo $tablelignedefraishorsforfaitd[4]?>" />
                
                <input type="hidden" name="valeuriu1" value="<?php echo $iu1?>" />
                <input type="hidden" name="valeuriu1_s1" value="<?php echo $iu1_s1?>" />
                <input type="hidden" name="t_frais" value="f2" />
                <input type="submit" value="Modifier"/></form></td>
                </tr>
            <?php    
            }
            
        }
        
        else
        {
        ?>
        
        <?php   
            if ($tfrais=='f2')
            {
            
        ?>   
                <form action="index.php?uc=admin1&action=cas4" method="post">
                <tr>
                <td><input type="text" name="champm1hf" value="<?php echo(''.$iu1hfligne1.'') ?>"/></td>
                <td><input type="text" name="champm2hf" value="<?php echo(''.$iu1hfligne2.'') ?>"/></td>
                <td><input type="text" name="champm3hf" value="<?php echo(''.$iu1hfligne3.'') ?>"/></td>
                <td><input type="text" name="champm4hf" value="<?php echo(''.$iu1hfligne4.'') ?>"/></td>
                <td><input type="text" name="champm5hf" value="<?php echo(''.$iu1hfligne5.'') ?>"/></td>
                <td>
                <input type="hidden" name="2valeuriu1" value="<?php echo $iu1?>" />
                <input type="hidden" name="2valeuriu1_s1" value="<?php echo $iu1_s1?>" />

                <input type="submit" value="valider"/></form></td>
                </tr>
            
            
            
         <?php
            }
             
         ?>
       
        <?php
	}	
	?>
        </tbody>
        
        
    </table>
</div>
 






