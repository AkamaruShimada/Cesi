<!DOCTYPE html>
<html>
<meta charset="utf-8">

<link rel="stylesheet" href="graph.css">
<header>
    <font size="5pt"> Graphiques en temps réel du <script>document.write(new Date().toLocaleDateString());</script>
    </font>
</header>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js">
    </script>
</head>

<body>
    <select id="choix">
        <option value="">Séléctioner un capteur</option>
        <?php
        $conn = mysqli_connect("localhost", "root", "cesi", "meteo");
        $query = "SELECT ID FROM sensor";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['ID'] . "'>" . $row['ID'] . "</option>";
        }
        ?>
    </select>
    <script>
        var selectedId = '';

        var idSelector = document.getElementById("choix");
        idSelector.addEventListener("change", function () {
            chart1.data.labels = [];
            chart1.data.datasets[0].data = [];
            chart1.update();
            chart2.data.labels = [];
            chart2.data.datasets[0].data = [];
            chart2.update();
            chart3.data.labels = [];
            chart3.data.datasets[0].data = [];
            chart3.update();
            selectedId = idSelector.value
            console.log(selectedId);
        });
    </script>

    <canvas id="myChart1"></canvas>
    <script>
        var ctx = document.getElementById('myChart1').getContext('2d');
        var chart1 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Température",
                        data: [],
                        borderColor: "#3e95cd",
                        fill: false
                    },
                ]
            },
            options: {
                scales: {
                    xAxes: [{
                        display: false
                    }]
                }
            }

        });

        setInterval(function () {
            // R??cup??ration des donn??es ?? partir de l'API
            fetch('http://192.168.195.115/api.php?id=' + selectedId)
                .then(response => response.json())
                .then(data => {
                    chart1.data.labels.push(new Date(data["Time"]).toLocaleTimeString("fr-FR"));
                    chart1.data.datasets[0].data.push(data["Temp"]);
                    chart1.update();
                });
        }, 1000);
    </script>
    <canvas id="myChart2"></canvas>
    <script>
        var ctx = document.getElementById('myChart2').getContext('2d');
        var chart2 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Humidité",
                        data: [],
                        borderColor: "#8e5ea2",
                        fill: false
                    },
                ]
            },
            options: {
                scales: {
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });

        setInterval(function () {
            // R??cup??ration des donn??es ?? partir de l'API
            fetch('http://192.168.195.115/api.php?id=' + selectedId)
                .then(response => response.json())
                .then(data => {
                    ;
                    chart2.data.labels.push(new Date(data["Time"]).toLocaleTimeString("fr-FR"));
                    chart2.data.datasets[0].data.push(data["Humidity"]);
                    chart2.update();
                });
        }, 1000);
    </script>
    <canvas id="myChart3"></canvas>
    <script>
        var ctx = document.getElementById('myChart3').getContext('2d');
        var chart3 = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "Pression",
                        data: [],
                        borderColor: "#3cba9f",
                        fill: false
                    }
                ]
            },
            options: {}
        });

        setInterval(function () {
            // R??cup??ration des donn??es ?? partir de l'API
            fetch('http://192.168.195.115/api.php?id=' + selectedId)
                .then(response => response.json())
                .then(data => {
                    chart3.data.labels.push(new Date(data["Time"]).toLocaleTimeString("fr-FR"));
                    chart3.data.datasets[0].data.push(data["Pressure"]);
                    chart3.update();
                });
        }, 1000);
    </script>
</body>

</html>
