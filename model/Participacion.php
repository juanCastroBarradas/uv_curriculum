<?php 
require_once '../../core/DBConnection.php';

class Participacion {
    private $_tablaName;
    private $conexion;
    private $experiencia_key;
    private $organismo;
    private $periodo;
    private $nivel;
    private $fechaInicio;
    private $especifinivel;
    private $profesionalKey;
    private $_condiciones;
    private $responseResult;

    function __construct() {
        $this->_tablaName = 'participacioneventos';
        $this->conexion = new DBConnection();
        $this->_condiciones = array();
        $this->responseResult = array("msj" => "", "status" => "error", "data" => null);
    }

    public function setParticipacionKey($participacion_key){
        $this->participacion_key = $participacion_key;
    }

    public function getParticipacionKey(){
        return $this->participacion_key;
    }

    public function setProfesionalKey($profesionalKey){
        $this->profesionalKey = $profesionalKey;
    }

    public function getProfesionalKey(){
        return $this->profesionalKey;
    }

    public function setOrganismo($organismo){
        $this->organismo = $organismo;
    }

    public function getOrganismo(){
        return $this->organismo;
    }

    public function setPeriodo($periodo){
        $this->periodo = $periodo;
    }

    public function getPeriodo(){
        return $this->periodo;
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

    public function setEspecifinivel($especifinivel){
        $this->especifinivel = $especifinivel;
    }

    public function getEspecifinivel(){
        return $this->especifinivel;
    }

    public function registraParticipacion(){
        $this->conexion->beginTransactionPDO();
        try{
            $SQL = "INSERT INTO ".DB_NAME.".".$this->_tablaName." (organismo, fecha_inicio, periodo, nivel, especifinivel, persona_fkey)
                VALUES(:organismo, :fecha_inicio, :periodo, :nivel, :especifinivel, :persona_fkey);";

            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':organismo', $this->organismo);
            $result->bindParam(':periodo', $this->periodo);
            $result->bindParam(':nivel', $this->nivel);
            $result->bindParam(':fecha_inicio', $this->fechaInicio);
            $result->bindParam(':especifinivel', $this->especifinivel);

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

    public function actualizaParticipacion(){
        $this->conexion->beginTransactionPDO();
        try{
            $where = $this->getCondicion();
            $SQL = "UPDATE ".DB_NAME.".".$this->_tablaName." SET organismo = :organismo, fecha_inicio = :fecha_inicio, periodo = :periodo, nivel = :nivel, especifinivel = :especifinivel ".$where;
            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':organismo', $this->organismo);
            $result->bindParam(':periodo', $this->periodo);
            $result->bindParam(':nivel', $this->nivel);
            $result->bindParam(':fecha_inicio', $this->fechaInicio);
            $result->bindParam(':especifinivel', $this->especifinivel);
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

    public function eliminaParticipacion(){
        $where = $this->getCondicion();
        $SQL = "DELETE FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
    }

    public function consultaByIdProfesor(){
        $where = $this->getCondicion();
        $SQL = "SELECT participacion_key, organismo, periodo, fecha_inicio, nivel, especifinivel, persona_fkey 
            FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
        $arrayParticipacion = $result->fetchAll(PDO::FETCH_ASSOC);
        
        $aParticipacion = array();
        foreach($arrayParticipacion as $participacion){
            $aParticipacion[$participacion["participacion_key"]] = $participacion;
        }
        
        return $aParticipacion;
    }

    public function consultaByIdFormacion(){
        $where = $this->getCondicion();
        $SQL = "SELECT participacion_key, organismo, periodo, fecha_inicio, nivel, especifinivel, persona_fkey 
            FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
        $arrayParticipacion = $result->fetch(PDO::FETCH_ASSOC);
        return $arrayParticipacion;
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