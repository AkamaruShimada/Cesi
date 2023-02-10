<?php
// Connexion ?? la base de donn??es
$db = new PDO('mysql:host=localhost;dbname=meteo', 'root', 'cesi');

// R??cup??ration du verbe HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Fonction pour g??rer la r??cup??ration des donn??es
function getData($id)
{
  global $db;
  if ($id) {
    // R??cup??ration d'un enregistrement
    $query = $db->prepare("SELECT Lieu ,Site ,Temp ,Humidity ,Pressure ,Time 
    FROM statement st INNER JOIN sensor s on st.ID_Sensor = s.ID
    WHERE s.ID = :id
    ORDER BY st.ID_Statement DESC;");
    $query->execute(['id' => $id]);
    $statement = $query->fetch();
    return $statement;
  } else {
    // R??cup??ration de tous les enregistrements
    $query = $db->query("SELECT Lieu ,Site ,Temp ,Humidity ,Pressure ,Time 
    FROM statement st INNER JOIN sensor s on st.ID_Sensor = s.ID ;");
    $statement = $query->fetchAll();
    return $statement;
  }
}

// Fonction pour g??rer la cr??ation d'un enregistrement
function createData()
{
  global $db;
  // Cr??ation d'un enregistrement
  $site = isset($_POST['site']) ? $_POST['site'] : NULL;
  $query = $db->prepare("INSERT INTO statement (ID_Sensor, Temp, Pressure, Humidity) VALUES (:id, :temp, :pressure, :humidity)");
  $query->execute($_POST);
  echo ("Les données ont bien été envoyées");
}

// Traitement en fonction du verbe HTTP
switch ($method) {
  case 'GET':
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;
    $data = getData($id);
    header("Access-Control-Allow-Origin:*");
    header("Content-Type: application/json");
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    break;
  case 'POST':
    createData();
    break;
}
