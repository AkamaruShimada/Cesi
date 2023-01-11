<?php

function getBadge($badges){
    $pdo = getConexion();
    $req = "SELECT Badge AS 'ID_Badge'  
    from Id_badge b
    INNER JOIN Employer emp on emp.Id_Badge = b.ID";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $badges = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($badges);

}
function getDate($dates){
    $pdo = getConexion();
    $req = "SELECT Date
    FROM Employer emp
    INNER JOIN Id_badge b on b.ID = emp.Id_Badge";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $dates = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($dates);

}
function getEmployer($id){
    $pdo = getConexion();
    $req = "SELECT Nom,Prenom,Date
    FROM Employer emp
    INNER JOIN Id_badge b on b.ID = emp.Id_badge
    WHERE emp.Id_badge = :id";
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(":id",$id,PDO::PARAM_INT);
    $stmt->execute();
    $id = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    sendJSON($id);

}
function getConexion(){
    $servername="localhost";
    $sqluser="dibdd";
    $sqlpass="cesi";
    $db="cesibdd";

    $connect =mysqli_connect($servername,$sqluser,$sqlpass,$db);
}
function sendJSON($infos){
    header("Access-Control-Allow-Origin:*");
    header("Content-Type: application/json");
    echo json_encode($infos,JSON_UNESCAPED_UNICODE);
}

?>