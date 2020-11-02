<?php


$host = 'db'; //nombre del servicio desde el docker-compose
$user = 'admlinux';
$password = 'admlinux';
$db = 'Mercado';


$temperatura=$_GET['temp'];


$conexion = mysqli_connect($host,$user,$password,$db) or die ("No se ha podido conectar al servidor de Base de Datos");

//$chipid = $_POST ['chipid'];
//$temperatura = $_POST ['temperatura'];

//$fecha = time();
//$consulta = "INSERT INTO Temperatura(id, teperatura, fecha) VALUES (NULL,".$temperatura.", NULL)";
$consulta =" INSERT INTO `Temperatura` (`id`, `teperatura`, `fecha`) VALUES (NULL, ".$temperatura.", NOW())";

$resultado = mysqli_query( $conexion, $consulta);

//mysqli_query("INSERT INTO `Mercado`.`Temperatura` (`id`, `teperatura`, `fecha`) VALUES (NULL, '$temperatura',  '$fecha');");




$ActualizarDespuesDe = 10;
// // Envíe un encabezado Refresh al navegador preferido.
header('Refresh: '.$ActualizarDespuesDe);


?>