<?php

require_once '../../model/FormacionAcademica.php';
require_once '../../core/constants.php';

if(isset($_POST["nivel"]) && isset($_POST["titulo"]) && isset($_POST["institucion"]) && isset($_POST["pais"]) 
    && isset($_POST["yearObtencion"]) && isset($_POST["cedula"]) && isset($_POST["keyProfesor"])) {

    $nivel = $_POST["nivel"];
    $titulo = $_POST["titulo"];
    $institucion = $_POST["institucion"];
    $pais = $_POST["pais"];
    $yearObtencion = $_POST["yearObtencion"];
    $cedula = $_POST["cedula"];
    $keyProfesor = $_POST["keyProfesor"];

    $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

    $formacion = new FormacionAcademica();
    $formacion->setNivel($nivel);
    $formacion->setTitulo($titulo);
    $formacion->setInstituto($institucion);
    $formacion->setPais($pais);
    $formacion->setYearObtencion($yearObtencion);
    $formacion->setNoCedula($cedula);
    $formacion->setProfesionalKey($keyProfesor);

    //egregamos condicion sobre el id del profesor
    $formacion->setCondicion("persona_fkey", $formacion->getProfesionalKey(), IGUAL, NUMERO);

    $resultInsert = $formacion->registraFormacion();
    $aFormacion = $formacion->consultaByIdProfesor();

    $arrayResponse["msj"] = "se registro correctamente los datos.";
    $arrayResponse["status"] = "success";
    $arrayResponse["data"] = $aFormacion;


    header('Content-type: application/json');
    echo json_encode($arrayResponse);
}