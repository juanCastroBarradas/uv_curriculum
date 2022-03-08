<?php
session_start();
require_once '../../model/LogroProfesional.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $relevanciaPE= $_POST["relevanciaPE"];
    $autores= $_POST["autores"];
    $lugarRealizo= $_POST["lugarRealizo"];
    $fechaRealizo= date("Y-m-d", strtotime($_POST["fechaRealizo"]));
    $descripcion= $_POST["descripcion"];
    $identificador = $_POST["identificador"];

    $logro = new LogroProfesional();
    $logro->setLogroKey($identificador);
    $logro->setProfesionalKey($profesorKey);
    //$logro->setRelevanciaPE($relevanciaPE);
    $logro->setAutores($autores);
    $logro->setLugarRealizo($lugarRealizo);
    $logro->setFechaRealizo($fechaRealizo);
    $logro->setDescripcion($descripcion);

    //egregamos condicion sobre el id del profesor
    $logro->setCondicion("persona_fkey", $logro->getProfesionalKey(), IGUAL, NUMERO);
    $logro->setCondicion("logro_key", $logro->getLogroKey(), IGUAL, NUMERO);
    $logro->actualizaLogro();

    $logro->clearCondicion();
    $logro->setCondicion("persona_fkey", $logro->getProfesionalKey(), IGUAL, NUMERO);
    $aLogro = $logro->consultaByIdProfesor();

    $arrayResponse["msj"] = "se registro correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aLogro;


}
header('Content-type: application/json');
echo json_encode($arrayResponse);