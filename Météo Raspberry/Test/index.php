<!DOCTYPE html>
<title>Météo Cubes2</title>

<html> 
<?php
$servername="raspNico";
$sqluser="pibdd";
$sqlpass="cesi";
$db="cesibdd";

$connect =mysqli_connect($servername,$sqluser,$sqlpass,$db);

if(!$connect)
{
die("Connection Failed.<br>".mysqli_error());
}
//echo "Ca marche";
?>

<link rel="stylesheet" href="CSS.css">

<head>
    
    <div id="bande">
        <strong>
            <br><center><font face="times new roman" size="+4" color="black">Chercher un capteur :</font></center>
        </strong>
    </div>

</head>

<body>
    
<div id="chercher"> 

    <input type="search" id="query" name="s" placeholder="Recherchez...">
    <input type="search" id="query" name="s" placeholder="Recherchez...">
    <input type="search" id="query" name="s" placeholder="Recherchez...">
    <input type="search" id="query" name="s" placeholder="Recherchez...">
    <button><svg viewBox="0 0 1024 1024"><path class="path1" d="M848.471 928l-263.059-263.059c-48.941 36.706-110.118 55.059-177.412 55.059-171.294 0-312-140.706-312-312s140.706-312 312-312c171.294 0 312 140.706 312 312 0 67.294-24.471 128.471-55.059 177.412l263.059 263.059-79.529 79.529zM189.623 408.078c0 121.364 97.091 218.455 218.455 218.455s218.455-97.091 218.455-218.455c0-121.364-103.159-218.455-218.455-218.455-121.364 0-218.455 97.091-218.455 218.455z"></path></svg>
    </button>

</div>
    
<form action="formulaire.php">
    <div style="text-align: center" id="text">
        <strong>
            <br><br><font face="times new roman" size="+2" color="black">Formulaire de mise en vente</font>
        </strong>
        <br>
        <div id="insert_capteur">
            <input type="submit" id="query" value="Aller sur le formulaire"/>
        </div>
    </div>
</form>



</body>




</html>