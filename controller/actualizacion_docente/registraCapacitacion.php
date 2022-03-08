<?php

require_once '../../model/CapacitacionDocente.php';
require_once '../../core/constants.php';


if(isset($_POST["tipo"]) && isset($_POST["titulo"]) && isset($_POST["institucion"]) && isset($_POST["pais"]) 
    && isset($_POST["yearObtencion"]) && isset($_POST["nhoras"]) && isset($_POST["keyProfesor"])) {
    
    $tipo = $_POST["tipo"];
    $titulo = $_POST["titulo"];
    $institucion = $_POST["institucion"];
    $pais = $_POST["pais"];
    $yearObtencion = $_POST["yearObtencion"];
    $nhoras = $_POST["nhoras"];
    $keyProfesor = $_POST["keyProfesor"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $capacitacion = new CapacitacionDocente();
    $capacitacion->setTipo($tipo);
    $capacitacion->setTitulo($titulo);
    $capacitacion->setInstituto($institucion);
    $capacitacion->setPais($pais);
    $capacitacion->setYearObtencion($yearObtencion);
    $capacitacion->setNoHoras($nhoras);
    $capacitacion->setProfesionalKey($keyProfesor);

    //egregamos condicion sobre el id del profesor
    $capacitacion->setCondicion("persona_fkey", $capacitacion->getProfesionalKey(), IGUAL, NUMERO);

    $capacitacion->registraCapacitacion();
    $aCapacitacion = $capacitacion->consultaByIdProfesor();

    $arrayResponse["msj"] = "se registro correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aCapacitacion;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);
}