<?php

class daoImplLivrePDO implements daoLivre {

    private $db; //Instance de PDO
    private $livres; //tableau de livres

    function __construct($db, $livres) {
    	$this->db = $db;
    	$this->livres = $livres;
    
    }
   

    /**
    * Ajoute un Livre à la liste de livres
    * @param Livre $livre
    */
    public function ajoutLivre(Livre $livre):void
    {
        $this->livres[] = $livre;
    }

    /**
    * Retourne toutes les livres de la liste
    * 
    */
    public function getLivres(){
        return $this->livres;
    }

    /**
    * Charge toutes les livres contenu dans la BDD dans le tableau de livres
    * 
    */
    public function chargementLivres():void
    {
        //On prépare la requête que permet de récupérer toutes les livres présentent en base de données
        $sql = "SELECT * FROM Livre;";
        $req = $this->db->prepare($sql);
        //Puis on l'exécute
        $req->execute();
        //On stock et mets en forme le résultat dans $mesLivres
        $mesLivres = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        $req = null;

        //On créé les livres et on les ajoute dans le tableau "Livres"
        foreach($mesLivres as $livre){
            $p = new Livre($livre['idLivre'],$livre['titre'],$livre['genre'],$livre['auteur']);
            $this->ajoutLivre($p);
        }
    }


    /**
    * Récupère un livre par son identifiant
    * @param Livre $idLivre
    */
    public function getLivreById(Livre $idLivre){
        for($i=0; $i < count($this->livres);$i++){
            if($this->livres[$i]->getId() === $idLivre){
                return $this->livres[$i];
            }
        }
    }
    
    /**
    * Rajoute une Livre dans la base de données
    * @param Livre $livre
    */
    public function ajoutLivreBd(Livre $livre):void
    {

        //On prépare la requête qui permet d'insérer notre nouvelle Livre dans la base de données
        $sql = "INSERT INTO Livre (titre) values (:titre)";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":titre",$livre->getTitre(),PDO::PARAM_STR);
        
        //On exécute la requête permettant d'insérer les données
        $req->execute();
        $req->closeCursor();
        $req = null;

        //On récupère l'ID de la dernière personne inséré
        $idLivre = $this->db->lastInsertId();


        //On prépare la requête qui permet d'insérer le genre de notre nouveau Livre dans la table genre
        $sql2 = "INSERT INTO genre (nomGenre) values (:nomGenre)";
        $req2 = $this->db->prepare($sql2);

        //On insère les valeurs des paramètres dans la requête 
        $req2->bindValue(":nomGenre",$livre->getGenre(),PDO::PARAM_STR);
        
        //On exécute la requête permettant d'insérer les données
        $req2->execute();
        $req2->closeCursor();
        $req2 = null;

        //On récupère l'ID de la dernière personne inséré
        $idGenre = $this->db->lastInsertId();

        //On prépare la requête qui permet d'insérer le genre de notre nouveau Livre dans la table genre
        $sql3 = "INSERT INTO genre_livre (idLivre, idGenre) values (:idLivre, :idGenre)";
        $req3 = $this->db->prepare($sql3);

        //On insère les valeurs des paramètres dans la requête 
        $req3->bindValue(":idLivre",$idLivre,PDO::PARAM_INT);
        $req3->bindValue(":idGenre",$idGenre,PDO::PARAM_INT);
        
        //On exécute la requête permettant d'insérer les données
        $req3->execute();
        $req3->closeCursor();
        $req3 = null;

        //On prépare la requête qui permet d'insérer le genre de notre nouveau Livre dans la table genre
        $sql4 = "INSERT INTO auteur (nomAuteur) values (:nomAuteur)";
        $req4 = $this->db->prepare($sql4);

        //On insère les valeurs des paramètres dans la requête 
        $req4->bindValue(":nomAuteur",$livre->getAuteur(),PDO::PARAM_STR);

        //On exécute la requête permettant d'insérer les données
        $resultat = $req4->execute();
        $req4->closeCursor();
        $req4 = null;

        // On vérifie que la dernière requête a bien fonctionnée et on ajoute la nouvelle Livre dans la liste de Livre
        if($resultat > 0){ 
            $Livre = new Livre($this->db->lastInsertId(),$livre['titre'],$livre['genre'],$livre['auteur']);
            $this->ajoutLivre($Livre);

        }
    }

    /**
    * Supprime une Livre dans la base de données
    * @param Livre $idLivre
    */
    public function suppressionLivreBD(Livre $idLivre):void
    {
        //On prépare la requête qui permet de supprimer une Livre filtré par son id
        $sql = " DELETE from Livre where id = :idLivre";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":idLivre",$idLivre->getIdLivre(),PDO::PARAM_INT);

        //On exécute la requête permettant d'insérer les données
        $resultat = $req->execute();
        $req->closeCursor();
        $req = null;

         // On vérifie que la requête a bien fonctionnée et on supprime la nouvelle Livre dans la liste de livres
        if($resultat > 0){
            $Livre = $this->getLivreById($idLivre);
            unset($Livre);
        }
    }


    /**
    * Modifie une Livre dans la base de données
    * @param Livre $idLivre
    */
    public function modificationLivreBD(Livre $livre, Livre $idLivre):void
    {
        //On prépare la requête qui permet de mettre à jour un livre filtré par son id
        $sql = "UPDATE livre SET titre = :titre, genre = :genre, auteur = :auteur WHERE idLivre = :idLivre";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":titre",$livre->getTitre(),PDO::PARAM_STR);
        $req->bindValue(":genre",$livre->getGenre(),PDO::PARAM_STR);
        $req->bindValue(":auteur",$livre->getAuteur(),PDO::PARAM_STR);
        $req->bindValue(":idLivre",$livre->getIdLivre(),PDO::PARAM_INT);

        //On exécute la requête permettant de mettre à jour les données
        $resultat = $req->execute();
        $req->closeCursor();
        $req = null;

        // On vérifie que la requête a bien fonctionnée et on met à jour le livre dans la liste de livres
        if($resultat > 0){
            $this->getLivreById($idLivre)->setTitre($livre->getTitre());
            $this->getLivreById($idLivre)->setGenre($livre->getGenre());
            $this->getLivreById($idLivre)->setAuteur($livre->getAuteur());      
        }
    }
}