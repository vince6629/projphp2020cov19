<?php
/**
 * Vue État de Frais
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
<div class="panel panel-primary">
    <div class="panel-heading">Fiche de frais du mois (admin) 
        <?php echo $numMois . '-' . $numAnnee ?> : </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
        depuis le <?php echo $dateModif ?> <br> 
        <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Eléments forfaitisés</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle']; ?>
                <th> <?php echo htmlspecialchars($libelle) ?></th>
                <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite']; ?>
                <td class="qteForfait"><?php echo $quantite ?> </td>
                <?php
            }
            ?>
        </tr>
    </table>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Descriptif des éléments hors forfait - 
        <?php echo $nbJustificatifs ?> justificatifs reçus</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>                
        </tr>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
            $montant = $unFraisHorsForfait['montant']; ?>
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

<table class="table table-bordered table-responsive">
	
	<thead>	
			<td>Montant - hors frais - à valider</td>
                        <td>Total repas</td>
                        <td>Total nuit</td>
                        <td>total KM</td>
                        <td>total ETP</td>
                        <td>Total </td>
	</thead>
	<tbody>
            
	<?php
	foreach($tabb1 as $ta1)
	{	
			echo "<tr><td>".$ta1[0]."</td>";
                        $totalhorsfrais=$ta1[0];
	}
        foreach($tabb2 as $ta2)
	{	
			echo "<td>".$ta2[0]."</td>";
                        $totalrepas=$ta2[0];
	}
         foreach($tabb3 as $ta3)
	{	
			echo "<td>".$ta3[0]."</td>";
                        $totalnuit=$ta3[0];
	}
          foreach($tabb4 as $ta4)
	{	
			echo "<td>".$ta4[0]."</td>";
                        $totalkm=$ta4[0];
	}
           foreach($tabb5 as $ta5)
	{	
			echo "<td>".$ta5[0]."</td>";
                        $totaletp=$ta5[0];
	}
        
        $totalg=$totalhorsfrais+$totalrepas+$totalkm+$totaletp;
        
        echo "<td>".$totalg."</td></tr>";
	?>
            
            
            
            
	</tbody>
</table>
<form action="vv1.php?" method="post">
         <p>
            
            <input type="hidden" name="valeur1" value="<?php echo $iduser?>" />
            <input type="hidden" name="valeur2" value="<?php echo $moisASelectionner?>" />
            <input type="hidden" name="valeur3" value="<?php echo $totalg?>" />
        
            <input type="submit" value="Valider" />
            
         </p>
            
</form>