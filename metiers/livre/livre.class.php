<?php

require_once "metiers/genre/genre.class.php";
require_once "metiers/auteur/auteur.class.php";

class livre
{
    private int $idLivre;
    private string $titre;
    private Genre $genre;
    private Auteur $auteur;
    

    

    function __construct(int $idLivre, string $titre, Genre $genre, Auteur $auteur) {
    	$this->idLivre = $idLivre;
    	$this->titre = $titre;
    	$this->genre = $genre;
    	$this->auteur = $auteur;
    
    }

    /**
    * @return int
    */
    public function getIdLivre(): int {
    	return $this->idLivre;
    }

    /**
    * @param int $idLivre
    */
    public function setIdLivre(int $idLivre): void {
    	$this->idLivre = $idLivre;
    }

    /**
    * @return string
    */
    public function getTitre(): string {
    	return $this->titre;
    }

    /**
    * @param string $titre
    */
    public function setTitre(string $titre): void {
    	$this->titre = $titre;
    }

    /**
    * @return string
    */
    public function getGenre(): Genre {
    	return $this->genre;
    }

    /**
    * @param string $genre
    */
    public function setGenre(string $genre): void {
    	$this->genre = $genre;
    }

    /**
    * @return string
    */
    public function getAuteur(): Auteur {
    	return $this->auteur;
    }

    /**
    * @param string $auteur
    */
    public function setAuteur(string $auteur): void {
    	$this->auteur = $auteur;
    }
}