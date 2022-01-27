<?php


class daoImplPersonneRedBean implements daoPersonne {

    private $db; //Instance de PDO
    private $personnes; //tableau de personnes

    function __construct($db, $personnes) {
    	$this->db = $db;
    	$this->personnes = $personnes;
    
    }

    
    /**
    * Ajoute une personne à la liste de personnes
    * @param Personne $Personne
    */ 

    public function ajoutPersonne(Personne $personne){
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

    public function chargementPersonnes(){

        R::setup();
        $mesPersonnes = R::findAll('personne');
        R::close();

        //On créé les personnes et on les ajoute dans le tableau "Personnes"
        foreach($mesPersonnes as $personne){
            $p = new Personne($personne['id'],$personne['nom'],$personne['prenom']);
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
                return $this->personnes[$i];
            }
        }
    }


    /**
    * Rajoute une personne dans la base de données
    * @param Personne $personne
    */
     
    public function ajoutPersonneBd(Personne $personne){
        
        
        R::setup();

        $p = R::dispense('personne');
        $p->nom = $personne->getNom();
        $p->prenom = $personne->getPrenom();
        $id = R::store($p);

        R::close();

        // Si on a un bean, on ajoute la nouvelle personne dans la liste de personne
        if($p > 0){ 
            $personne = new Personne($id, $p['nom'], $p['prenom']);
            $this->ajoutPersonne($personne);

        }

    }

    /**
    * Supprime une personne dans la base de données
    * @param Personne $idPersonne
    */

    public function suppressionPersonneBD(Personne $idPersonne){

        R::setup();
        $p = R::load('personne',$idPersonne);
        
        // Si on a un bean, on supprime la personne dans la liste de personnes
        if($p > 0){
            $p = $this->getPersonneById($idPersonne);
            unset($p);
        }

        R::trash($p);
        R::close();
    }

    /**
    * Modifie une personne dans la base de données
    * @param Personne $personne
    * @param Personne $idPersonne
    */

    function modificationPersonneBD(Personne $personne, Personne $idPersonne){
        
        R::setup();
        $p = R::load('personne',$idPersonne);
        $p->nom = $personne->getNom();
        $p->prenom = $personne->getPrenom();
        $id = R::store($p);
        R::close();

        if($id > 0){
            $this->getPersonneById($idPersonne)->setNom($personne->getNom());
            $this->getPersonneById($idPersonne)->setPrenom($personne->getPrenom());
        }
    }


    
}
