<?php 
require_once '../../core/DBConnection.php';

class GestionAcademica{
    private $_tablaName;
    private $conexion;
    private $gestion_key;
    private $puesto;
    private $instituto;
    private $fechaInicio;
    private $fechaFin;
    private $actual;
    private $profesionalKey;
    private $_condiciones;
    private $responseResult;

    function __construct() {
        $this->_tablaName = 'gestionacademica';
        $this->conexion = new DBConnection();
        $this->_condiciones = array();
        $this->responseResult = array("msj" => "", "status" => "error", "data" => null);
    }

    public function setGestionKey($gestion_key){
        $this->gestion_key = $gestion_key;
    }

    public function getGestionKey(){
        return $this->gestion_key;
    }

    public function setPuesto($puesto){
        $this->puesto = $puesto;
    }

    public function getPuesto(){
        return $this->puesto;
    }

    public function setInstituto($instituto){
        $this->instituto = $instituto;
    }

    public function getInstituto(){
        return $this->instituto;
    }

    public function setFechaInicio($fechaInicio){
        $this->fechaInicio = date('Y-m-d',strtotime($fechaInicio));
        //$this->fechaInicio = $fechaInicio;
    }

    public function getFechaInicio(){
        return $this->fechaInicio;
    }

    public function setFechaFin($fechaFin){
        $this->fechaFin = date('Y-m-d',strtotime($fechaFin));
        //$this->fechaFin = $fechaFin;
    }

    public function getFechaFin(){
        return date('d-m-Y',strtotime($this->fechaFin));
        //return $this->fechaFin;
    }

    public function setActual($actual){
        $this->actual = $actual;
    }

    public function getActual(){
        return $this->actual;
    }

    public function setProfesionalKey($profesionalKey){
        $this->profesionalKey = $profesionalKey;
    }

    public function getProfesionalKey(){
        return $this->profesionalKey;
    }

    public function registraGestion(){
        $this->conexion->beginTransactionPDO();
        try{
            $SQL = "INSERT INTO ".DB_NAME.".".$this->_tablaName." (puesto, instituto, fecha_inicio, fecha_fin, actual, persona_fkey)
                VALUES(:puesto, :instituto, :fecha_inicio, :fecha_fin, :actual, :persona_fkey);";

            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':puesto', $this->puesto);
            $result->bindParam(':instituto', $this->instituto);
            $result->bindParam(':fecha_inicio', $this->fechaInicio);
            $result->bindParam(':fecha_fin', $this->fechaFin);
            $result->bindParam(':actual', $this->actual);
            $result->bindParam(':persona_fkey', $this->profesionalKey);
            $result->execute();

            $this->conexion->commitPDO();
            $this->responseResult["msj"] = "El registro fue exitoso.";
            $this->responseResult["status"] = "success";

        }catch(PDOException $e){
            $this->conexion->rollBackPDO();
            $this->responseResult["msj"] = "Error en SQL [".$e->getMessage()."]";
            $this->responseResult["status"] = "error";

        }

        return $this->responseResult;
    }

    public function actualizaGestion(){
        $this->conexion->beginTransactionPDO();
        try{
            $where = $this->getCondicion();
            $SQL = "UPDATE ".DB_NAME.".".$this->_tablaName." SET puesto = :puesto, instituto = :instituto, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin, 
                                                                actual = :actual ".$where;
            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':puesto', $this->puesto);
            $result->bindParam(':instituto', $this->instituto);
            $result->bindParam(':fecha_inicio', $this->fechaInicio);
            $result->bindParam(':fecha_fin', $this->fechaFin);
            $result->bindParam(':actual', $this->actual);
            $result->execute();

            $this->conexion->commitPDO();
            $this->responseResult["msj"] = "La actualizacion fue exitosoa.";
            $this->responseResult["status"] = "success";

        }catch(PDOException $e){
            $this->conexion->rollBackPDO();
            $this->responseResult["msj"] = "Error en SQL [".$e->getMessage()."]";
            $this->responseResult["status"] = "error";

        }

        return $this->responseResult;
    }

    public function eliminaGestion(){
        $where = $this->getCondicion();
        $SQL = "DELETE FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
    }

    public function consultaByIdProfesor(){
        $where = $this->getCondicion();
        $SQL = "SELECT gestion_key, puesto, instituto, DATE_FORMAT(fecha_inicio, '%d/%m/%Y') as fecha_inicio, DATE_FORMAT(fecha_fin, '%d/%m/%Y') as fecha_fin, actual, persona_fkey 
            FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
        $arrayExperiencia = $result->fetchAll(PDO::FETCH_ASSOC);
        
        $aGestion = array();
        foreach($arrayExperiencia as $gestion){
            $aGestion[$gestion["gestion_key"]] = $gestion;
        }
        
        return $aGestion;
    }

    public function consultaByIdFormacion(){
        $where = $this->getCondicion();
        $SQL = "SELECT gestion_key, puesto, instituto, fecha_inicio, fecha_fin, actual, persona_fkey 
            FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
        $arrayExperiencia = $result->fetch(PDO::FETCH_ASSOC);
        return $arrayExperiencia;
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