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
    $tipo= $_POST["tipo"];
    $nivel= isset($_POST["nivel"]) ? $_POST["nivel"]: 0;
    $fechaInicio= $_POST["fechaInicio"];
    $fechaFinal= $_POST["fechaFinal"];
    $descripcion= $_POST["descripcion"];

    $reconocimiento = new Reconocimiento();
    $reconocimiento->setProfesionalKey($profesorKey);
    $reconocimiento->setTipo($tipo);
    $reconocimiento->setNivel($nivel);
    $reconocimiento->setFechaInicio($fechaInicio);
    $reconocimiento->setFechaFin($fechaFinal);
    $reconocimiento->setDescripcion($descripcion);

    //egregamos condicion sobre el id del profesor
    $reconocimiento->setCondicion("persona_fkey", $reconocimiento->getProfesionalKey(), IGUAL, NUMERO);

    $reconocimiento->registraReconocimiento();
    $aReconocimiento = $reconocimiento->consultaByIdProfesor();

    $arrayResponse["msj"] = "se registro correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aReconocimiento;


}
header('Content-type: application/json');
echo json_encode($arrayResponse);