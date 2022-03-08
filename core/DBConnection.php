<?php
require_once('settings.config.php');          // Define la configuracion de la conexion

Class DBConnection {

    // Database Connection
    public $dbc;

    /* function __construct
     * Abre la conexion de la base de datos
     * @param $config is an array of database connection parameters
     */
    public function __construct() {
        $this->getPDOConnection();
    }

    /* Function __destruct
     * cerrar conexion de base de datos
     */
    public function __destruct() {
		$this->dbc = NULL;
	}

    /* Function getPDOConnection
     * Get a connection to the database using PDO.
     */
    private function getPDOConnection() {
        // Check if the connection is already established
        if ($this->dbc == NULL) {
            // Create the connection
            $dsn = "" .
                DRIVER .
                ":host=" . DB_HOST .
                ";dbname=" . DB_NAME;

            try {
                $this->dbc = new PDO( $dsn, DB_USER, DB_PASS );
            } catch( PDOException $e ) {
                echo __LINE__.$e->getMessage();
            }
        }
    }

    private function getPDOConnection2() {
        // Check if the connection is already established
        if ($this->dbc == NULL) {
            // Create the connection
            $dsn = "" .
                DRIVER .
                ":host=" . DB_HOST .
                ";dbname=" . DB_NAME;

            try {
                
                $arrConexion["conexion"] = $this->dbc = new PDO( $dsn, DB_USER, DB_PASS );
                $arrConexion["msj"] = "conexion exitosa";
                $arrConexion["status"] = "success";
                
            } catch( PDOException $e ) {
                echo __LINE__.$e->getMessage();
                $arrConexion["conexion"] = null;
                $arrConexion["msj"] = $e->getMessage();
                $arrConexion["status"] = "success";
            }

            return $arrConexion;
        }
    }

    public function beginTransactionPDO(){
        $this->dbc->beginTransaction();
    }

    public function rollBackPDO(){
        $this->dbc->rollBack();
    }

    public function commitPDO(){
        $this->dbc->commit();
    }

}