<?php 
require_once '../../core/DBConnection.php';

class ExperienciaDiseno{
    private $_tablaName;
    private $conexion;
    private $experiencia_key;
    private $organismo;
    private $periodo;
    private $nivel;
    private $cargo;
    private $otroCargo;
    private $profesionalKey;
    private $_condiciones;
    private $responseResult;

    function __construct() {
        $this->_tablaName = 'experienciadiseno';
        $this->conexion = new DBConnection();
        $this->_condiciones = array();
        $this->responseResult = array("msj" => "", "status" => "error", "data" => null);
    }

    public function setExperienciaKey($experiencia_key){
        $this->experiencia_key = $experiencia_key;
    }

    public function getExperienciaKey(){
        return $this->experiencia_key;
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

    public function setCargo($cargo){
        $this->cargo = $cargo;
    }

    public function getCargo(){
        return $this->cargo;
    }

    public function setOtroCargo($otroCargo){
        $this->otroCargo = $otroCargo;
    }

    public function getOtroCargo(){
        return $this->otroCargo;
    }

    public function registraExperiencia(){
        $this->conexion->beginTransactionPDO();
        try{
            $SQL = "INSERT INTO ".DB_NAME.".".$this->_tablaName." (organismo, periodo, nivel, cargo, especificargo, persona_fkey)
                VALUES(:organismo, :periodo, :nivel, :cargo, :especificargo, :persona_fkey);";

            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':organismo', $this->organismo);
            $result->bindParam(':periodo', $this->periodo);
            $result->bindParam(':nivel', $this->nivel);
            $result->bindParam(':cargo', $this->cargo);
            $result->bindParam(':especificargo', $this->otroCargo);
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

    public function actualizaExperiencia(){
        $this->conexion->beginTransactionPDO();
        try{
            $where = $this->getCondicion();
            $SQL = "UPDATE ".DB_NAME.".".$this->_tablaName." SET organismo = :organismo, periodo = :periodo, nivel = :nivel, cargo = :cargo, especificargo = :especificargo ".$where;
            $result = $this->conexion->dbc->prepare($SQL);
            $result->bindParam(':organismo', $this->organismo);
            $result->bindParam(':periodo', $this->periodo);
            $result->bindParam(':nivel', $this->nivel);
            $result->bindParam(':cargo', $this->cargo);
            $result->bindParam(':especificargo', $this->otroCargo);
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

    public function eliminaExperiencia(){
        $where = $this->getCondicion();
        $SQL = "DELETE FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
    }

    public function consultaByIdProfesor(){
        $where = $this->getCondicion();
        $SQL = "SELECT expediseno_key, organismo, periodo, nivel, cargo, especificargo, persona_fkey 
            FROM ".DB_NAME.".".$this->_tablaName.$where;
        $result = $this->conexion->dbc->prepare($SQL);
        $result->execute();
        $arrayExperiencia = $result->fetchAll(PDO::FETCH_ASSOC);
        
        $aExperienca = array();
        foreach($arrayExperiencia as $experienca){
            $aExperienca[$experienca["expediseno_key"]] = $experienca;
        }
        
        return $aExperienca;
    }

    public function consultaByIdFormacion(){
        $where = $this->getCondicion();
        $SQL = "SELECT expediseno_key, organismo, periodo, nivel, cargo, especificargo, persona_fkey 
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