<?php
    include("db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    function getPassages()
    {
        global $conn;
        $query = "SELECT * FROM Passage";
        $response = array();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {
            $response[] = $row;
        }
        //header('Content-Type: application/json');
        //echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function getPassage($id=0)
    {
        global $conn;
        $query = "SELECT * FROM Passage";
        if($id != 0)
        {
            $query .= " WHERE id=".$id." LIMIT 1";
        }
        $response = array();
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result))
        {
            $response[] = $row;
        }
        //header('Content-Type: application/json');
        //echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function AddPassage()
    {
        global $conn;
        $badge = $_POST["Badge"];
        $date = $_POST["Date"];
        $nom = $_POST['Nom'];
        $prenom = $_POST['Prenom'];
        if($date != NULL){

            $sql = "SELECT Badge FROM Employe WHERE Nom LIKE '".$nom."' AND Prenom LIKE '".$prenom."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $badge = $row['Badge'];

            $query = "INSERT INTO Passage (Date,IDbadge) VALUES('".$date."','".$badge."')";
        }else $query = "INSERT INTO Passage (IDbadge) VALUES('".$badge."')";

        if(mysqli_query($conn, $query)){
            $response=array(
                'status' => 1,
                'status_message' =>'Produit ajoute avec succes.'
            );
        }else{
            $response=array(
                'status' => 0,
                'status_message' =>'ERREUR!.'. mysqli_error($conn)
            );
        }
        //header('Content-Type: application/json');
        //echo json_encode($response);
    }

    function updatePassage($id)
    {
        
        global $conn;
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        $badge = $_PUT["Badge"];
        $query="UPDATE Passage SET IDbadge='".$badge."' WHERE id=".$id;
        
        if(mysqli_query($conn, $query))
        {
            $response=array(
                'status' => 1,
                'status_message' =>'Produit mis a jour avec succes.'
            );
        }
        else
        {
            $response=array(
                'status' => 0,
                'status_message' =>'Echec de la mise a jour de produit. '. mysqli_error($conn)
            );
            
        }
        
        //header('Content-Type: application/json');
        //echo json_encode($response);
    }

    function deletePassage($id)
    {
        
        global $conn;
        $query = "DELETE FROM Passage WHERE id=".$id;
        if(mysqli_query($conn, $query))
        {
            $response=array(
                'status' => 1,
                'status_message' =>'Produit supprime avec succes.'
            );
        }
        else
        {
            $response=array(
                'status' => 0,
                'status_message' =>'La suppression du produit a echoue. '. mysqli_error($conn)
            );
        }
        //header('Content-Type: application/json');
        //echo json_encode($response);
    }

    switch($request_method)
    {
        
        case 'GET':
            // Retrive Products
            if(!empty($_GET["id"]))
            {
                $id=intval($_GET["id"]);
                getPassage($id);
            }
            else
            {
                getPassages();			
            }
            break;
        
        case 'POST':
            // Ajouter un produit
            AddPassage();
            break;
            
        case 'PUT':
            // Modifier un produit
            $id = intval($_GET["id"]);
            updatePassage($id);
            break;
            
        case 'DELETE':
            // Supprimer un produit
            $id = intval($_GET["id"]);
            deletePassage($id);
            break;

        default:
            // Invalid Request Method
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
?>