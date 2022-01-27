<?php

class daoImplGenrePDO implements daoGenre {

    
    private $db; //Instance de PDO
    private $genres; //tableau de genres

    function __construct($db, $genres) {
    	$this->db = $db;
    	$this->genres = $genres;
    
    }

    /**
    * Ajoute un Genre à la liste de genres
    * @param Genre $genre
    */
    public function ajoutGenre(Genre $genre):void
    {
        $this->genres[] = $genre;
    } 

    /**
    * Retourne tous les genre du tableau
    * 
    */
    public function getGenres(){
        return $this->genres;
    }

    /**
    * Charge tous les genres contenu dans la BDD dans le tableau de genres
    * 
    */
    public function chargementGenres():void
    {

        //On prépare la requête que permet de récupérer toutes les genres présentent en base de données
        $sql = "SELECT * FROM genre;";
        $req = $this->db->prepare($sql);
        //Puis on l'exécute
        $req->execute();
        //On stock et mets en forme le résultat dans $mesGenres
        $mesGenres = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        $req = null;

        //On créé les genres et on les ajoute dans le tableau "Genres"
        foreach($mesGenres as $genre){
            $p = new Genre($genre['idGenre'],$genre['nomGenre']);
            $this->ajoutGenre($p);
        }
    }

    /**
    * Récupère un genre par son identifiant
    * @param Genre $idGenre
    */
    public function getGenreById(Genre $idGenre){
        for($i=0; $i < count($this->genres);$i++){
            if($this->genres[$i]->getId() === $idGenre){
                return $this->livres[$i];
            }
        }
    }

    /**
    * Rajoute un Genre dans la base de données
    * @param Genre $genre
    */
    public function ajoutGenreBd(Genre $genre):void
    {
        
        //On prépare la requête qui permet d'insérer notre nouvelle genre dans la base de données
        $sql = "INSERT INTO genre (nomGenre) values (:nomGenre)";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":nomGenre",$genre->getNomGenre(),PDO::PARAM_STR);

        
        //On exécute la requête permettant d'insérer les données
        $resultat = $req->execute();
        $req->closeCursor();
        $req = null;

        // On vérifie que la requête a bien fonctionnée et on ajoute la nouvelle genre dans la liste de genre
        if($resultat > 0){ 
            $genre = new Genre($this->db->lastInsertId(),$genre['nomGenre']);
            $this->ajoutGenre($genre);

        }

    }

    /**
    * Supprime une Livre dans la base de données
    * @param Genre $idGenre
    */
    public function suppressionGenreBD(Genre $idGenre):void
    {

        //On prépare la requête qui permet de supprimer une genre filtré par son id
        $sql = " DELETE from genre where id = :idGenre";
        $req = $this->db->prepare($sql);

        //On insère les valeurs des paramètres dans la requête 
        $req->bindValue(":idGenre",$idGenre->getIdGenre(),PDO::PARAM_INT);

        //On exécute la requête permettant d'insérer les données
        $resultat = $req->execute();
        $req->closeCursor();
        $req = null;

         // On vérifie que la requête a bien fonctionnée et on supprime la nouvelle genre dans la liste de genres
        if($resultat > 0){
            $genre = $this->getGenreById($idGenre);
            unset($genre);
        }
    }

    /**
    * Modifie une Livre dans la base de données
    * @param Genre $idGenre
    */

    function modificationGenreBD(Genre $genre, Genre $idGenre){
        
        $sql = "UPDATE genre SET nomGenre = :nomGenre WHERE idGenre = :idGenre";
        $req = $this->db->prepare($sql);
        $req->bindValue(":nom",$genre->getNomGenre(),PDO::PARAM_STR);
        $req->bindValue(":idGenre",$genre->getIdGenre(),PDO::PARAM_INT);

        $resultat = $req->execute();
        $req->closeCursor();
        $req = null;

        if($resultat > 0){
            $this->getGenreById($idGenre)->setNomGenre($genre->getNomGenre());
        }
    }
}
