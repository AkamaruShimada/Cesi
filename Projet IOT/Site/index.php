<!DOCTYPE html>
<html>
<title>Pole Emplois</title>

<head>
  <?php
  include ("db_connect.php");

  $d = strtotime("-1 weeks");
  $f = strtotime("today");

  if(isset($_GET['n']) AND !empty ($_GET['n'])){
    $nom = htmlspecialchars($_GET['n']);
  } else $nom = "";
  if(isset($_GET['p']) AND !empty ($_GET['p'])){
    $prenom = htmlspecialchars($_GET['p']);
  }else $prenom = "";
  if(isset($_GET['dated']) AND !empty ($_GET['dated'])){
    $dated = htmlspecialchars($_GET['dated']);
  }else $dated = date("Y-m-d h:i:sa", $d);
  if(isset($_GET['datef']) AND !empty ($_GET['datef'])){
    $datef = htmlspecialchars($_GET['datef']);
  }else $datef = date("Y-m-d h:i:sa", $f);
  
  $req = 'SELECT Nom,Prenom,Date,Badge FROM Employe INNER JOIN Passage ON Employe.Badge = Passage.IDbadge WHERE Nom LIKE "%'.$nom.'%" AND Prenom LIKE "%'.$prenom.'%" AND Date BETWEEN "'.$dated.'" AND "'.$datef.'" ORDER BY Date DESC';
  $result = mysqli_query($conn,$req);
    ?>

  <link rel="stylesheet" href="CSS.css">

  <div style="text-align: center">

      <strong>
        <br><font face="sans-serif" size="+2" color="black">Chercher une voiture :</font>
      </strong>

    <form method="GET">
      <div id="chercher">

        <input type="search" id="query" name="n" placeholder="Recherchez le nom">
        <input type="search" id="query" name="p" placeholder="Recherchez le prénom">
        <input type="date" id="query" name="dated" >
        <input type="date" id="query" name="datef" >
        <button><svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>

      </div>
    </form>

  </div>
  
</head>

<body>
<center>
<table>
<th>Nom</th>
<th>Prénom</th>
<th>Date</th>
<th>Badge</th>
<?php
while($row = mysqli_fetch_row($result)){
  ?>
  <tr>
    <td><?=$row[0]?></td>
    <td><?=$row[1]?></td>
    <td><?=$row[2]?></td>
    <td><?=$row[3]?></td>
  </tr>

  <?php
}
?>

</table>


  <div style="text-align: center" >

  <form action="formulaire.php">
    <strong>
      <br><br><font face="sans-serif" size="+2" color="black">Formulaire d'insertion manuel</font>
    </strong>
    <br>
    <div id="vente">
    <input type="submit" id="query" value="Aller sur le formulaire"/>
    </div>
  </div>
  </form>

</body>

</html>

