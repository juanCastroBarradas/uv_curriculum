<?php

require_once '../../core/DBConnection.php';
class Reconocimiento{
    private $_tablaName;
    private $conexion;
    private $reconocimiento_key;
    private $tipo;
    private $nivel;
    private $fechaInicio;
    private $fechaFin;
    private $descripcion;
    private $profesionalKey;
    private $_condiciones;
    private $responseResult;

    function __construct() {
        $this->_tablaName = 'reconocimiento';
        $this->conexion = new DBConnection();
        $this->_condiciones = array();
        $this->responseResult = array("msj" => "", "status" => "error", "data" => null);
    }

    public function setReconocimientoKey($reconocimiento_key){
        $this->reconocimiento_key = $reconocimiento_key;
    }
    public function getReconocimientoKey(){
        return $this->reconocimiento_key;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function setNivel($nivel){
        $this->nivel = $nivel;
    }

    public function getNivel(){
        return $this->nivel;
    }

    public function setFechaInicio($fechaInicio){
        $this->fechaInicio = date('Y-m-d',strtotime($fechaInicio));
    }

    public function getFechaInicio(){
        return $this->fechaInicio;
    }

    public function setFechaFin($fechaFin){
        $this->fechaFin = date('Y-m-d',strtotime($fechaFin));
    }

    public function getFechaFin(){
        return $this->fechaFin;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setProfesionalKey($profesionalKey){
        $this->profesionalKey = $profesionalKey;
    }
    public function getProfesionalKey(){
        return $this->profesionalKey;
    }

    public function registraReconocimiento(){
        $this->conexion->beginTransactionPDO();
        try{

            $SQL = "INSERT INTO ".DB_NAME.".".$this->_tablaName." (tipo, nivel, fecha_inicio, fecha_fin, descripcion, persona_fkey)
                VALUES(:tipo, :nivel, :fecha_inicio, :fecha_fin, :descripcion, :persona_fkey);";

            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':tipo', $this->tipo);
            $result->bindParam(':nivel', $this->nivel);
            $result->bindParam(':fecha_inicio', $this->fechaInicio);
            $result->bindParam(':fecha_fin', $this->fechaFin);
            $result->bindParam(':descripcion', $this->descripcion);
            $result->bindParam(':persona_fkey', $this->profesionalKey);
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

    public function actualizaReconocimiento(){
        $this->conexion->beginTransactionPDO();
        try{
            $where = $this->getCondicion();
            $SQL = "UPDATE ".DB_NAME.".".$this->_tablaName." SET tipo = :tipo, nivel = :nivel, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, descripcion = :descripcion ".$where;

            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':tipo', $this->tipo);
            $result->bindParam(':nivel', $this->nivel);
            $result->bindParam(':fecha_inicio', $this->fechaInicio);
            $result->bindParam(':fecha_fin', $this->fechaFin);
            $result->bindParam(':descripcion', $this->descripcion);
            $result->execute();

            $this->conexion->commitPDO();
            $this->responseResult["msj"] = "La actualizacion fue exitoso.";
            $this->responseResult["status"] = "success";

        }catch(PDOException $e){
            $this->conexion->rollBackPDO();
            $this->responseResult["msj"] = "Error en SQL [".$e->getMessage()."]";
            $this->responseResult["status"] = "error";

        }

        return $this->responseResult;
    }

    public function deleteReconocimiento(){
        $where = $this->getCondicion();
        $SQL = "DELETE FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
    }

    public function consultaByIdProfesor(){
        $where = $this->getCondicion();
        $SQL = "SELECT reconocimiento_key, tipo, nivel, fecha_inicio, fecha_fin, descripcion, persona_fkey
            FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
        $arrayFormacion = $result->fetchAll(PDO::FETCH_ASSOC);
        
        return $arrayFormacion;
    }

    /**
     * se borran los filtros de condicion
     * la sentencia where
     */
    public function clearCondicion(){
        $this->_condiciones = array();
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