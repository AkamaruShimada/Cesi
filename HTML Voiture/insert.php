<html>

<link rel="stylesheet" href="formulaire.css">

<?php

$servername="localhost";
$sqluser="dibdd";
$sqlpass="cesi";
$db="cesibdd";

$connect =mysqli_connect($servername,$sqluser,$sqlpass,$db);

if(!$connect)
{
die("Connection Failed.<br>".mysqli_error());
}


/*$sql2 = "INSERT INTO Personne (Nom, Prénom, Tel) VALUES ('$_POST[Nom]', '$_POST[Prénom]', '$_POST[Tel]')";*/

$sql = "INSERT INTO Voiture (Marque, Modèle, Carburant) VALUES ('$_POST[Marque]', '$_POST[Modèle]', '$_POST[Carburant]')";

if (mysqli_query($connect, $sql)) {
    echo "Nouveau enregistrement créé avec succès";?>
    <br>
    <?php
} else {
    echo "Erreur : " . $sql . "<br>" . mysqli_error($connect);
}
/*if (mysqli_query($connect, $sql2)){
    echo "Nouveau enregistrement créé avec succès";?>
    <br>
    <?php
} else {
    echo "Erreur : " . $sql2 . "<br>" . mysqli_error($connect);
}*/ 
mysqli_close($connect);

?>

</html>