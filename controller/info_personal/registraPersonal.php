<?php

require_once '../../model/Persona.php';
require_once '../../core/constants.php';

if(isset($_POST["apPaterno"]) && isset($_POST["apMaterno"]) && isset($_POST["nombre"]) && isset($_POST["noProfesor"]) 
    && isset($_POST["dateOfBirth"]) && isset($_POST["nombramiento"]) && isset($_POST["antiguedad"]) && isset($_POST["feContratacion"]) && isset($_POST["tipoContratacion"])) {

        $apPaterno = $_POST["apPaterno"];
        $apMaterno = $_POST["apMaterno"];
        $nombre = $_POST["nombre"];
        $noProfesor = $_POST["noProfesor"];
        $dateOfBirth = date("Y-m-d", strtotime($_POST["dateOfBirth"]));
        $nombramiento = $_POST["nombramiento"];
        $antiguedad = $_POST["antiguedad"];
        $feContratacion = date("Y-m-d", strtotime($_POST["feContratacion"]));
        $tipoContratacion = $_POST["tipoContratacion"];

        $arrayResponse = array("msj" => "", "status" => "error", "data" => null);

        $persona = new Persona();
        $persona->setApPaterno($apPaterno);
        $persona->setApMaterno($apMaterno);
        $persona->setNombre($nombre);
        $persona->setNoProfesor($noProfesor);
        $persona->setFechaNacimiento($dateOfBirth);
        $persona->setNombramiento($nombramiento);
        $persona->setAntiguedad($antiguedad);
        $persona->setFechaContratacion($feContratacion);
        $persona->setTipoContratacion($tipoContratacion);

        //verificamos que no exista ningun registro anterior del profesor, validando el numero de trabajador
        $persona->setCondicion("noProfesor", $persona->getNoProfesor(), IGUAL, NUMERO);
        $aPersona = $persona->consultaByNoProfesor();

        if(count($aPersona) == 0){
            $persona->registraPersona();
            $aPersona = $persona->consultaByNoProfesor();

            $arrayResponse["msj"] = "se registro correctamente los datos.";
            $arrayResponse["status"] = "success";            
        }else{
            $arrayResponse["msj"] = "El ID del profesor [".$aPersona["noProfesor"]."] ya fue registrado, se listara la información recuperda.";
        }
        $arrayResponse["data"] = $aPersona;

        header('Content-type: application/json');
	    echo json_encode($arrayResponse);

}