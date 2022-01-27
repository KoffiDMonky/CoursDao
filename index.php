<?php

require_once "Constantes.php";
require_once "connectionPDO.php";
require_once "connectionRedbean.php";
require_once "rb.php";

require_once "metiers/personne/personne.class.php";
require_once "metiers/personne/DAO/personne.dao.php";
require_once "metiers/personne/DAOImpl/personne.PDO.daoImpl.php";
require_once "metiers/personne/DAOImpl/personne.REDBEAN.daoImpl.php";

require_once "metiers/livre/livre.class.php";
require_once "metiers/livre/DAO/livre.dao.php";
require_once "metiers/livre/DAOImpl/livre.PDO.daoImpl.php";
require_once "metiers/livre/DAOImpl/livre.REDBEAN.daoImpl.php";

require_once "metiers/genre/genre.class.php";
require_once "metiers/genre/DAO/genre.dao.php";
require_once "metiers/genre/DAOImpl/genre.PDO.daoImpl.php";
require_once "metiers/genre/DAOImpl/genre.REDBEAN.daoImpl.php";

require_once "metiers/auteur/auteur.class.php";
require_once "metiers/auteur/DAO/auteur.dao.php";
require_once "metiers/auteur/DAOImpl/auteur.PDO.daoImpl.php";
require_once "metiers/auteur/DAOImpl/auteur.REDBEAN.daoImpl.php";



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/cyborg/bootstrap.min.css">
</head>

<body>

    <div class="container d-flex flex-column">
        <h1 class="rounded border border-dark p-2 m-2 text-center text-white bg-light">La biblio'</h1>
        <div class="d-flex justify-content-center">
            <div class="row text-center justify-content-center align-items-center">
                <!-- --------------------------------------------------CARTE AJOUT PERSONNE------------------------------------------------------------------- -->
                <div class="card m-2 col-3" style="width: 18rem;">
                    <div class="card-body">

                        <h5 class="card-title">Ajouter une personne</h5>

                        <label for="nom" class="mt-3">nom</label>
                        <input type="text" class="form-control" id="nom" placeholder="Entrer un nom">

                        <label for="exampleInputEmail1" class="mt-3">prenom</label>
                        <input type="prenom" class="form-control" id="prenom" placeholder="Entrer un prenom">

                        <div class="text-center">
                            <button type="submit" class="btn mt-3  btn-primary">Envoyer</button>
                        </div>

                    </div>
                </div>
                <!-- --------------------------------------------------CARTE AJOUT LIVRE------------------------------------------------------------------- -->
                <div class="card m-2 col-3" style="width: 18rem;">
                    <div class="card-body">

                        <h5 class="card-title text-center">Ajouter un livre</h5>

                        <label for="titre" class="mt-3">Titre du livre</label>
                        <input type="text" class="form-control" id="titre" placeholder="Entrer un titre">

                        <label for="auteur" class="mt-3">Auteur de l'oeuvre</label>
                        <select class="form-select-lg mb-3" aria-label="Sélectionne un auteur">
                            <option selected>Sélectionner une oeuvre</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>

                        <label for="genre" class="mt-3">Genre de l'oeuvre</label>
                        <div>
                            <select class="form-select-lg mb-3" size="5" aria-label="Sélectionne un genre">
                                <option selected>Sélectionner un genre</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn mt-3  btn-primary">Envoyer</button>
                        </div>

                    </div>
                </div>

                <!-- --------------------------------------------------CARTE AJOUT LIVRE DANS UNE COLLECTION------------------------------------------------------------------- -->

                <div class="card m-2 col-3" style="width: 18rem;">
                    <div class="card-body">

                        <h5 class="card-title text-center">Ajouter des livres dans une collection</h5>


                        <label for="personne" class="mt-3">Personnes</label>
                        <select class="form-select-lg mb-3" aria-label="Sélectionne une personne">
                            <option selected>Sélectionner une personne</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>

                        <label for="livres" class="mt-3">Livres</label>
                        <div>
                            <select class="form-select-lg mb-3" size="5" aria-label="Sélectionne un livre">
                                <option selected>Sélectionner un livre</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn mt-3  btn-primary">Envoyer</button>
                        </div>

                    </div>
                </div>

                <!-- --------------------------------------------------CARTE AJOUT D'UN GENRE------------------------------------------------------------------- -->

                <div class="card m-2 col-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Ajouter des genres</h5>
                        <label for="genre" class="mt-3">Nom du genre</label>
                        <input type="text" class="form-control" id="genre" placeholder="Entrer un nom de genre">

                    </div>
                </div>


                <!-- --------------------------------------------------CARTE AJOUT D'UN GENRE A UN LIVRE------------------------------------------------------------------- -->
                <div class="card m-2 col-3" style="width: 18rem;">
                    <div class="card-body">

                        <h5 class="card-title text-center">Ajouter des genres à des livres</h5>

                        <label for="livres" class="mt-3">Livres</label>
                        <select class="form-select-lg mb-3" aria-label="Sélectionne un livre">
                            <option selected>Sélectionner un livre</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>

                        <label for="genres" class="mt-3">Genres</label>
                        <div>
                            <select class="form-select-lg mb-3" size="5" aria-label="Sélectionne un genre">
                                <option selected>Sélectionner un genre</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn mt-3  btn-primary">Envoyer</button>
                        </div>
                    </div>
                </div>

                <div class="card m-2 col-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Tous les livres</h5>

                    </div>
                </div>

                <div class="card m-2 col-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Toutes les personnes</h5>

                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>