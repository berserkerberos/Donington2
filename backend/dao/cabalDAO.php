<?php

// include_once(DAO_INTERFACE . 'SAPProveedorIDAO.php');
class cabalDAO extends DAOGeneric
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
        //TODO: La misma query se informa para exportar las condiciones de pago en credito y debito
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
                        RIGHT(SAPABAP1.VBRK.KUNAG,9) AS NRO_REF,
                        LEFT(CONCAT(SAPABAP1.VBRK.XBLNR, '                              '),30) AS IDEM_FACT,
                        RIGHT(SAPABAP1.VBRK.XBLNR,8) AS FACTURA,
                        /*SAPABAP1.VBRK.NETWR AS IMPORTE,**/
                        SAPABAP1.BSEG.WRBTR AS IMPORTE,
                        RIGHT(CONCAT(100000000000, REPLACE( SAPABAP1.BSEG.WRBTR ,'.','')),11) AS IMPORTE_FOR,
                        SAPABAP1.BSEG.WRBTR  AS IMPORTE,
                        SAPABAP1.KNA1.NAME1 AS NOM_CLIENTE,
                        SAPABAP1.KNA1.ERDAT AS CLI_ALTA
        
                FROM SAPABAP1.VBRK
                INNER JOIN SAPABAP1.BSEG ON SAPABAP1.BSEG.AWKEY = SAPABAP1.VBRK.VBELN
                INNER JOIN SAPABAP1.KNA1  ON  SAPABAP1.KNA1.KUNNR =  SAPABAP1.VBRK.KUNAG
                WHERE SAPABAP1.VBRK.MANDT = ".$this->MANDANTE."
                AND SAPABAP1.BSEG.MANDT = ".$this->MANDANTE."
                AND SAPABAP1.KNA1.MANDT = ".$this->MANDANTE."
                AND SAPABAP1.BSEG.ZTERM in ( 'C024', 'C027' ) /* debito y credito */
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
                                   
            $count = 0;
            while ($row = odbc_fetch_object($result)){
                $count = $count + 1 ;
                $resultadotxt .=
                $row->NRO_REF . $caracter_separador .               // Identificación del socio --- 9                 
                $row->NRO_TARJETA_REF. $caracter_separador .        // nro de tarjeta    -- 16
                $row->IMPORTE_FOR. $caracter_separador .            // importe    -- 11
                $fillerCab . $caracter_separador.           // filter --82
                "                         " .$caracter_separador.     //Leyenda que se imprime -- 25
                date_format($fechaVenceObj,"dmy").$caracter_separador.   // Fecha de la Presentación -- 6
                "                           " .$caracter_separador.     //libre -- 27
                substr("000000000" . $cod_cobro ,-11) . $caracter_separador.   //NRO DE COMERCIO --11
                "P" . $caracter_separador .              // codigo de moneda    -- 8
                "                     " .$caracter_separador.     //libre -- 21                
                str_pad($count,4,"0",STR_PAD_LEFT). $caracter_separador. // numero de ticket -- 4 (contador agregado)                                
                "          " .$caracter_separador.     //libre -- 10
                "01" .$caracter_separador.     //codigo de operacion -- 2
                "               " .$caracter_separador.     //libre -- 15
                "\r\n";
                                
            }
                                  
        }
        
        
        return $resultadotxt;
    }
}

?>
