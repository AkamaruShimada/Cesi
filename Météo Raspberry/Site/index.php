<!DOCTYPE html>
<html>
<title>Météo</title>

<link rel="stylesheet" href="index.css">

<head>
<?php
include ("db_connect.php");
$req = 'SELECT Site,Temp,Humidity,Pressure,Time FROM statement INNER JOIN sensor ON statement.ID_Sensor = sensor.ID WHERE ID LIKE "1" ORDER BY Time DESC LIMIT 1';

$result = mysqli_query($conn,$req);
$row = mysqli_fetch_row($result);

$temp = $row[1];
$hum = $row[2];
$pres = $row[3];

if($temp >= 20) {
  echo("<img id=tb src=images/image6.png width=140 height=240>");
} else if($temp > 16 && $temp < 20) {
  echo("<img id=tb src=images/image2.png width=200 height=200>");
} else {
  echo("<img id=tb src=images/image4.png width=200 height=230>");
}

if($hum >= 70) {
  echo("<img id=lb src=images/goutte3.png width=200 height=200>");
} else if($hum > 40 && $hum < 70) {
  echo("<img id=lb src=images/goutte2.png width=200 height=200>");
} else {
  echo("<img id=lb src=images/goutte1.png width=200 height=200>");
}

if($pres > 1020) {
  echo("<img id=pb src=images/imag6.png width=200 height=200>");
} else if($pres > 1010 && $temp < 1020) {
  echo("<img id=pb src=images/imag2.png width=200 height=200>");
} else {
  echo("<img id=pb src=images/imag4.png width=200 height=200>");
}
?>


<br><br>
<font face="sans-serif" size="+3" color="black" id="text"><?=$row[0]?> </font>
<font face="sans-serif" size="+3" color="black" id="time"><?=$row[4]?></font>

<br><br>
<font face="sans-serif" size="+5" color="black" id="temp">Température:</font>
<font face="sans-serif" size="+5" color="black" id="hum">Humidité:</font>
<font face="sans-serif" size="+5" color="black" id="pres">Pression:</font>
<br>
<font face="sans-serif" size="+5" color="black" id="temp2"><?=$temp?>°C</font>
<font face="sans-serif" size="+5" color="black" id="hum2"><?=$hum?>%</font>
<font face="sans-serif" size="+5" color="black" id="pres2"><?=$pres?>hPa</font>

</head>

</body>

  <div style="text-align: center" >

  <form action="capteurs.php">
    <font face="sans-serif" size="+4" color="black">Afficher la liste des capteurs</font>
    <br>
    <div id="button">
      <input type="submit" id="query" value="Aller sur la liste"/>
    </div>
  </div>
  </form>

</body>

</html>

