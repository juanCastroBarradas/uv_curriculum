<?php
session_start();
require_once '../../model/ProductoAcademico.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];

    $logro_key = $_POST["logro_key"];

    $logro = new ProductoAcademico();
    $logro->setProductoKey($logro_key);
    $logro->setProfesionalKey($profesorKey);

    //egregamos condicion sobre el id del profesor
    $logro->setCondicion("persona_fkey", $logro->getProfesionalKey(), IGUAL, NUMERO);
    $logro->setCondicion("logro_key", $logro->getProductoKey(), IGUAL, NUMERO);

    $logro->deleteProducto();

    $logro->clearCondicion();
    $logro->setCondicion("persona_fkey", $logro->getProfesionalKey(), IGUAL, NUMERO);
    $aLogro = $producto->consultaByIdProfesor();

    $arrayResponse["msj"] = "se elimino correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aLogro;


}
header('Content-type: application/json');
echo json_encode($arrayResponse);