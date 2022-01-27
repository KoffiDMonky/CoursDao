<?php

class daoImplAuteurPDO implements daoAuteur {

    
    private $db; //Instance de PDO
    private $auteurs; //tableau de auteurs

    function __construct($db, $auteurs) {
    	$this->db = $db;
    	$this->auteurs = $auteurs;
    
    }

   /**
    * Ajoute un Auteur à la liste d'auteurs
    * @param Auteur $auteur
    */
    public function ajoutAuteur(Auteur $auteur):void
    {
        $this->auteurs[] = $auteur;
    } 

    /**
    * Retourne tous les auteurs de la liste
    * 
    */
    
    public function getAuteurs(){
        return $this->auteurs;
    }

    /**
    * Charge tous les auteurs contenu dans la BDD dans le tableau de auteurs
    * 
    */

    public function chargementAuteurs():void 
    {

        //On prépare la requête que permet de récupérer toutes les auteurs présentent en base de données
        $sql = "SELECT * FROM auteur;";
        $req = $this->db->prepare($sql);
        //Puis on l'exécute
        $req->execute();
        //On stock et mets en forme le résultat dans $mesAuteurs
        $mesAuteurs = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();

        //On créé les auteurs et on les ajoute dans le tableau "Auteurs"
        foreach($mesAuteurs as $auteur){
            $p = new Auteur($auteur['idAuteur'],$auteur['oeuvre']);
            $this->ajoutAuteur($p);
        }
    }

    
    /**
    * Récupérer un auteur via son identifiant
    * @param Auteur $idAuteur
    */

    public function getAuteurById(Auteur $idAuteur){
        for($i=0; $i < count($this->auteurs);$i++){
            if($this->auteurs[$i]->getId() === $idAuteur){
                return $this->livres[$i];
            }
        }
    }

    /**
    * Rajoute une auteur dans la base de données
    * @param Auteur $auteur
    */

    public function ajoutAuteurBd(Auteur $auteur):void 
    {
        
        //On prépare la requête qui permet d'insérer notre nouvelle auteur dans la base de données
        $sql = "INSERT INTO auteur (nomAuteur) values (:nomAuteur)";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":nomAuteur",$auteur->getNomAuteur(),PDO::PARAM_STR);
        
        //On exécute la requête permettant d'insérer les données
        $resultat = $req->execute();

        // On vérifie que la requête a bien fonctionnée et on ajoute la nouvelle auteur dans la liste de auteur
        if($resultat > 0){ 
            $auteur = new Auteur($this->db->lastInsertId(),$auteur['nomAuteur']);
            $this->ajoutAuteur($auteur);

        }

    }

    /**
    * Supprime un auteur dans la base de données
    * @param Auteur $idAuteur
    */
    
    public function suppressionAuteurBD(Auteur $idAuteur){

        //On prépare la requête qui permet de supprimer une auteur filtré par son id
        $sql = " DELETE from auteur where id = :idAuteur";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":idAuteur",$idAuteur->getIdAuteur(),PDO::PARAM_INT);

        //On exécute la requête permettant d'insérer les données
        $resultat = $req->execute();
        $req->closeCursor();

         // On vérifie que la requête a bien fonctionnée et on supprime la nouvelle auteur dans la liste de auteurs
        if($resultat > 0){
            $auteur = $this->getAuteurById($idAuteur);
            unset($auteur);
        }
    }

    /**
    * Modifie un auteur dans la base de données
    * @param Auteur $idAuteur
    */
    //

    function modificationAuteurBD(Auteur $auteur, Auteur $idAuteur){
        
        $sql = "UPDATE auteur SET nomAuteur = :nomAuteur WHERE idAuteur = :idAuteur";
        $req = $this->db->prepare($sql);
        $req->bindValue(":nomAuteur",$auteur->getNomAuteur(),PDO::PARAM_STR);
        $req->bindValue(":idAuteur",$auteur->getIdAuteur(),PDO::PARAM_INT);

        $resultat = $req->execute();
        $req->closeCursor();

        if($resultat > 0){
            $this->getAuteurById($idAuteur)->setNomAuteur($auteur->getNomAuteur());
        }
    }
}
