<?php

//Connect to database
include("db_connect.php");
$request_method = $_SERVER["REQUEST_METHOD"];

function getGenres()
{
    //connection à la base
    global $conn;

    //construction de la requête
    $query = "SELECT * FROM genre";
    $response=array();
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result))
    {
        $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}

function addGenre()
{
    //connection à la base
    global $conn;

     //Récupération des données dans la variable global POST
     $nomGenre = $_POST["nomGenre"];
 
     //construction de la requête
     $query = "INSERT INTO genre (nomGenre) values ('".$nomGenre. "')";

    if(mysqli_query($conn, $query))
    {
        $response=array(
            'status' => 1,
            'status_message' => 'genre ajoute avec succes.'
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

function updateGenre($id)
{
    //connection à la base
    global $conn;
    $_PUT = array(); //tableau qui va contenir les données reçues
    parse_str(file_get_contents('php://input'), $_PUT);

    //Récupération des données dans la variable global PUT
    $titre = $_PUT["titre"];
    $genre = $_PUT["genre"];
    $genre = $_PUT["genre"];


    //construction de la requête
    $query = "UPDATE genre SET titre = '".$titre."', genre = '".$genre."', genre = '".$genre."' WHERE idgenre =" .$id;


    if(mysqli_query($conn, $query))
    {
      $response=array(
        'status' => 1,
        'status_message' =>'genre mis a jour avec succes.'
      );
    }
    else
    {
      $response=array(
        'status' => 0,
        'status_message' =>'Echec de la mise a jour de la genre. '. mysqli_error($conn)
      );
      
    }


    header('Content-Type: application/json');
    echo json_encode($response);
}

function deleteGenre($id)
{
    //connection à la base
    global $conn;
    //construction de la requête
    $query = "DELETE from genre where id =".$id;
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
            //récupère un seul genre
            $id = intval($_GET["id"]);
            getGenres();
        } else {
            //Récupère tous les genres
            getGenres();
        }
        break;

    case 'POST':
        //Ajouter un genre
        addGenre();
        header("HTTP/1.0 201 created");
        break;

    case 'PUT':
        //Modifier un genre
        $id = intval($_GET["id"]);
        updAtegenre($id);
        break;

    case 'DELETE':
        //supprimer un genre
        $id = intval($_GET["id"]);
        deleteGenre($id);
        header("HTTP/1.0 204 request processed");
        break;
    
    default:
        //Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
