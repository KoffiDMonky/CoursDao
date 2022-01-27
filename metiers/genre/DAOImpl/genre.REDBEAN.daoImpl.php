<?php

class daoImplGenreRedBean implements daoGenre {

    
    private $db; //Instance de PDO
    private $genres; //tableau de genres

    function __construct($db, $genres) {
    	$this->db = $db;
    	$this->genres = $genres;
    
    }

    /**
    * Ajoute un genre à la liste de genres
    * @param Genre $genre
    */  
    public function ajoutGenre(Genre $genre){
        $this->genres[] = $genre;
    } 

    /**
    * Retourne tous les genres de la liste
    * 
    */
    public function getGenres(){
        return $this->genres;
    }

    /**
    * Charge tous les genres contenu dans la BDD dans le tableau de genre
    * 
    */
    public function chargementGenres(){

        R::setup();
        $mesGenres = R::findAll('genre');
        R::close();

        //On créé les genres et on les ajoute dans le tableau "Genres"
        foreach($mesGenres as $genre){
            $g = new Genre($genre['idGenre'],$genre['nomGenre']);
            $this->ajoutGenre($g);
        }
    }

    /**
     * Récupérer un genre via son identifiant
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
     * Rajoute un genre dans la base de données
     * @param Genre $genre
     */
    public function ajoutGenreBd(Genre $genre){
        
        $g = R::dispense('genre');
        $g->nomGenre = $genre->getNomGenre();
        $id = R::store($g);

        R::close();
        

        // On vérifie que la requête a bien fonctionnée et on ajoute la nouvelle genre dans la liste de genre
        if($g > 0){ 
            $genre = new Genre($id,$g['nomGenre']);
            $this->ajoutGenre($genre);

        }

    }

    /**
     * Supprime un genre dans la base de données
     * @param Genre $idGenre
     */
    public function suppressionGenreBD(Genre $idGenre){

        R::setup();
        $g = R::load('genre',$idGenre);
        
        
        // On vérifie que la requête a bien fonctionnée et on supprime la nouvelle genre dans la liste de genres
        if($g > 0){
            $genre = $this->getGenreById($idGenre);
            unset($genre);
        }
        R::trash($g);
        R::close();
    }

    /**
     * Modifie un genre dans la base de données
     * @param Genre $genre
     * @param Genre $idGenre
     */

    function modificationGenreBD(Genre $genre, Genre $idGenre){
        
        R::setup();
        $g = R::load('genre',$idGenre);
        $g->nomGenre = $genre->getNomGenre();
        $id = R::store($g);
        R::close();

        if($g > 0){
            $this->getGenreById($idGenre)->setNomGenre($genre->getNomGenre());
        }
    }
}
