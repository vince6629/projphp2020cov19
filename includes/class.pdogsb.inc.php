<?php
/**
 * Classe d'accès aux données.
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL - CNED <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */

/**
 * Classe d'accès aux données.
 *
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO
 * $monPdoGsb qui contiendra l'unique instance de la classe
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Cheri Bibi - Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   Release: 1.0
 * @link      http://www.php.net/manual/fr/book.pdo.php PHP Data Objects sur php.net
 */

class PdoGsb
{
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=gsb_frais';
    private static $user = 'userGsb';
    private static $mdp = 'secret';
    private static $monPdo;
    private static $monPdoGsb = null;
   

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {
        PdoGsb::$monPdo = new PDO(
            PdoGsb::$serveur . ';' . PdoGsb::$bdd,
            PdoGsb::$user,
            PdoGsb::$mdp
        );
        PdoGsb::$monPdo->query('SET CHARACTER SET utf8');
    }

    /**
     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
     */
    public function __destruct()
    {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     *
     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb()
    {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * Retourne les informations d'un visiteur
     *
     * @param String $login Login du visiteur
     * @param String $mdp   Mot de passe du visiteur
     *
     * @return l'id, le nom et le prénom sous la forme d'un tableau associatif
     */
    public function getInfosVisiteur($login, $mdp)
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT visiteur.id AS id, visiteur.nom AS nom, '
            . 'visiteur.prenom AS prenom, visiteur.cat AS cat '
            . 'FROM visiteur '
            . 'WHERE visiteur.login = :unLogin AND visiteur.mdp = :unMdp'
        );
        $requetePrepare->bindParam(':unLogin', $login, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMdp', $mdp, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetch();
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais
     * hors forfait concernées par les deux arguments.
     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return tous les champs des lignes de frais hors forfait sous la forme
     * d'un tableau associatif
     */
    public function getLesFraisHorsForfait($idVisiteur, $mois)
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT * FROM lignefraishorsforfait '
            . 'WHERE lignefraishorsforfait.idvisiteur = :unIdVisiteur '
            . 'AND lignefraishorsforfait.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesLignes = $requetePrepare->fetchAll();
        for ($i = 0; $i < count($lesLignes); $i++) {
            $date = $lesLignes[$i]['date'];
            $lesLignes[$i]['date'] = dateAnglaisVersFrancais($date);
        }
        return $lesLignes;
    }

    /**
     * Retourne le nombre de justificatif d'un visiteur pour un mois donné
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return le nombre entier de justificatifs
     */
    public function getNbjustificatifs($idVisiteur, $mois)
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT fichefrais.nbjustificatifs as nb FROM fichefrais '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne['nb'];
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais
     * au forfait concernées par les deux arguments
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return l'id, le libelle et la quantité sous la forme d'un tableau
     * associatif
     */
    public function getLesFraisForfait($idVisiteur, $mois)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT fraisforfait.id as idfrais, '
            . 'fraisforfait.libelle as libelle, '
            . 'lignefraisforfait.quantite as quantite '
            . 'FROM lignefraisforfait '
            . 'INNER JOIN fraisforfait '
            . 'ON fraisforfait.id = lignefraisforfait.idfraisforfait '
            . 'WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
            . 'AND lignefraisforfait.mois = :unMois '
            . 'ORDER BY lignefraisforfait.idfraisforfait'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

    /**
     * Retourne tous les id de la table FraisForfait
     *
     * @return un tableau associatif
     */
    public function getLesIdFrais()
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT fraisforfait.id as idfrais '
            . 'FROM fraisforfait ORDER BY fraisforfait.id'
        );
        $requetePrepare->execute();
        return $requetePrepare->fetchAll();
    }

    /**
     * Met à jour la table ligneFraisForfait
     * Met à jour la table ligneFraisForfait pour un visiteur et
     * un mois donné en enregistrant les nouveaux montants
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param Array  $lesFrais   tableau associatif de clé idFrais et
     *                           de valeur la quantité pour ce frais
     *
     * @return null
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais)
    {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $requetePrepare = PdoGSB::$monPdo->prepare(
                'UPDATE lignefraisforfait '
                . 'SET lignefraisforfait.quantite = :uneQte '
                . 'WHERE lignefraisforfait.idvisiteur = :unIdVisiteur '
                . 'AND lignefraisforfait.mois = :unMois '
                . 'AND lignefraisforfait.idfraisforfait = :idFrais'
            );
            $requetePrepare->bindParam(':uneQte', $qte, PDO::PARAM_INT);
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->bindParam(':idFrais', $unIdFrais, PDO::PARAM_STR);
            $requetePrepare->execute();
        }
    }

    /**
     * Met à jour le nombre de justificatifs de la table ficheFrais
     * pour le mois et le visiteur concerné
     *
     * @param String  $idVisiteur      ID du visiteur
     * @param String  $mois            Mois sous la forme aaaamm
     * @param Integer $nbJustificatifs Nombre de justificatifs
     *
     * @return null
     */
    public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs)
    {
        $requetePrepare = PdoGB::$monPdo->prepare(
            'UPDATE fichefrais '
            . 'SET nbjustificatifs = :unNbJustificatifs '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(
            ':unNbJustificatifs',
            $nbJustificatifs,
            PDO::PARAM_INT
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return vrai ou faux
     */
    public function estPremierFraisMois($idVisiteur, $mois)
    {
        $boolReturn = false;
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT fichefrais.mois FROM fichefrais '
            . 'WHERE fichefrais.mois = :unMois '
            . 'AND fichefrais.idvisiteur = :unIdVisiteur'
        );
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        if (!$requetePrepare->fetch()) {
            $boolReturn = true;
        }
        return $boolReturn;
    }

    /**
     * Retourne le dernier mois en cours d'un visiteur
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return le mois sous la forme aaaamm
     */
    public function dernierMoisSaisi($idVisiteur)
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT MAX(mois) as dernierMois '
            . 'FROM fichefrais '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        $dernierMois = $laLigne['dernierMois'];
        return $dernierMois;
    }

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait
     * pour un visiteur et un mois donnés
     *
     * Récupère le dernier mois en cours de traitement, met à 'CL' son champs
     * idEtat, crée une nouvelle fiche de frais avec un idEtat à 'CR' et crée
     * les lignes de frais forfait de quantités nulles
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return null
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois)
    {
        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'INSERT INTO fichefrais (idvisiteur,mois,nbjustificatifs,'
            . 'montantvalide,datemodif,idetat) '
            . "VALUES (:unIdVisiteur,:unMois,0,0,now(),'CR')"
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesIdFrais = $this->getLesIdFrais();
        foreach ($lesIdFrais as $unIdFrais) {
            $requetePrepare = PdoGsb::$monPdo->prepare(
                'INSERT INTO lignefraisforfait (idvisiteur,mois,'
                . 'idfraisforfait,quantite) '
                . 'VALUES(:unIdVisiteur, :unMois, :idFrais, 0)'
            );
            $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
            $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
            $requetePrepare->bindParam(
                ':idFrais',
                $unIdFrais['idfrais'],
                PDO::PARAM_STR
            );
            $requetePrepare->execute();
        }
    }

    /**
     * Crée un nouveau frais hors forfait pour un visiteur un mois donné
     * à partir des informations fournies en paramètre
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $libelle    Libellé du frais
     * @param String $date       Date du frais au format français jj//mm/aaaa
     * @param Float  $montant    Montant du frais
     *
     * @return null
     */
    public function creeNouveauFraisHorsForfait(
        $idVisiteur,
        $mois,
        $libelle,
        $date,
        $montant
    ) {
        $dateFr = dateFrancaisVersAnglais($date);
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'INSERT INTO lignefraishorsforfait '
            . 'VALUES (null, :unIdVisiteur,:unMois, :unLibelle, :uneDateFr,'
            . ':unMontant) '
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unLibelle', $libelle, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uneDateFr', $dateFr, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMontant', $montant, PDO::PARAM_INT);
        $requetePrepare->execute();
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument
     *
     * @param String $idFrais ID du frais
     *
     * @return null
     */
    public function supprimerFraisHorsForfait($idFrais)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'DELETE FROM lignefraishorsforfait '
            . 'WHERE lignefraishorsforfait.id = :unIdFrais'
        );
        $requetePrepare->bindParam(':unIdFrais', $idFrais, PDO::PARAM_STR);
        $requetePrepare->execute();
    }

    /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais
     *
     * @param String $idVisiteur ID du visiteur
     *
     * @return un tableau associatif de clé un mois -aaaamm- et de valeurs
     *         l'année et le mois correspondant
     */
    public function getLesMoisDisponibles($idVisiteur)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT fichefrais.mois AS mois FROM fichefrais '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'ORDER BY fichefrais.mois desc'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesMois = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois[] = array(
                'mois' => $mois,
                'numAnnee' => $numAnnee,
                'numMois' => $numMois
            );
        }
        return $lesMois;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un
     * mois donné
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     *
     * @return un tableau avec des champs de jointure entre une fiche de frais
     *         et la ligne d'état
     */
    public function getLesInfosFicheFrais($idVisiteur, $mois)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT fichefrais.idetat as idEtat, '
            . 'fichefrais.datemodif as dateModif,'
            . 'fichefrais.nbjustificatifs as nbJustificatifs, '
            . 'fichefrais.montantvalide as montantValide, '
            . 'etat.libelle as libEtat '
            . 'FROM fichefrais '
            . 'INNER JOIN etat ON fichefrais.idetat = etat.id '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $laLigne = $requetePrepare->fetch();
        return $laLigne;
    }

    /**
     * Modifie l'état et la date de modification d'une fiche de frais.
     * Modifie le champ idEtat et met la date de modif à aujourd'hui.
     *
     * @param String $idVisiteur ID du visiteur
     * @param String $mois       Mois sous la forme aaaamm
     * @param String $etat       Nouvel état de la fiche de frais
     *
     * @return null
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'UPDATE ficheFrais '
            . 'SET idetat = :unEtat, datemodif = now() '
            . 'WHERE fichefrais.idvisiteur = :unIdVisiteur '
            . 'AND fichefrais.mois = :unMois'
        );
        $requetePrepare->bindParam(':unEtat', $etat, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unIdVisiteur', $idVisiteur, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unMois', $mois, PDO::PARAM_STR);
        $requetePrepare->execute();
    }
    
    //en dessous mes fonctions
    
   function gettable()
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT visiteur.id AS id, visiteur.nom AS nom, '
            . 'visiteur.prenom AS prenom, visiteur.cat AS cat '
            . 'FROM visiteur '
            
        );
       
        $requetePrepare->execute();
        
        return $requetePrepare->fetchall();
        
    }
    
    public function getlistedefrais ($iduser,$leMois)
            
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT fichefrais.mois,fichefrais.montantvalide,fichefrais.idetat,lignefraisforfait.idfraisforfait,lignefraisforfait.quantite FROM fichefrais '
           . 'inner join lignefraisforfait on fichefrais.idvisiteur=lignefraisforfait.idvisiteur and fichefrais.mois=lignefraisforfait.mois '     
           . 'WHERE fichefrais.idvisiteur = :unidpers and fichefrais.mois = :leMois '
            
        );
        $requetePrepare->bindParam(':unidpers', $iduser, PDO::PARAM_STR);
        $requetePrepare->bindParam(':leMois', $leMois, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesdatap = array();
        $lesdatap = $requetePrepare->fetchall();
        return $lesdatap;
    }
    
    
    public function getutilisateur ()       
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
               'SELECT visiteur.Id, visiteur.nom, visiteur.prenom, visiteur.cp, visiteur.ville FROM visiteur '   
        );
//        $requetePrepare->bindParam(':nom', $A, PDO::PARAM_STR);
        $requetePrepare->execute();
        $lesdata = array();
        $lesdata = $requetePrepare->fetchall();
        return $lesdata;
    }
    
    public function getutilisateurx ($idz_1)       
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
               'SELECT visiteur.nom FROM visiteur '
             . 'WHERE visiteur.id = :aidnom '
        );
        $requetePrepare->bindParam(':aidnom', $idz_1, PDO::PARAM_STR);
        $requetePrepare->execute();
//        $ladatauti = array();
//        $ladatauti = $requetePrepare->fetchall();
        return $requetePrepare->fetch();
//        return $ladatauti;
    }
    
    public function getLesMoisDisponiblesspe()
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT distinct fichefrais.mois AS mois FROM fichefrais '
            . 'WHERE fichefrais.idetat = "CR" '
            . 'ORDER BY fichefrais.mois desc'
        );
         
        
        $requetePrepare->execute();
        $lesMois = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois[] = array(
                'mois' => $mois,
                'numAnnee' => $numAnnee,
                'numMois' => $numMois
            );
        }
        return $lesMois;
    }

 public function getLesMoisDisponiblesspe2($idz)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT distinct fichefrais.mois AS mois FROM fichefrais '
            . 'WHERE fichefrais.idetat = "CR" and fichefrais.idvisiteur = :unidpers '
            . 'ORDER BY fichefrais.mois desc'
            
        );
        $requetePrepare->bindParam(':unidpers', $idz, PDO::PARAM_STR);
        
        $requetePrepare->execute();
        $lesMois = array();
        while ($laLigne = $requetePrepare->fetch()) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois[] = array(
                'mois' => $mois,
                'numAnnee' => $numAnnee,
                'numMois' => $numMois
            );
        }
        return $lesMois;
    }
   
//ok
    
    public function mval($idsuser,$ms,$ttg)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'UPDATE ficheFrais '
            . 'SET idetat ="CL", montantvalide= :ttg, datemodif = now() '
            . 'WHERE fichefrais.idvisiteur = :unIdu '
            . 'AND fichefrais.mois = :unms '
        );
        
        $requetePrepare->bindParam(':unIdu', $idsuser, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unms', $ms, PDO::PARAM_STR);
        $requetePrepare->bindParam(':ttg', $ttg, PDO::PARAM_INT);
        $requetePrepare->execute();
    }
    
    public function mval1($userselection,$moisASelectionner)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT sum(lignefraishorsforfait.montant) FROM lignefraishorsforfait '
            . 'WHERE lignefraishorsforfait.idvisiteur = :unIdu '
            . 'AND lignefraishorsforfait.mois = :unms '
        );
        
        $requetePrepare->bindParam(':unIdu', $userselection, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unms', $moisASelectionner, PDO::PARAM_STR);
        $requetePrepare->execute();
        $tab1=array();
        $tab1 = $requetePrepare->fetchall();
               
        return $tab1;
        
        
    }
    
    public function mval2($userselection,$moisASelectionner)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT sum(lignefraisforfait.quantite*25) FROM lignefraisforfait '
            . 'WHERE lignefraisforfait.idvisiteur = :unIdu '
            . 'AND lignefraisforfait.mois = :unms '
            . 'AND lignefraisforfait.idfraisforfait = "REP" '
        );
        
        $requetePrepare->bindParam(':unIdu', $userselection, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unms', $moisASelectionner, PDO::PARAM_STR);
        $requetePrepare->execute();
        $tab2=array();
        $tab2 = $requetePrepare->fetchall();
               
        return $tab2;
        
        
    }
    
    public function mval3($userselection,$moisASelectionner)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT sum(lignefraisforfait.quantite*80) FROM lignefraisforfait '
            . 'WHERE lignefraisforfait.idvisiteur = :unIdu '
            . 'AND lignefraisforfait.mois = :unms '
            . 'AND lignefraisforfait.idfraisforfait = "NUI" '
        );
        
        $requetePrepare->bindParam(':unIdu', $userselection, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unms', $moisASelectionner, PDO::PARAM_STR);
        $requetePrepare->execute();
        $tab3=array();
        $tab3 = $requetePrepare->fetchall();
               
        return $tab3;
        
        
    }
    public function mval4($userselection,$moisASelectionner)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT sum(lignefraisforfait.quantite*0.62) FROM lignefraisforfait '
            . 'WHERE lignefraisforfait.idvisiteur = :unIdu '
            . 'AND lignefraisforfait.mois = :unms '
            . 'AND lignefraisforfait.idfraisforfait = "KM" '
        );
        
        $requetePrepare->bindParam(':unIdu', $userselection, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unms', $moisASelectionner, PDO::PARAM_STR);
        $requetePrepare->execute();
        $tab4=array();
        $tab4 = $requetePrepare->fetchall();
               
        return $tab4;
        
        
    }
    public function mval5($userselection,$moisASelectionner)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT sum(lignefraisforfait.quantite*110) FROM lignefraisforfait '
            . 'WHERE lignefraisforfait.idvisiteur = :unIdu '
            . 'AND lignefraisforfait.mois = :unms '
            . 'AND lignefraisforfait.idfraisforfait = "ETP" '
        );
        
        $requetePrepare->bindParam(':unIdu', $userselection, PDO::PARAM_STR);
        $requetePrepare->bindParam(':unms', $moisASelectionner, PDO::PARAM_STR);
        $requetePrepare->execute();
        $tab5=array();
        $tab5 = $requetePrepare->fetchall();
               
        return $tab5;
        
        
    }
    
    //fonction supplémentaire
    
    function getutilisateurfichemodifiable()
    {
        $requetePrepare = PdoGsb::$monPdo->prepare(
            'SELECT distinct visiteur.id AS id, visiteur.nom AS nom, '
            . 'visiteur.prenom AS prenom, visiteur.cat AS cat '
            . 'FROM visiteur inner join fichefrais on fichefrais.idvisiteur=visiteur.id '
            . 'where fichefrais.idetat = "CR"  '
            
        );
       
        $requetePrepare->execute();
        
        return $requetePrepare->fetchall();
        
    }
    
    public function gettablelignedefrais ($iu1,$iu1_s1)
            
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT idvisiteur,mois,idfraisforfait,quantite FROM lignefraisforfait where lignefraisforfait.idvisiteur = :uniu1 '
          . 'AND lignefraisforfait.mois = :uniu1_s1 '
        );
        $requetePrepare->bindParam(':uniu1', $iu1, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uniu1_s1', $iu1_s1, PDO::PARAM_STR);
        $requetePrepare->execute();
        $tablelignedefraisr = array();
        $tablelignedefraisr = $requetePrepare->fetchall();
        return $tablelignedefraisr;
    }
    
     public function gettablelignedefraishorsforfait ($iu1,$iu1_s1)
            
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT idvisiteur,mois,libelle,date,montant FROM lignefraishorsforfait where lignefraishorsforfait.idvisiteur = :uniu1 '
          . 'AND lignefraishorsforfait.mois = :uniu1_s1 '
        );
        $requetePrepare->bindParam(':uniu1', $iu1, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uniu1_s1', $iu1_s1, PDO::PARAM_STR);
        $requetePrepare->execute();
        $tablelignedefraisr2 = array();
        $tablelignedefraisr2 = $requetePrepare->fetchall();
        return $tablelignedefraisr2;
    }
    
     public function getLesMoisDisponibles_m()
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT distinct fichefrais.mois AS mois FROM fichefrais '
            . 'where fichefrais.idetat ="CR" '
            . 'ORDER BY fichefrais.mois desc '
        );
        
        $requetePrepare->execute();
        $lesMois_m = array();
        while ($laLigne_m = $requetePrepare->fetch()) {
            $mois_m = $laLigne_m['mois'];
            $numAnnee_m = substr($mois_m, 0, 4);
            $numMois_m = substr($mois_m, 4, 2);
            $lesMois_m[] = array(
                'mois' => $mois_m,
                'numAnnee' => $numAnnee_m,
                'numMois' => $numMois_m
            );
        }
        return $lesMois_m;
    }
    
     public function gettablelignedefraisprecis ($iu1, $iu1_s1,$achamp3)
            
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT idvisiteur,mois,idfraisforfait,quantite FROM lignefraisforfait where idvisiteur = :uniu1 and mois = :uniu1_s1 and idfraisforfait = :typedefrais '
        );
        $requetePrepare->bindParam(':uniu1', $iu1, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uniu1_s1',  $iu1_s1, PDO::PARAM_STR);
        $requetePrepare->bindParam(':typedefrais', $achamp3, PDO::PARAM_STR);
        $requetePrepare->execute();
//        $tablelignedefraisr = array();
        $tablelignedefraisr = $requetePrepare->fetchall();
        return $tablelignedefraisr;
    }
    
    public function modiftablelignedefraisprecis($iu1,$iu1_s1,$achamp3,$achamp4)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'UPDATE lignefraisforfait '
            . 'SET quantite = :quantite '
            . 'WHERE lignefraisforfait.idvisiteur = :uniu1 and mois = :uniu1_s1 and idfraisforfait = :typedefrais '
        );
        
        $requetePrepare->bindParam(':uniu1', $iu1, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uniu1_s1', $iu1_s1, PDO::PARAM_STR);
        $requetePrepare->bindParam(':typedefrais', $achamp3, PDO::PARAM_STR);
        $requetePrepare->bindParam(':quantite', $achamp4, PDO::PARAM_INT);
        $requetePrepare->execute();
    }
    
      public function gettablelignedefraisprecishf ($iu1_2, $iu1_s1_2,$achamp3hf,$achamp4hf)
            
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'SELECT idvisiteur,mois,libelle,date,montant FROM lignefraishorsforfait where idvisiteur = :uniu1 and mois = :uniu1_s1 and libelle = :libellefrais and date = :datehf'
        );
        $requetePrepare->bindParam(':uniu1', $iu1_2, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uniu1_s1',  $iu1_s1_2, PDO::PARAM_STR);
        $requetePrepare->bindParam(':libellefrais', $achamp3hf, PDO::PARAM_STR);
         $requetePrepare->bindParam(':datehf', $achamp4hf, PDO::PARAM_STR);
        $requetePrepare->execute();
//        $tablelignedefraisr = array();
        $tablelignedefraishfr = $requetePrepare->fetchall();
        return $tablelignedefraishfr;
    }
    
       public function modiftablelignedefraisprecishf($iu1_2,$iu1_s1_2,$achamp3hf,$achamp4hf,$achamp5hf)
    {
        $requetePrepare = PdoGSB::$monPdo->prepare(
            'UPDATE lignefraishorsforfait '
            . 'SET montant = :montant '
            . 'WHERE lignefraishorsforfait.idvisiteur = :uniu1 and mois = :uniu1_s1 and libelle = :libellefrais and date = :datehf '
        );
        
        $requetePrepare->bindParam(':uniu1', $iu1_2, PDO::PARAM_STR);
        $requetePrepare->bindParam(':uniu1_s1', $iu1_s1_2, PDO::PARAM_STR);
        $requetePrepare->bindParam(':libellefrais', $achamp3hf, PDO::PARAM_STR);
        $requetePrepare->bindParam(':datehf', $achamp4hf, PDO::PARAM_STR);
        $requetePrepare->bindParam(':montant', $achamp5hf, PDO::PARAM_INT);
        $requetePrepare->execute();
    }

    // fonction en option
    
    public function test()
    {
       $testa="aaa";
       return $testa; 
    }
}
