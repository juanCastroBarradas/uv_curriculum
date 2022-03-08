<?php

require_once '../../model/ActualizacionDisiplinar.php';
require_once '../../core/constants.php';


if(isset($_POST["tipo"]) && isset($_POST["institucion"]) && isset($_POST["pais"]) 
    && isset($_POST["yearObtencion"]) && isset($_POST["nhoras"]) && isset($_POST["keyProfesor"])) {

    $tipo = $_POST["tipo"];
    $institucion = $_POST["institucion"];
    $pais = $_POST["pais"];
    $yearObtencion = $_POST["yearObtencion"];
    $nhoras = $_POST["nhoras"];
    $keyProfesor = $_POST["keyProfesor"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $actualizacionDisiplinar = new ActualizacionDisiplinar();
    $actualizacionDisiplinar->setTipo($tipo);
    $actualizacionDisiplinar->setInstituto($institucion);
    $actualizacionDisiplinar->setPais($pais);
    $actualizacionDisiplinar->setYearObtencion($yearObtencion);
    $actualizacionDisiplinar->setNoHoras($nhoras);
    $actualizacionDisiplinar->setProfesionalKey($keyProfesor);

    //egregamos condicion sobre el id del profesor
    $actualizacionDisiplinar->setCondicion("persona_fkey", $actualizacionDisiplinar->getProfesionalKey(), IGUAL, NUMERO);

    $actualizacionDisiplinar->registraActualizacion();
    $arrActualizacionDisiplinar = $actualizacionDisiplinar->consultaByIdProfesor();

    $arrayResponse["msj"] = "se registro correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $arrActualizacionDisiplinar;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);
}