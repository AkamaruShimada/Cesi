<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getEmployees()
	{
		global $conn;
		$query = "SELECT * FROM Employe";
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		//header('Content-Type: application/json');
		//echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getEmployee($id=0)
	{
		global $conn;
		$query = "SELECT * FROM Employe";
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
	
	function AddEmployee()
	{
		global $conn;
		$name = $_POST["Nom"];
		$prenom = $_POST["Prenom"];
		$query = "INSERT INTO Employe (Nom, Prenom) VALUES('".$name."', '".$prenom."')";
		
		if(mysqli_query($conn, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Produit ajoute avec succes.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'ERREUR!.'. mysqli_error($conn)
			);
		}
		//header('Content-Type: application/json');
		//echo json_encode($response);
	}
	
	function updateEmployee($id)
	{
		
		global $conn;
		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		$name = $_PUT["Nom"];
		$prenom = $_PUT["Prenom"];
		$query="UPDATE Employee SET Nom='".$name."', Prenom='".$prenom."' WHERE id=".$id;
		
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
	
	function deleteEmployee($id)
	{
		
		global $conn;
		$query = "DELETE FROM Employe WHERE id=".$id;
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
				getEmployee($id);
			}
			else
			{
				getEmployees();
			}
			break;
		
		case 'POST':
			// Ajouter un produit
			AddEmployee();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateEmployee($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteEmployee($id);
			break;

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}
	
?>