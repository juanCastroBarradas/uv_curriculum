<?php

require_once '../../core/DBConnection.php';
class Persona{
    private $_tablaName;
    private $conexion;
    private $personaKey;
    private $apPaterno;
    private $apMaterno;
    private $nombre;
    private $fechaNacimiento;
    private $noProfesor;
    private $nombramiento;
    private $antiguedad;
    private $fechaContratacion;
    private $tipoContratacion;
    private $_condiciones;
    private $responseResult;

    function __construct() {
        $this->_tablaName = 'persona';
        $this->conexion = new DBConnection();
        $this->_condiciones = array();
        $this->responseResult = array("msj" => "", "status" => "error", "data" => null);
    }

    public function setApPaterno($apPaterno){
        $this->apPaterno = $apPaterno;
    }

    public function getApPaterno(){
        return $this->apPaterno;
    }

    public function setApMaterno($apMaterno){
        $this->apMaterno = $apMaterno;
    }

    public function getApMaterno(){
        return $this->apMaterno;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setFechaNacimiento($fechaNacimiento){
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getFechaNacimiento(){
        return $this->fechaNacimiento;
    }

    public function setNoProfesor($noProfesor){
        $this->noProfesor = $noProfesor;
    }

    public function getNoProfesor(){
        return $this->noProfesor;
    }

    public function setNombramiento($nombramiento){
        $this->nombramiento = $nombramiento;
    }

    public function getNombramiento(){
        return $this->nombramiento;
    }

    public function setAntiguedad($antiguedad){
        $this->antiguedad = $antiguedad;
    }

    public function getAntiguedad(){
        return $this->antiguedad;
    }

    public function setFechaContratacion($fechaContratacion){
        $this->fechaContratacion = $fechaContratacion;
    }

    public function getFechaContratacion(){
        return $this->fechaContratacion;
    }

    public function setTipoContratacion($tipoContratacion){
        $this->tipoContratacion = $tipoContratacion;
    }

    public function getTipoContratacion(){
        return $this->tipoContratacion;
    }

    public function registraPersona(){
        $conn = $this->conexion->getPDOConnection2();

        var_dump($conn);


        $this->conexion->beginTransactionPDO();
        try{

            $SQL = "INSERT INTO ".DB_NAME.".".$this->_tablaName." (apPaterno, apMaterno, nombre, fechaNacimiento, noProfesor, nombramiento, antiguedad, fechaContratacion)
                VALUES(:apPaterno, :apMaterno, :nombre, :fechaNacimiento, :noProfesor, :nombramiento, :antiguedad, :fechaContratacion);";

            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':apPaterno', $this->apPaterno);
            $result->bindParam(':apMaterno', $this->apMaterno);
            $result->bindParam(':nombre', $this->nombre);
            $result->bindParam(':fechaNacimiento', $this->fechaNacimiento);
            $result->bindParam(':noProfesor', $this->noProfesor);
            $result->bindParam(':nombramiento', $this->nombramiento);
            $result->bindParam(':antiguedad', $this->antiguedad);
            $result->bindParam(':fechaContratacion', $this->fechaContratacion);
            $result->execute();

            $this->conexion->commitPDO();
            $this->responseResult["msj"] = "el registro fue exitoso.";
            $this->responseResult["status"] = "success";

        }catch(PDOException $e){
            $this->conexion->rollBackPDO();
            $this->responseResult["msj"] = "Error en SQL [".$e->getMessage()."]";
            $this->responseResult["status"] = "error";

        }

        return $this->responseResult;
    }

    public function actualizaPersona(){
        $this->conexion->beginTransactionPDO();
        try{

            $SQL = "UPDATE ".DB_NAME.".".$this->_tablaName."
                SET apPaterno=:apPaterno, apMaterno=:apMaterno, nombre=:nombre, fechaNacimiento=:fechaNacimiento, noProfesor=:noProfesor, 
                    nombramiento=:nombramiento, antiguedad=:antiguedad, fechaContratacion=:fechaContratacion, tipoContratacion=:tipoContratacion
                ".$where;
            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':apPaterno', $this->apPaterno);
            $result->bindParam(':apMaterno', $this->apMaterno);
            $result->bindParam(':nombre', $this->nombre);
            $result->bindParam(':fechaNacimiento', $this->fechaNacimiento);
            $result->bindParam(':noProfesor', $this->noProfesor);
            $result->bindParam(':nombramiento', $this->nombramiento);
            $result->bindParam(':antiguedad', $this->antiguedad);
            $result->bindParam(':fechaContratacion', $this->fechaContratacion);
            $result->bindParam(':tipoContratacion', $this->tipoContratacion);
            $result->execute();

            $this->conexion->commitPDO();
            $this->responseResult["msj"] = "el registro fue exitoso.";
            $this->responseResult["status"] = "success";

        }catch(PDOException $e){
            $this->conexion->rollBackPDO();
            $this->responseResult["msj"] = "Error en SQL [".$e->getMessage()."]";
            $this->responseResult["status"] = "error";

        }

        return $this->responseResult;
    }

    public function consultaByNoProfesor(){
        $where = $this->getCondicion();
        $SQL = "SELECT persona_key, apPaterno, apMaterno, nombre, DATE_FORMAT(fechaNacimiento, '%d/%m/%Y') as fechaNacimiento, noProfesor, 
                    nombramiento, antiguedad, DATE_FORMAT(fechaContratacion, '%d/%m/%Y') as fechaContratacion, tipoContratacion
            FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
        $arrayPersonas = $result->fetch(PDO::FETCH_ASSOC);
        
        return $arrayPersonas;
    }

    /**
     * genera un arreglo con las condiciones que tendra
     * la sentencia where
     */
    public function setCondicion($campo, $valor, $filtro, $tipoDato){
        $valor = ($tipoDato == STR)? "'".$valor."'": $valor;
        $addCondicion = array($campo => array("valor" => $valor, "operador" => $filtro));
        array_push($this->_condiciones, $addCondicion);
    }

    /**
     * devuelve una cadena con una sentencia where
     * conforme a los atributos que se hallan seteando
     * atraves del los seters de cada atributo de la clase
     */
    public function getCondicion(){
        $where = '';
        if(!empty($this->_condiciones)){
            $where = ' where ';
            $campos = 1;
            foreach($this->_condiciones as $condicion){
                foreach($condicion as $columna => $sentencia){
                    $and = ($campos > 1)? " AND ": "";
                    $where .= $and.$columna." ".$sentencia["operador"]." ".$sentencia["valor"];
                    $campos++;
                }
            }
        }

        return $where;
    }

}