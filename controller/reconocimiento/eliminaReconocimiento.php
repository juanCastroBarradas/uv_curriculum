<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../../model/Reconocimiento.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $producto_key = $_POST["identificador"];

    $reconocimiento = new Reconocimiento();
    $reconocimiento->setReconocimientoKey($producto_key);
    $reconocimiento->setProfesionalKey($profesorKey);

    //egregamos condicion sobre el id del profesor
    $reconocimiento->setCondicion("persona_fkey", $reconocimiento->getProfesionalKey(), IGUAL, NUMERO);
    $reconocimiento->setCondicion("reconocimiento_key", $reconocimiento->getReconocimientoKey(), IGUAL, NUMERO);

    $reconocimiento->deleteReconocimiento();

    $reconocimiento->clearCondicion();
    $reconocimiento->setCondicion("persona_fkey", $reconocimiento->getProfesionalKey(), IGUAL, NUMERO);
    $aReconocimiento = $reconocimiento->consultaByIdProfesor();

    $arrayResponse["msj"] = "se elimino correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aReconocimiento;

}
header('Content-type: application/json');
echo json_encode($arrayResponse);