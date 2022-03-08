<?php

require_once '../../model/ExperienciaProfesional.php';
require_once '../../core/constants.php';


if(isset($_POST["puesto"]) && isset($_POST["empresa"]) && isset($_POST["fechaFinal"]) && isset($_POST["fechaInicio"]) 
    && isset($_POST["keyProfesor"])) {
    
    $puesto = $_POST["puesto"];
    $empresa = $_POST["empresa"];
    $fechfin = $_POST["fechaFinal"];
    $fechini = $_POST["fechaInicio"];
    $keyProfesor = $_POST["keyProfesor"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $experiencia = new ExperienciaProfesional();
    $experiencia->setPuesto($puesto);
    $experiencia->setEmpresa($empresa);
    $experiencia->setFechaInicio($fechini);
    $experiencia->setFechaFin($fechfin);
    $experiencia->setProfesionalKey($keyProfesor);

    // Agregamos condicion sobre el id del profesor
    $experiencia->setCondicion("persona_fkey", $experiencia->getProfesionalKey(), IGUAL, NUMERO);

    $experiencia->registraExperiencia();
    $aExperiencia = $experiencia->consultaByIdProfesor();

    $arrayResponse["msj"] = "Se registraron correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aExperiencia;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);
}