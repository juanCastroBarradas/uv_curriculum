<?php
session_start();
require_once '../../model/ProductoAcademico.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];
    $profesorKey = $dataProfesor["persona_key"];
    $producto = $_POST["producto"];
    $fechaPublicacion = date("Y-m-d", strtotime($_POST["fechaPublicacion"]));

    $productoAcademico = new ProductoAcademico();
    $productoAcademico->setProfesionalKey($profesorKey);
    $productoAcademico->setDescripcion($producto);
    $productoAcademico->setFechaPublicacion($fechaPublicacion);

    //egregamos condicion sobre el id del profesor
    $productoAcademico->setCondicion("persona_fkey", $productoAcademico->getProfesionalKey(), IGUAL, NUMERO);

    $productoAcademico->registraProducto();
    $aProductoAcademico = $productoAcademico->consultaByIdProfesor();

    $arrayResponse["msj"] = "se registro correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aProductoAcademico;


}
header('Content-type: application/json');
echo json_encode($arrayResponse);