<?php

//Connect to database
include("db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getPersonnes()
{
    //connection à la base
    global $conn;

    //construction de la requête
    $query = "SELECT * FROM personne";
    $response=array();
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
    {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addPersonne()
{
    //connection à la base
    global $conn;

    //Récupération des données dans la variable global POST
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    //construction de la requête
    $query = "INSERT INTO personne (nom, prenom) values ('".$nom. "', '".$prenom."')";

    if(mysqli_query($conn, $query))
    {
        $response=array(
            'status' => 1,
            'status_message' => 'Personne ajoute avec succes.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' => 'ERREUR!.'. mysqli_error($conn)
        );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}

function updatePersonne($id)
{
    //connection à la base
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);

    //Récupération des données dans la variable global PUT
    $nom = $_PUT["nom"];
    $prenom = $_PUT["prenom"];

    //construction de la requête
    $query = "UPDATE personne SET nom = '".$nom."', prenom = '".$prenom."' WHERE idPersonne =" .$id;


    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'Personne mis a jour avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Echec de la mise a jour de la personne. '. mysqli_error($conn)
      );
      
    }


    header('Content-Type: application/json');
    echo json_encode($response);
}

function deletePersonne($id)
{
    //connection à la base
    global $conn;
    //construction de la requête
    $query = "DELETE from personne where id =".$id;
    $response=array();
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
    {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

switch ($request_method) {
    case 'GET':
        if(!empty($_GET["id"]))
        {
            //récupère une seule personne
            $id = intval($_GET["id"]);
            getPersonnes();
        } else {
            //Récupère toutes les personnes
            getPersonnes();
        }
        break;

    case 'POST':
        //Ajouter une personne
        addPersonne();
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Modifier une personne
        $id = intval($_GET["id"]);
        updatePersonne($id);
        break;

    case 'DELETE':
        //supprimer une personne
        $id = intval($_GET["id"]);
        deletePersonne($id);
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>