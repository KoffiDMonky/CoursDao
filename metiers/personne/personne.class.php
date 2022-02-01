<?php

/**
 *Classe métier Personne
 */

class personne
{
    private int $idPersonne;
    private string $nom;
    private string $prenom;
    

    function __construct( string $nom, string $prenom) {
    	$this->nom = $nom;
    	$this->prenom = $prenom;
    
    }

    /**
    * @return int
    */
    public function getIdPersonne(): int {
    	return $this->idPersonne;
    }

    /**
    * @param int $idPersonne
    */
    public function setIdPersonne(int $idPersonne): void {
    	$this->idPersonne = $idPersonne;
    }

    /**
    * @return string
    */
    public function getNom(): string {
    	return $this->nom;
    }

    /**
    * @param string $nom
    */
    public function setNom(string $nom): void {
    	$this->nom = $nom;
    }

    /**
    * @return string
    */
    public function getPrenom(): string {
    	return $this->prenom;
    }

    /**
    * @param string $prenom
    */
    public function setPrenom(string $prenom): void {
    	$this->prenom = $prenom;
    }
}