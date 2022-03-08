<?php
session_start();
require_once '../../model/LogroProfesional.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $producto_key = $_POST["identificador"];

    $logro = new LogroProfesional();
    $logro->setLogroKey($producto_key);
    $logro->setProfesionalKey($profesorKey);

    //egregamos condicion sobre el id del profesor
    $logro->setCondicion("persona_fkey", $logro->getProfesionalKey(), IGUAL, NUMERO);
    $logro->setCondicion("logro_key", $logro->getLogroKey(), IGUAL, NUMERO);

    $logro->deleteLogro();

    $logro->clearCondicion();
    $logro->setCondicion("persona_fkey", $logro->getProfesionalKey(), IGUAL, NUMERO);
    $aLogro = $logro->consultaByIdProfesor();

    $arrayResponse["msj"] = "se elimino correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aLogro;

}
header('Content-type: application/json');
echo json_encode($arrayResponse);