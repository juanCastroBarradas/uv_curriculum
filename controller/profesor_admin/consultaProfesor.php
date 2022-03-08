<?php

session_start();
require_once '../../model/Profesor.php';
require_once '../../core/constants.php';

$arrayResponse = array("msj" => "La sesion ah caducado.", "status" => "error", "data" => null);
if(isset($_SESSION["profesor"])){
    $dataProfesor = $_SESSION["profesor"];

    if ($dataProfesor['estatus'] == 1) {
        $profesores = new Profesor();
        $profes = $profesores->consultarProfesores();
        if (!empty($profes)) {
            if(count($profes) > 0){
                $arrayResponse["msj"] = "Lista de profesores encontrados.";
                $arrayResponse["status"] = "success";
                $arrayResponse["data"] = $profes;
            }
        } else {
            $arrayResponse["msj"] = "No existe informacion registrada. ".$dataProfesor['estatus'];
            $arrayResponse["status"] = "error";
            $arrayResponse["data"] = [];
        }
    } else {
        $arrayResponse["msj"] = "No cuenta con privilegios de administrador.";
        $arrayResponse["status"] = "error";
        $arrayResponse["data"] = [];
    }
}
header('Content-type: application/json');
echo json_encode($arrayResponse);