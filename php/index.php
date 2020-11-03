<?php

$host = 'db'; //nombre del servicio desde el docker-compose
$user = 'admlinux';
$password = 'admlinux';
$db = 'MedicionesDB';

$conn = new mysqli($host,$user,$password,$db);

if($conn->connect_error){
    echo 'La conexion falló' . $conn->connect_error;
}

echo 'TP Adm Linux Segundo Cuatrimestre 2020<br>';
echo 'Alumnos: Aguero Nicolás y Rota Franco<br><br>';

$datos = $conn->query("SELECT * FROM Tensiones");


?>

<!DOCTYPE HTML>
<html>
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Highcharts Example</title>

                <style type="text/css">
.highcharts-figure, .highcharts-data-table table {
    min-width: 360px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
        font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

                </style>
        </head>
        <body>
<script src="highcharts.js"></script>
<script src="series-label.js"></script>
<script src="exporting.js"></script>
<script src="export-data.js"></script>
<script src="accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Temperatura en funcion del tiempo.
    </p>
</figure>





                <script type="text/javascript">
Highcharts.chart('container', {

    title: {
        text: 'Tensiones'
    },

    subtitle: {
        text: 'Medida con el esp8266'
    },

    yAxis: {
        title: {
            text: 'Tension'
        }
    },

    xAxis: {
        accessibility: {
            rangeDescription: 'Range: 0 to 50'
        }
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 0
        }
    },

    series: [{
        name: 'Tensiones medidas',
                data: [

                        <?php while($user = mysqli_fetch_array($datos)){

                                         echo "[".$user['tension']."], " ;

                                   }
                                   
                        ?>

                ]

    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
                </script>


	</body>


<meta http-equiv="refresh" content="5" />

</html>
