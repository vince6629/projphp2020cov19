<!DOCTYPE html>
<html>
    
<div class="panel panel-primary">
<div class="panel-heading">Fiche de frais de l'utilisateur
<?php if(isset($affnomutil))
    {
    echo (' : '.$affnomutil);      
    }
  ?>
</div>


<div class="panel panel-info">
    <div class="panel-heading">Eléments forfaitisés</div>
    <table class="table table-bordered table-responsive">
	
	<thead>
			
			<td>Date</td>
			<td>Montant total de la note de frais</td>
                        <td>Type de frais</td>
                        <td>Type de frais</td>
			<td>Etat</td>

	</thead>
	<tbody>
            
	<?php
        
        
	foreach($lesdatap as $unedatap)
	{	
		
//                      var_dump($lesdatap);
			
			echo "<tr><td>".$unedatap[0]."</td>";
                      
			echo "<td>".$unedatap[1]."</td>";
                        
                        echo "<td>".$unedatap[3]."</td>";
                        
                        echo "<td>".$unedatap[4]."</td>";
                       
			echo "<td>".$unedatap[2]."</td></tr>";
                        
                  
			

		
	}	
	?>
	</tbody>
    </table>
</div>
 






