<?php
require_once '../../model/ExperienciaDiseno.php';
require_once '../../core/constants.php';


if(isset($_POST["organismo"]) && isset($_POST["periodo"]) && isset($_POST["nivel"]) && isset($_POST["cargo"]) && isset($_POST["keyProfesor"])) {
    
    $organismo = $_POST["organismo"];
    $periodo = $_POST["periodo"];
    $nivel = $_POST["nivel"];
    $cargo = $_POST["cargo"];
    
    $keyProfesor = $_POST["keyProfesor"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $experiencia = new ExperienciaDiseno();
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

    $experiencia->registraExperiencia();
    $aExperiencia = $experiencia->consultaByIdProfesor();

    $arrayResponse["msj"] = "Se registraron correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aExperiencia;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);
}