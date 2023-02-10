<!DOCTYPE html>
<html>
<title>Météo</title>

<head>

  <?php
  include ("db_connect.php");

  date_default_timezone_set('Europe/Paris');

  $d = strtotime("-1 day");
  $f = strtotime("+1 day");

  if(isset($_GET['l']) AND !empty ($_GET['l'])){
    $lieu = htmlspecialchars($_GET['l']);
  } else $lieu = "";
  if(isset($_GET['dated']) AND !empty ($_GET['dated'])){
    $dated = htmlspecialchars($_GET['dated']);
  }else $dated = date("Y-m-d h:i:sa", $d);
  if(isset($_GET['datef']) AND !empty ($_GET['datef'])){
    $datef = htmlspecialchars($_GET['datef']);
  }else $datef = date("Y-m-d h:i:sa", $f);
  
  $req = 'SELECT ID,Site,Temp,Humidity,Pressure,Time FROM statement INNER JOIN sensor ON statement.ID_Sensor = sensor.ID WHERE ID LIKE "%'.$lieu.'%" AND Time BETWEEN "'.$dated.'" AND "'.$datef.'" ORDER BY Time DESC';
  $result = mysqli_query($conn,$req);
  ?>

  <link rel="stylesheet" href="CSS.css">

  <div style="text-align: center">

      <strong>
        <br><font face="sans-serif" size="+2" color="black">Chercher un capteur :</font>
      </strong>

    <form method="GET">
      <div id="chercher">

        <input type="search" id="query" name="l" placeholder="Recherchez grâce à un ID">
        <input type="datetime-local" id="query" name="dated">
        <input type="datetime-local" id="query" name="datef">
        <button><svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>
      </div>
    </form>
    <form action="graph.php">
    <strong>
      <font face="sans-serif" size="+2" color="black" id="text">Afficher la liste des grapiques</font>
    </strong>
    <br>
    <div id="graph">
      <input type="submit" id="query2" value="Aller sur la liste"/>
    </div>
  </div>
  </form>


  </div>
  
</head>

<body>
<center>
<table>
  <th>ID</th>
  <th>Lieu</th>
  <th>Température</th>
  <th>Humidité</th>
  <th>Pression</th>
  <th>Date</th>
<?php
for($x = 0; $x < 15; $x++){
  $row = mysqli_fetch_row($result)
?>
  <tr>
    <td><?=$row[0]?></td>
    <td><?=$row[1]?></td>
    <td><?=$row[2]?></td>
    <td><?=$row[3]?></td>
    <td><?=$row[4]?></td>
    <td><?=$row[5]?></td>
  </tr>
<?php
}
?>
</table>

<?php
$req2 = 'SELECT * FROM sensor WHERE ID LIKE "%'.$lieu.'%"';
$result2 = mysqli_query($conn,$req2);
?>
<table>
  <th>ID</th>
  <th>Lieu</th>
  <th>Environnement</th>
  <th>Desc</th>
<?php
while($row2 = mysqli_fetch_row($result2)){
?>
  <tr>
    <td><?=$row2[0]?></td>
    <td><?=$row2[1]?></td>
    <td><?=$row2[2]?></td>
    <td><?=$row2[3]?></td>
  </tr>
<?php
}
?>
</table>
</center>

</html>