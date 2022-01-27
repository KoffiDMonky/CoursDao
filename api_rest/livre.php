<?php

//Connect to database
include("db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getlivres()
{
    //connection à la base
    global $conn;

    //construction de la requête
    $query = "SELECT * FROM livre";
    $response=array();
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
    {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addlivre()
{
    //connection à la base
    global $conn;

    //Récupération des données dans la variable global POST
    $titre = $_POST["titre"];
    $genre = $_POST["genre"];
    $auteur = $_POST["auteur"];
    

    //construction de la requête
    $query1 = "INSERT INTO livre (titre) values ('".$titre."')";
    $query2 = "INSERT INTO genre (nomGenre) values ('".$genre."')";
    $query3 = "INSERT INTO auteur (nomAuteur) values ('".$auteur."')";

    if(mysqli_query($conn, $query1, $query2, $query3))
    {
        $response=array(
            'status' => 1,
            'status_message' => 'livre ajoute avec succes.'
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

function updatelivre($id)
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
    $query = "UPDATE livre SET titre = '".$titre."', genre = '".$genre."', auteur = '".$auteur."' WHERE idlivre =" .$id;


    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'livre mis a jour avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Echec de la mise a jour de la livre. '. mysqli_error($conn)
      );
      
    }


    header('Content-Type: application/json');
    echo json_encode($response);
}

function deletelivre($id)
{
    //connection à la base
    global $conn;
    //construction de la requête
    $query = "DELETE from livre where id =".$id;
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
            //récupère un seul livre
            $id = intval($_GET["id"]);
            getlivres();
        } else {
            //Récupère tous les livres
            getlivres();
        }
        break;

    case 'POST':
        //Ajouter un livre
        addlivre();
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Modifier un livre
        $id = intval($_GET["id"]);
        updatelivre($id);
        break;

    case 'DELETE':
        //supprimer un livre
        $id = intval($_GET["id"]);
        deletelivre($id);
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>