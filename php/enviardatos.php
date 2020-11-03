<?php


$host = 'db'; //nombre del servicio desde el docker-compose
$user = 'admlinux';
$password = 'admlinux';
$db = 'MedicionesDB';


$tension=$_GET['volts'];


$conexion = mysqli_connect($host,$user,$password,$db) or die ("No se ha podido conectar al servidor de Base de Datos");

//$chipid = $_POST ['chipid'];
//$temperatura = $_POST ['temperatura'];

//$fecha = time();
//$consulta = "INSERT INTO Temperatura(id, teperatura, fecha) VALUES (NULL,".$temperatura.", NULL)";
$consulta =" INSERT INTO `Tensiones` (`id`, `tension`, `fecha`) VALUES (NULL, ".$tension.", NOW())";

$resultado = mysqli_query( $conexion, $consulta);

//mysqli_query("INSERT INTO `Mercado`.`Temperatura` (`id`, `teperatura`, `fecha`) VALUES (NULL, '$temperatura',  '$fecha');");




?>
