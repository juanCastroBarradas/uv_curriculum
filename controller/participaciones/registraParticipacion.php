<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../model/Participacion.php';
require_once '../../core/constants.php';


if(isset($_POST["organismo"]) && isset($_POST["periodo"]) && isset($_POST["nivel"]) && isset($_POST["fechaInicio"]) && isset($_POST["keyProfesor"])) {
    
    $organismo = $_POST["organismo"]; 
    $periodo = $_POST["periodo"];
    $nivel = $_POST["nivel"];
    $fechaInicio = $_POST["fechaInicio"];
    if ($nivel == 6) {
        if (isset($_POST["otroNivel"])) {
            $otro = $_POST["otroNivel"];
        } else {
            $arrayResponse["msj"] = "No se especifico la participacion.";
            $arrayResponse["status"] = "error";
            header('Content-type: application/json');
            echo json_encode($arrayResponse);
        }
    }
    $keyProfesor = $_POST["keyProfesor"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $participacion = new Participacion();
    $participacion->setOrganismo($organismo);
    $participacion->setPeriodo($periodo);
    $participacion->setNivel($nivel);
    $participacion->setFechaInicio($fechaInicio);
    if ($nivel == 6) {
        $participacion->setEspecifinivel($otro);
    }

    $participacion->setProfesionalKey($keyProfesor);

    // Agregamos condicion sobre el id del profesor
    $participacion->setCondicion("persona_fkey", $participacion->getProfesionalKey(), IGUAL, NUMERO);

    $participacion->registraParticipacion();
    $aParticipacion = $participacion->consultaByIdProfesor();

    $arrayResponse["msj"] = "Se registraron correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aParticipacion;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);
}