<?php

/**
 * fichier necessaire a la connexion ala base de donnée avec Redbean, les variables de connexions sont définies dans le fichier constantes.php
 */

include_once "Constantes.php";
require_once "rb.php";


$db = R::setup( Constantes::TYPE.':host='.Constantes::HOST.';dbname='.Constantes::BASE_REDBEAN,
Constantes::USER, Constantes::PASSWORD );
