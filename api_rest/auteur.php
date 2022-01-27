<?php

//Connect to database
include("db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getAuteurs()
{
    //connection à la base
    global $conn;

    //construction de la requête
    $query = "SELECT * FROM auteur";
    $response=array();
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
    {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addAuteur()
{
    //connection à la base
    global $conn;

     //Récupération des données dans la variable global POST
     $nomAuteur = $_POST["nomAuteur"];
 
     //construction de la requête
     $query = "INSERT INTO auteur (nomAuteur) values ('".$nomAuteur. "')";

    if(mysqli_query($conn, $query))
    {
        $response=array(
            'status' => 1,
            'status_message' => 'auteur ajoute avec succes.'
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

function updateAuteur($id)
{
    //connection à la base
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);

    //Récupération des données dans la variable global PUT
    $titre = $_PUT["titre"];
    $genre = $_PUT["genre"];
    $auteur = $_PUT["auteur"];


    //construction de la requête
    $query = "UPDATE auteur SET titre = '".$titre."', genre = '".$genre."', auteur = '".$auteur."' WHERE idauteur =" .$id;


    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'auteur mis a jour avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Echec de la mise a jour de la auteur. '. mysqli_error($conn)
      );
      
    }


    header('Content-Type: application/json');
    echo json_encode($response);
}

function deleteAuteur($id)
{
    //connection à la base
    global $conn;
    //construction de la requête
    $query = "DELETE from auteur where id =".$id;
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
            //récupère un seul auteur
            $id = intval($_GET["id"]);
            getAuteurs();
        } else {
            //Récupère tous les auteurs
            getAuteurs();
        }
        break;

    case 'POST':
        //Ajouter un auteur
        addAuteur();
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Modifier un auteur
        $id = intval($_GET["id"]);
        updAteauteur($id);
        break;

    case 'DELETE':
        //supprimer un auteur
        $id = intval($_GET["id"]);
        deleteAuteur($id);
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
