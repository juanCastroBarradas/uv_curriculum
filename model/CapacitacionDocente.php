<?php

require_once '../../core/DBConnection.php';
class CapacitacionDocente{
    private $_tablaName;
    private $conexion;
    private $capacitacion_key;
    public $tipo;
    public $titulo;
    public $instituto;
    public $pais;
    public $yearObtencion;
    public $noHoras;
    private $profesionalKey;
    private $_condiciones;
    private $responseResult;

    function __construct() {
        $this->_tablaName = 'capacitaciondocente';
        $this->conexion = new DBConnection();
        $this->_condiciones = array();
        $this->responseResult = array("msj" => "", "status" => "error", "data" => null);
    }

    public function setCapacitacionKey($capacitacion_key){
        $this->capacitacion_key = $capacitacion_key;
    }
    public function getCapacitacionKey(){
        return $this->capacitacion_key;
    }

    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    public function getTipo(){
        return $this->tipo;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }
    public function getTitulo(){
        return $this->titulo;
    }

    public function setInstituto($instituto){
        $this->instituto = $instituto;
    }
    public function getInstituto(){
        return $this->instituto;
    }

    public function setPais($pais){
        $this->pais = $pais;
    }
    public function getPais(){
        return $this->pais;
    }

    public function setYearObtencion($yearObtencion){
        $this->yearObtencion = $yearObtencion;
    }
    public function getYearObtencion(){
        return $this->yearObtencion;
    }

    public function setNoHoras($noHoras){
        $this->noHoras = $noHoras;
    }
    public function getNoHoras(){
        return $this->noHoras;
    }

    public function setProfesionalKey($profesionalKey){
        $this->profesionalKey = $profesionalKey;
    }
    public function getProfesionalKey(){
        return $this->profesionalKey;
    }

    public function registraCapacitacion(){
        $this->conexion->beginTransactionPDO();
        try{

            $SQL = "INSERT INTO ".DB_NAME.".".$this->_tablaName." (tipo, titulo, instituto, pais, yearObtencion, noHoras, persona_fkey)
                VALUES(:tipo, :titulo, :instituto, :pais, :yearObtencion, :noHoras, :persona_fkey);";

            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':tipo', $this->tipo);
            $result->bindParam(':titulo', $this->titulo);
            $result->bindParam(':instituto', $this->instituto);
            $result->bindParam(':pais', $this->pais);
            $result->bindParam(':yearObtencion', $this->yearObtencion);
            $result->bindParam(':noHoras', $this->noHoras);
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

    public function actualizaFormacion(){
        $this->conexion->beginTransactionPDO();
        try{
            $where = $this->getCondicion();
            $SQL = "UPDATE ".DB_NAME.".".$this->_tablaName." SET tipo = :tipo, titulo = :titulo, instituto = :instituto, pais = :pais, 
                                                                yearObtencion = :yearObtencion, noHoras = :noHoras ".$where;
            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':tipo', $this->tipo);
            $result->bindParam(':titulo', $this->titulo);
            $result->bindParam(':instituto', $this->instituto);
            $result->bindParam(':pais', $this->pais);
            $result->bindParam(':yearObtencion', $this->yearObtencion);
            $result->bindParam(':noHoras', $this->noHoras);
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

    public function deleteCapacitacion(){
        $where = $this->getCondicion();
        $SQL = "DELETE FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
    }

    public function consultaByIdProfesor(){
        $where = $this->getCondicion();
        $SQL = "SELECT capacitacion_key, tipo, titulo, instituto, pais, yearObtencion, noHoras, persona_fkey 
            FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
        $arrayFormacion = $result->fetchAll(PDO::FETCH_ASSOC);
        
        $aFormacion = array();
        foreach($arrayFormacion as $capacitacion){
            $aFormacion[$capacitacion["capacitacion_key"]] = $capacitacion;
        }
        
        return $aFormacion;
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