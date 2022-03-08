<?php

require_once '../../model/ExperienciaProfesional.php';
require_once '../../core/constants.php';

if(isset($_POST["experiencia_key"]) && isset($_POST["persona_fkey"])){
    $experiencia_key = $_POST["experiencia_key"];
    $persona_fkey = $_POST["persona_fkey"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $experiencia = new ExperienciaProfesional();
    $experiencia->setExperienciaKey($experiencia_key);
    $experiencia->setProfesionalKey($persona_fkey);

    // agregamos condicion sobre el id del profesor
    $experiencia->setCondicion("persona_fkey", $experiencia->getProfesionalKey(), IGUAL, NUMERO);
    $experiencia->setCondicion("experiencia_key", $experiencia->getExperienciaKey(), IGUAL, NUMERO);

    $experiencia->eliminaExperiencia();

    $experiencia->clearCondicion();
    $experiencia->setCondicion("persona_fkey", $experiencia->getProfesionalKey(), IGUAL, NUMERO);
    $aexperiencia = $experiencia->consultaByIdProfesor();

    $arrayResponse["msj"] = "Se eliminaron correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aexperiencia;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);

}