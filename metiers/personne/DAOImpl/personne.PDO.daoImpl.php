<?php


class daoImplPersonnePDO implements daoPersonne {

    private $db; //Instance de PDO
    private $personnes; //tableau de personnes

    function __construct($db, $personnes) {
    	$this->db = $db;
    	$this->personnes = $personnes;
    
    }

    
    /**
    * Ajoute une personne à la liste de personnes
    * @param Personne $idPersonne
    */ 

    public function ajoutPersonne(Personne $personne):void 
    {
        $this->personnes[] = $personne;
    } 


    /**
    * Retourne toutes les personnes de la liste
    * 
    */ 
    
    public function getPersonnes(){
        return $this->personnes;
    }


    /**
    * Charge toutes les personnes contenu dans la BDD dans le tableau de personnes
    * 
    */

    public function chargementPersonnes():void
    {

        //On prépare la requête que permet de récupérer toutes les personnes présentent en base de données
        $sql = "SELECT * FROM personne;";
        $req = $this->db->prepare($sql);
        //Puis on l'exécute
        $req->execute();
        //On stock et mets en forme le résultat dans $mesPersonnes
        $mesPersonnes = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        $req = null;

        //On créé les personnes et on les ajoute dans le tableau "Personnes"
        foreach($mesPersonnes as $personne){
            $p = new Personne($personne['idPersonne'],$personne['nom'],$personne['prenom']);
            $this->ajoutPersonne($p);
        }
    }


     /**
    * Récupérer une personne via son identifiant
    * @param Personne $idPersonne
    */
    
    public function getPersonneById(Personne $idPersonne){
        for($i=0; $i < count($this->personnes);$i++){
            if($this->personnes[$i]->getId() === $idPersonne){
                return $this->livres[$i];
            }
        }
    }


    /**
    * Rajoute une personne dans la base de données
    * @param Personne $personne
    */
     
    public function ajoutPersonneBd(Personne $personne):void
    {
        
        //On prépare la requête qui permet d'insérer notre nouvelle personne dans la base de données
        $sql = "INSERT INTO personne (nom, prenom) values (:nom , :prenom)";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":nom",$personne->getNom(),PDO::PARAM_STR);
        $req->bindValue(":prenom",$personne->getPrenom(),PDO::PARAM_STR);
        
        //On exécute la requête permettant d'insérer les données
        $resultat = $req->execute();
        $req->closeCursor();
        $req = null;

        //On récupère l'ID de la dernière personne inséré
        $idPersonne = $this->db->lastInsertId();

        //On prépare la requête qui permet d'insérer l'id de notre nouvelle personne dans la table collection pour lui créer une collection
        $sql2 = "INSERT INTO collection (idPersonne) values (:idPersonne)";
        $req2 = $this->db->prepare($sql2);
        $req2->bindValue(":idPersonne",$idPersonne,PDO::PARAM_INT);

        //On exécute la requête permettant d'insérer les données
        $req2->execute();
        $req2->closeCursor();
        $req2 = null;


        // On vérifie que la requête a bien fonctionnée et on ajoute la nouvelle personne dans la liste de personne
        if($resultat > 0){ 
            $personne = new Personne($this->db->lastInsertId(),$personne['nom'],$personne['prenom']);
            $this->ajoutPersonne($personne);

        }

    }

    /**
    * Supprime une personne dans la base de données
    * @param Personne idPersonne
    */

    public function suppressionPersonneBD(Personne $idPersonne):void
    {

        //On prépare la requête qui permet de supprimer une personne et sa collection filtré par son id
        $sql = " DELETE from personne where id = :idPersonne";
        $req = $this->db->prepare($sql);     

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":idPersonne",$idPersonne->getIdPersonne(),PDO::PARAM_INT);
       
        //On exécute la requête permettant d'insérer les données
        $resultat = $req->execute();
        $req->closeCursor();
        $req = null;

        //Idem pour supprimer la collection
        $sql2 = " DELETE from collection where id = :idPersonne";
        $req2 = $this->db->prepare($sql2);
        $req2->bindValue(":idPersonne",$idPersonne->getIdPersonne(),PDO::PARAM_INT);
        $req2->execute();
        $req2->closeCursor();
        $req2 = null;

         // On vérifie que la requête a bien fonctionnée et on supprime la personne dans la liste de personnes
        if($resultat > 0){
            $personne = $this->getPersonneById($idPersonne);
            unset($personne);
        }
    }

    /**
    * Modifie une personne dans la base de données
    * @param Personne $personne,Personne $nom,Personne $prenom,Personne $idPersonne
    */

    function modificationPersonneBD(Personne $personne, Personne $idPersonne):void
    {
         //On prépare la requête qui permet de mettre à jour une personne filtré par son id
        $sql = "UPDATE personne SET nom = :nom, prenom = :prenom WHERE idPersonne = :idPersonne";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":nom",$personne->getNom(),PDO::PARAM_STR);
        $req->bindValue(":prenom",$personne->getPrenom(),PDO::PARAM_STR);
        $req->bindValue(":idPersonne",$personne->getIdPersonne(),PDO::PARAM_INT);

        //On exécute la requête permettant de mettre à jour les données
        $resultat = $req->execute();
        $req->closeCursor();
        $req = null;
 
        // On vérifie que la requête a bien fonctionnée et on met à jour la personne dans la liste de personnes
        if($resultat > 0){
            $this->getPersonneById($idPersonne)->setNom($personne->getNom());
            $this->getPersonneById($idPersonne)->setPrenom($personne->getPrenom());
        }
    }


    
}
