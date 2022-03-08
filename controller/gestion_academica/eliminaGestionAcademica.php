<?php

require_once '../../model/GestionAcademica.php';
require_once '../../core/constants.php';

if(isset($_POST["gestion_key"]) && isset($_POST["persona_fkey"])){
    $gestion_key = $_POST["gestion_key"];
    $persona_fkey = $_POST["persona_fkey"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $gestion = new GestionAcademica();
    $gestion->setGestionKey($gestion_key);
    $gestion->setProfesionalKey($persona_fkey);

    //egregamos condicion sobre el id del profesor
    $gestion->setCondicion("persona_fkey", $gestion->getProfesionalKey(), IGUAL, NUMERO);
    $gestion->setCondicion("gestion_key", $gestion->getGestionKey(), IGUAL, NUMERO);

    $gestion->eliminaGestion();

    $gestion->clearCondicion();
    $gestion->setCondicion("persona_fkey", $gestion->getProfesionalKey(), IGUAL, NUMERO);
    $agestion = $gestion->consultaByIdProfesor();

    $arrayResponse["msj"] = "Se eliminaron correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $agestion;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);

}