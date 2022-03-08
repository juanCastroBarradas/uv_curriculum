<?php

require_once '../../model/ExperienciaDiseno.php';
require_once '../../core/constants.php';


if(isset($_POST["organismo"]) && isset($_POST["periodo"]) && isset($_POST["nivel"]) && isset($_POST["cargo"]) && isset($_POST["identificador"]) && isset($_POST["keyProfesor"])) {
    
    $organismo = $_POST["organismo"];
    $periodo = $_POST["periodo"];
    $nivel = $_POST["nivel"];
    $identificador = $_POST["identificador"];
    $keyProfesor = $_POST["keyProfesor"];
    $cargo = $_POST["cargo"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $experiencia = new ExperienciaDiseno();
    $experiencia->setExperienciaKey($identificador);

    $experiencia->setOrganismo($organismo);
    $experiencia->setPeriodo($periodo);
    $experiencia->setNivel($nivel);
    $experiencia->setCargo($cargo);
    if ($cargo == 5) {
        if (isset($_POST["otroCargo"])) {
            $otroCargo = $_POST["otroCargo"];
            $experiencia->setOtroCargo($otroCargo);
        } else {
            $arrayResponse["msj"] = "No se especifico el cargo.";
            $arrayResponse["status"] = "error";
            header('Content-type: application/json');
            echo json_encode($arrayResponse);
        }
    }
    $experiencia->setProfesionalKey($keyProfesor);

    // Agregamos condicion sobre el id del profesor
    $experiencia->setCondicion("persona_fkey", $experiencia->getProfesionalKey(), IGUAL, NUMERO);
    $experiencia->setCondicion("expediseno_key", $experiencia->getExperienciaKey(), IGUAL, NUMERO);
    $experiencia->actualizaExperiencia();
    
    $experiencia->clearCondicion();
    $experiencia->setCondicion("persona_fkey", $experiencia->getProfesionalKey(), IGUAL, NUMERO);
    $aexperiencia = $experiencia->consultaByIdProfesor();

    $arrayResponse["msj"] = "Se actualizaron correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aexperiencia;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);
}