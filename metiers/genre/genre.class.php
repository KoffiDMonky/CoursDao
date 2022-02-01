<?php

/**
 *Classe métier Genre
 */

class genre
{
    private int $idGenre;
    private string $nomGenre;


    function __construct(string $nomGenre) {
    	$this->nomGenre = $nomGenre;
    
    }

    /**
    * @return int
    */
    public function getIdGenre(): int {
    	return $this->idGenre;
    }

    /**
    * @param int $idGenre
    */
    public function setIdGenre(int $idGenre): void {
    	$this->idGenre = $idGenre;
    }

    /**
    * @return string
    */
    public function getNomGenre(): string {
    	return $this->nomGenre;
    }

    /**
    * @param string $nomGenre
    */
    public function setNomGenre(string $nomGenre): void {
    	$this->nomGenre = $nomGenre;
    }
}