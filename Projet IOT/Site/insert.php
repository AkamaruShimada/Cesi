<html>

<?php

$nom = $_POST['Nom'];
$prenom = $_POST['Prenom'];

$sql = "SELECT Badge FROM Employe WHERE Nom LIKE '".$nom."' AND Prenom LIKE '".$prenom"'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
?>

<form action="passage.php" method="post">

<?php
$badge = $row;
$date = $_POST['Date'];
?>
</form>
<?php
echo ($row);
//$query = "INSERT INTO Passage (Date, IDbadge) VALUES ('".$date."','".$badge"')";
?>
</html>