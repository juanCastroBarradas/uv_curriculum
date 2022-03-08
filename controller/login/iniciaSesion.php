<?php

session_start();

require_once '../../model/Profesor.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "Faltan datos para el proceso requerido", "status" => "error", "data" => null);
if(isset($_POST["idProfesor"]) && isset($_POST["password"])){
    $idProfesor = $_POST["idProfesor"];
    $password = $_POST["password"];

    $profesor = new Profesor();
    $profesor->setIdProfesor($idProfesor);
    $profesor->setPassword($password);

    //verificamos que exista ningun registro anterior del profesor, validando el numero de trabajador
    $profesor->setCondicion("identificador", $profesor->getIdProfesor(), IGUAL, NUMERO);
    $profesor->setCondicion("contrasena", $profesor->getPassword(), IGUAL, STR);

    $aProfesor = $profesor->consultaCredenciales();

    if(!$aProfesor){
        $arrayResponse["msj"] = "Las credenciales son incorrectas.";
    }else{
        $_SESSION["profesor"] = $aProfesor;
        $arrayResponse["msj"] = "Login exitoso.";
        $arrayResponse["status"] = "success";
        $arrayResponse["data"] = $aProfesor;
        
    }

}

header('Content-type: application/json');
echo json_encode($arrayResponse);