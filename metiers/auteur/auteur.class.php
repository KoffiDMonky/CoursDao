<?php

/**
 *Classe métier Auteur
 */

class auteur
{
    private int $idAuteur;
    private string $nomAuteur;
    private int $id_livre;

    function __construct(string $nomAuteur) {
    	$this->nomAuteur = $nomAuteur;
    
    }

    /**
    * @return int
    */
    public function getIdAuteur(): int {
    	return $this->idAuteur;
    }

    /**
    * @param int $idAuteur
    */
    public function setIdAuteur(int $idAuteur): void {
    	$this->idAuteur = $idAuteur;
    }
    /**
    * @return int
    */
    public function getNomAuteur(): string {
    	return $this->nomAuteur;
    }

    /**
    * @param int $nomAuteur
    */
    public function setNomAuteur(string $nomAuteur): void {
    	$this->nomAuteur = $nomAuteur;
    }

    /**
    * @return int
    */
    public function getId_livre(): int {
    	return $this->id_livre;
    }

    /**
    * @param int $id_livre
    */
    public function setId_livre(int $id_livre): void {
    	$this->id_livre = $id_livre;
    }

}