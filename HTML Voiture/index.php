<!DOCTYPE html>
<html>
<title>Cars</title>

<head>

  <?php
  $bdd = new PDO("mysql:host=localhost;dbname=cesibdd",'dibdd','cesi');
  $allvoiture = $bdd->query('SELECT * FROM Voiture');
  $marque = $bdd->query('SELECT Marque FROM Voiture');
  $modele = $bdd->query('SELECT Modèle FROM Voiture');
  $carburant = $bdd->query('SELECT Carburant FROM Voiture');

  if(isset($_GET['s']) AND !empty ($_GET['s'])){
    $recherche = htmlspecialchars($_GET['s']);
    $marque = $bdd->query('SELECT * FROM Voiture WHERE Marque LIKE "%'.$recherche.'%"');
    $modele =$bdd->query('SELECT * FROM Voiture WHERE Modèle LIKE "%'.$recherche.'%"');
    $carburant = $bdd->query('SELECT * FROM Voiture WHERE Carburant LIKE "%'.$recherche.'%"');

  }
  ?>

  <link rel="stylesheet" href="CSS.css">

  <div style="text-align: center">

    <img src="Cars.png" width="270" height="270">

      <strong>
        <br><font face="times new roman" size="+2" color="white">Chercher une voiture :</font>
      </strong>

    <form method="GET">
      <div id="chercher"> 

        <input type="search" id="query" name="s" placeholder="Recherchez...">
        <button><svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
        </button>

      </div>
    </form>

  </div>
  
</head>

<body>
<center> 
<font color="white" size="+1">
<table border="5">
<?php while(!empty ($_GET['s']) && $a = $marque->fetch()) { ?>
  <tr>
    <th> Marque </th>
      <td><?=$a["Marque"] ?></td>
  </tr>
  <tr>
    <th> Modele </th>
      <td><?=$a["Modèle"] ?></td>
  </tr>
  <tr>
    <th> Carburant </th>
      <td><?=$a["Carburant"] ?></td>
  </tr>
<?php } ?>
<?php while(!empty ($_GET['s']) && $a = $modele->fetch()) { ?>
  <tr>
    <th> Marque </th>
      <td><?=$a["Marque"] ?></td>
  </tr>
  <tr>
    <th> Modele </th>
      <td><?=$a["Modèle"] ?></td>
  </tr>
  <tr>
    <th> Carburant </th>
      <td><?=$a["Carburant"] ?></td>
  </tr>
<?php } ?>
<?php while(!empty ($_GET['s']) && $a = $carburant->fetch()) { ?>
  <tr>
    <th> Marque </th>
      <td><?=$a["Marque"] ?></td>
  </tr>
  <tr>
    <th> Modele </th>
      <td><?=$a["Modèle"] ?></td>
  </tr>
  <tr>
    <th> Carburant </th>
      <td><?=$a["Carburant"] ?></td>
  </tr>
<?php } ?>

</table>
</font>
</center>
  <div style="text-align: center" >
  <font color="white" size="+1">
  <?php
  $nb_voiture = 6;
  $nb_total = 13;
  $pourcentage = 100;
  
  echo "Notre marque de véhicule la plus publiée est Renault avec : ";
  echo round ($pourcentage * ($nb_voiture / $nb_total),2);
  echo "%"
  ?>
  </font>
  <form action="formulaire.php">
    <strong>
      <br><br><font face="times new roman" size="+2" color="white">Formulaire de mise en vente</font>
    </strong>
    <br>
    <div id="vente">
    <input type="submit" id="query" value="Aller sur le formulaire"/>
    </div>
  </div>
  </form>

</body>

</html>

