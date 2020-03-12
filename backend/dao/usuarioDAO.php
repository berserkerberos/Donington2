<?php

class usuarioDAO extends DAOGeneric
{
    
    private $result;
    private $MANDANTE;
    /**
     * @return mixed
     */
    public function getMANDANTE()
    {
        return $this->MANDANTE;
    }
    
    /**
     * @param mixed $MANDANTE
     */
    public function setMANDANTE($MANDANTE)
    {
        $this->MANDANTE = $MANDANTE;
    }
    
    function __construct()
    {}
    
    private function baseInternaMysql()
    {
        $iniFile = ROOT_PATH . "/backend/config/configDB.ini";
        $data = parse_ini_file($iniFile, true);
        $con_pdo = "";
        $dsn = "mysql:host=" . $data["DB_EJEMPLO"]["db_string"] . "" . ";dbname=" . $data["DB_EJEMPLO"]["db_name"];
        
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        );
        
        try {
            $con_pdo = new PDO($dsn, $data["DB_EJEMPLO"]["db_usr"], $data["DB_EJEMPLO"]["db_pass"], $options);
            $this->db = $con_pdo;
        } catch (PDOException $e) {
            Helper::utilesPrint($e->getMessage(), "Error en la conexion a la DB: ", true);
        }
    }
    
    private function baseInternaSAP()
    {
        $iniFile = ROOT_PATH . "/backend/config/configDBSAP.ini";
        $data = parse_ini_file($iniFile, true);
        $con = "";
        $dsn = "Driver=" . $data["DB_EJEMPLO"]["db_driver"] . ";ServerNode=" . $data["DB_EJEMPLO"]["db_string"] . ";Database=" . $data["DB_EJEMPLO"]["db_name"];
        $this->setMandante($data["DB_EJEMPLO"]["db_mandante"]);
        try {
            $con = odbc_connect($dsn, $data["DB_EJEMPLO"]["db_usr"], $data["DB_EJEMPLO"]["db_pass"], SQL_CUR_USE_ODBC);
            $this->db = $con;
        } catch (PDOException $e) {
            Helper::utilesPrint($e->getMessage(), "Error en la conexion a la DB: ", true);
        }
    }
    
    
    
    
    
    
    /**
     * Procesa los datos para la exportacione segun el atributo tipo
     *
     * @param SAPExportaciones $export
     * @return void
     */          
    public function validUsuSAP($key)
    {
        $this->baseInternaSAP();               
        $sql = "
             select SAPABAP1.USR41.BNAME,
                SAPABAP1.USR41.TERMID,                
                SAPABAP1.USR41.TERMINAL,
                SAPABAP1.USR41.LOGON_DATE,
                SAPABAP1.USR41.LOGON_TIME
                from SAPABAP1.USR41
            where BNAME IN ('".trim($key[0])."')" ;
                   
        
        $result = odbc_exec($this->db, $sql);
        Helper::printDebugPanel($sql, "sql", FALSE, FALSE);
        //odbc_result_all($result,"class=table border=1");                
        if (!$result){
            echo "Error while sending SQL statement to the database server.\n";
        }else{
            $resultadotxt = "";                   
            $usu =  new Usuario();
            while ($row = odbc_fetch_object($result)){
                $usu->setId($row->TERMID);
                $usu->setNombreCompleto($row->BNAME);
                $usu->setMaquina($row->TERMINAL);
                $usu->setUltimoIngreso($row->LOGON_DATE . " " . $row->LOGON_TIME );
            }            
        }               
        return $usu;
    }
}

