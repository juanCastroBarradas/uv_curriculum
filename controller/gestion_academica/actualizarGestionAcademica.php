<?php

require_once '../../model/GestionAcademica.php';
require_once '../../core/constants.php';


if(isset($_POST["puesto"]) && isset($_POST["institucion"]) && isset($_POST["fechaFinal"]) && isset($_POST["fechaInicio"]) 
&& isset($_POST["identificador"]) && isset($_POST["keyProfesor"])) {
    
    $puesto = $_POST["puesto"];
    $institucion = $_POST["institucion"];
    $fechfin = $_POST["fechaFinal"];
    $fechini = $_POST["fechaInicio"];
    $actual = (empty($_POST["actual"]))? 2:1;
    $identificador = $_POST["identificador"];
    $keyProfesor = $_POST["keyProfesor"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $gestion = new GestionAcademica();
    $gestion->setGestionKey($identificador);

    $gestion->setPuesto($puesto);
    $gestion->setInstituto($institucion);
    $gestion->setFechaInicio($fechini);
    $gestion->setFechaFin($fechfin);
    $gestion->setActual($actual);
    $gestion->setProfesionalKey($keyProfesor);

    // Agregamos condicion sobre el id del profesor
    $gestion->setCondicion("persona_fkey", $gestion->getProfesionalKey(), IGUAL, NUMERO);
    $gestion->setCondicion("gestion_key", $gestion->getGestionKey(), IGUAL, NUMERO);
    $gestion->actualizaGestion();
    
    $gestion->clearCondicion();
    $gestion->setCondicion("persona_fkey", $gestion->getProfesionalKey(), IGUAL, NUMERO);
    $agestion = $gestion->consultaByIdProfesor();

    $arrayResponse["msj"] = "Se actualizaron correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $agestion;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);
}