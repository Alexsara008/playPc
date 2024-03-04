<?php
$servidor="localhost";
$baseDeDatos="website";
$usuario="root";
$contrasena="";

try{
    // el PDO es una clase que nos permite conectarnos a la base de datos
    $conexion=new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasena);


}catch(Exception $error){
    echo $error->getMessage();
}



?>