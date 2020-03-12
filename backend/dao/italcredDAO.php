<?php

// include_once(DAO_INTERFACE . 'SAPProveedorIDAO.php');
class italcredDAO extends DAOGeneric
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
    public function procesar($export)
    {
        $this->baseInternaSAP();        
       
        $caracter_separador = "";
        $cod_cobro = $export->getCodigoDePago();
        
        $fechaVenceObj = date_create($export->getFechaVencimiento());
                
        $facturasDesde = str_replace("-", "", $export->getFechaDesde());
        $facturasHasta = str_replace("-", "", $export->getFechaHasta());
    
        $sql = "";
        $sql = "            
                SELECT  
                        (

                            select  MAX(B.REMARK)
                            from SAPABAP1.KNA1 as a 
                            inner join SAPABAP1.adrct as b on  a.ADRNR = b.ADDRNUMBER 
                            WHERE A.KUNNR = SAPABAP1.KNA1.KUNNR  
                            GROUP BY A.KUNNR 

                            ) AS NRO_TARJETA_REF ,                            
                        RIGHT(SAPABAP1.VBRK.KUNAG,6) AS NRO_REF,
                        LEFT(CONCAT(SAPABAP1.VBRK.XBLNR, '                              '),30) AS IDEM_FACT,
                        RIGHT(SAPABAP1.VBRK.XBLNR,8) AS FACTURA,
                        /*SAPABAP1.VBRK.NETWR AS IMPORTE,**/
                        SAPABAP1.BSEG.WRBTR AS IMPORTE,
                        RIGHT(CONCAT(000000000, REPLACE( SAPABAP1.BSEG.WRBTR ,'.',',')),9) AS IMPORTE_FOR,
                        SAPABAP1.BSEG.WRBTR  AS IMPORTE,
                        SAPABAP1.KNA1.NAME1 AS NOM_CLIENTE,
                        SAPABAP1.KNA1.ERDAT AS CLI_ALTA
        
                FROM SAPABAP1.VBRK
                INNER JOIN SAPABAP1.BSEG ON SAPABAP1.BSEG.AWKEY = SAPABAP1.VBRK.VBELN
                INNER JOIN SAPABAP1.KNA1  ON  SAPABAP1.KNA1.KUNNR =  SAPABAP1.VBRK.KUNAG
                WHERE SAPABAP1.VBRK.MANDT = ".$this->MANDANTE."
                AND SAPABAP1.BSEG.MANDT = ".$this->MANDANTE."
                AND SAPABAP1.KNA1.MANDT = ".$this->MANDANTE."
                AND SAPABAP1.BSEG.ZTERM = 'C023' 
                AND SAPABAP1.BSEG.KOART = 'D'                  /*CLASE DE CUENTA*/
                AND SAPABAP1.BSEG.H_BSTAT NOT IN ('D','M')     /*ESTATUS DE DOCUMENTO*/
                AND (SAPABAP1.VBRK.FKDAT >= '$facturasDesde' AND SAPABAP1.VBRK.FKDAT <= '$facturasHasta')
                AND SAPABAP1.VBRK.VKORG = 'SA20'           
                AND SAPABAP1.BSEG.AUGBL =  ''     
                " ;
        
        $result = odbc_exec($this->db, $sql);
        //odbc_result_all($result,"class=table border=1");
                
        if (!$result){
            echo "Error while sending SQL statement to the database server.\n";
        }else{
            $resultadotxt = "";
            
            $fillerCab = "";
            for ($i = 1; $i <= 82; $i++) {
                $fillerCab .=   " ";
            }
                                   
            while ($row = odbc_fetch_object($result)){
                $resultadotxt .=
                $row->NRO_TARJETA_REF. $caracter_separador .        // nro de tarjeta    -- 16
                "1". $caracter_separador .                            // orden -- 1
                date_format($fechaVenceObj,"mY"). $caracter_separador .   // fecha del debito -- 6 (mmyyyy)
                $row->IMPORTE_FOR. $caracter_separador .            // importe    -- 9                                                                            
                $row->NRO_REF . $caracter_separador .               // Identificación del socio --- 6                 
                "  " .$caracter_separador .                         // cod de rechazo
                "                        " . $caracter_separador .  // relleno  --24
                //"  " . $caracter_separador .  // fin de archivo  --2
                "\r\n";                               
                                
            }                                 
        }
        
        
        return $resultadotxt;
    }
}

?>
