<?php
require_once("./function.php");
try {
if(!empty($_GET['demande'])){
    $url = explode("/", filter_var($_GET['demande'],FILTER_SANITIZE_URL));
    switch($url[0]){
        case "badge" :
            if(empty($url[1])){
                getBadge($url[1]);
            }else {
                echo "Aucun badge n'est détectés";
            }
        break;
        case "dates" :
            if(empty($url[1])){
                getDate($url[1]);
            }else {
                echo "Aucune date n'est détectés";
            }
        break;
        case "Employer" :
            if(!empty($url[1])){
                getEmployer($url[1]);
            }else {
                 echo "Aucun employer n'est détecté";
            }
        break;
        default : throw new Exception ("La demande n'est pas valide.");

    }
}else{
    throw new Exception ("Problème de récupération de données.");
    }
    
if(!empty($_POST['insert'])){
    $url = explode("/", filter_var($_POST['insert'],FILTER_SANITIZE_URL));
    switch($url[0]){
        case "badge" :
            if(empty($url[1])){
                getBadge($url[1]);
            }else {
                echo "Aucun badge n'est détectés";
            }
        break;
        case "dates" :
            if(empty($url[1])){
                getDate($url[1]);
            }else {
                echo "Aucune date n'est détectés";
            }
        break;
        case "Employer" :
            if(!empty($url[1])){
                getEmployer($url[1]);
            }else {
                 echo "Aucun employer n'est détecté";
            }
        break;
        default : throw new Exception ("La demande n'est pas valide.");

    }
}else{
    throw new Exception ("Problème d'insertion de données.");
    }
} catch(Exception $e){
        $erreur =[
        "message" => $e->getMessage(),
        "code" => $e->getCode()
        ];
    print_r($erreur);
}