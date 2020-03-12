<?php

// include_once(DAO_INTERFACE . 'SAPProveedorIDAO.php');
class HSBC_GSGADAO extends DAOGeneric
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
    public function procesar_bk($export)
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
                AND SAPABAP1.VBRK.VKORG = 'SA25'
                AND SAPABAP1.BSEG.AUGBL =  ''                
                " ;
        
        $result = odbc_exec($this->db, $sql);
        //odbc_result_all($result,"class=table border=1");
        Helper::dd($sql,"consulta")        ;
        exit;
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

                
            Helper::dd($resultadotxt,"resultados");
            exit;                                  
        }
                
        return $resultadotxt;
    }

  
    public function procesar($export)
    {
        $this->baseInternaSAP();        
       
        $caracter_separador = "";
        $cod_cobro = $export->getCodigoDePago();
        
        $ente_empresa =  "74689";
        $fac_concepto =  date_create($export->getConcepto());
        $fechaVenceObj = date_create($export->getFechaVencimiento());
                
        $facturasDesde = str_replace( "-", "", $export->getFechaDesde());
        $facturasHasta = str_replace( "-", "", $export->getFechaHasta());
        
        $sql = "";
        $sql = "
            
                    SELECT  '6' AS TIPO_REG,
                            (

                            select  MAX(B.REMARK)
                            from SAPABAP1.KNA1 as a 
                            inner join SAPABAP1.adrct as b on  a.ADRNR = b.ADDRNUMBER 
                            WHERE A.KUNNR = SAPABAP1.KNA1.KUNNR  
                            GROUP BY A.KUNNR 

                            ) AS NRO_TARJETA_REF ,
                            LEFT(CONCAT(cast(SAPABAP1.VBRK.KUNAG as int), '                              '),30) AS NRO_REF ,
                            LEFT(CONCAT(SAPABAP1.VBRK.XBLNR, '               '),15) AS IDEM_FACT,
                            RIGHT(SAPABAP1.VBRK.XBLNR,8) AS FACTURA,                            
                            TO_DECIMAL( SAPABAP1.BSEG.WRBTR * 1.11, 10, 2)  AS IMPORTE,
                            RIGHT(CONCAT(100000000, REPLACE(   TO_DECIMAL(SAPABAP1.BSEG.WRBTR * 1.11, 10, 2)   ,'.','')),8) AS IMPORTE_FOR,
                            SAPABAP1.KNA1.NAME1 AS NOM_CLIENTE,
                            SAPABAP1.KNA1.ERDAT AS CLI_ALTA ,
                            LEFT(CONCAT(SAPABAP1.KNA1.STCD1, '                      '),22) AS CUIL
                            
            
                    FROM SAPABAP1.VBRK
                    INNER JOIN SAPABAP1.BSEG ON SAPABAP1.BSEG.AWKEY = SAPABAP1.VBRK.VBELN
                    INNER JOIN SAPABAP1.KNA1  ON  SAPABAP1.KNA1.KUNNR =  SAPABAP1.VBRK.KUNAG
                    
                    WHERE SAPABAP1.VBRK.MANDT = ".$this->MANDANTE."
                    AND SAPABAP1.BSEG.MANDT = ".$this->MANDANTE."
                    AND SAPABAP1.KNA1.MANDT = ".$this->MANDANTE."
                    /* AND SAPABAP1.BSEG.ZTERM = 'C027'   CONDICION DE PAGO DE DEBITO HSBC **/
                    AND SAPABAP1.BSEG.KOART = 'D'                  /*CLASE DE CUENTA*/
                    AND SAPABAP1.BSEG.H_BSTAT NOT IN ('D','M')     /*ESTATUS DE DOCUMENTO*/
                    AND (SAPABAP1.VBRK.FKDAT >= '$facturasDesde' AND SAPABAP1.VBRK.FKDAT <= '$facturasHasta')
                    AND SAPABAP1.VBRK.VKORG = 'SA25'
                    AND SAPABAP1.BSEG.AUGBL =  ''
                    LIMIT 3
                " ;
        
        $result = odbc_exec($this->db, $sql);
        //odbc_result_all($result,"class=table border=1");
        
        if (!$result){
            echo "Error while sending SQL statement to the database server.\n";
        }else{
            $resultadotxt = "";
            
            $fillerCab = "";
            for ($i = 1; $i <= 153; $i++) {
                $fillerCab .=   " ";
            }
            
            $fillerDet = "";
            for ($i = 1; $i <= 56; $i++) {
                $fillerDet .=  " ";
            }
            
            $fillerPie = "";
            for ($i = 1; $i <= 132; $i++) {
                $fillerPie .=   " ";
            }
            
            
            $cantidad_registros = 0;
            $total_facturado = 0;
            $total_digitos = 0;
            
            while ($row = odbc_fetch_object($result)){
                $cantidad_registros++;
                $resultadotxt .=
                $row->TIPO_REG . $caracter_separador.                       // PCORIGTE-IDENTI-REG  (1)  
                $ente_empresa . $caracter_separador.                        // PCORIGTE-ENTE        (5)
                "001". $caracter_separador.                                 // PCORIGTE-SUBENTE     (3)
                "LOGIMEDH  ". $caracter_separador.                          // PCORIGTE-PRESTACION  (10)
                "080". $caracter_separador.                                 // PCORIGTE-MON-OPER    (3)
                date_format($fechaVenceObj,"Ymd").$caracter_separador.      // PCORIGTE-FECHA-VTO   (8) AAAAMMDD
                // proximo dia habil al vencimiento
                date_format($fechaVenceObj,"Ymd").$caracter_separador.      // PCORIGTE-FECHA-VTO   (8) AAAAMMDD                
                str_pad(substr( $row->NRO_TARJETA_REF, 0 , 8),8,"0",STR_PAD_LEFT).$caracter_separador.   // PCORIGTE-CBU1-DEST   (8) 
                str_pad(substr( $row->NRO_TARJETA_REF, 8 , 17),17,"0",STR_PAD_LEFT).$caracter_separador. // PCORIGTE-CBU2-DEST   (17)                                
                $row->IMPORTE_FOR. $caracter_separador .                    // PCORIGTE-IMPORTE     (8)
                $row->IDEM_FACT. $caracter_separador .                      // PCORIGTE-FACTURA     (15)
                $row->CUIL. $caracter_separador .                           // PCORIGTE-REFERENCIA  (22)
                "37". $caracter_separador.                                  // PCORIGTE-COD-TRAN    (2)
                "00". $caracter_separador.                                  // PCORIGTE-ORIG-TRAN   (2)
                "000". $caracter_separador.                                 // PCORIGTE-TIPO-ERR    (3)    
                $fillerDet . $caracter_separador.                           // PCORIGTE-INFO-ADIC   (56)
                str_pad($cantidad_registros,7,"0",STR_PAD_LEFT).            // PCORIGTE-SECUENCIA   (7)
                
                "\r\n";                
                           
                $total_digitos = $total_digitos + intval( substr( $row->NRO_TARJETA_REF, 21 , 1)) ; // total de digitos verificadores
                $total_facturado = $total_facturado +  $row->IMPORTE ;
            }
            
            $total_facturado =  str_replace( ".", "", $total_facturado) ;
            //$total_facturado =  $total_facturado ;
            //-------------------------------------------------------------------------------
            $cabceceratxt =
            "5" . $caracter_separador.                                              //PCORIGTE-ID-REGISTRO-1    (1)
            $ente_empresa . $caracter_separador.                                    //PCORIGTE-ENTE-1           (5)
            "33707214789" . $caracter_separador.                                    //PCORIGTE-CUIT             (11) cuit de logimed
            "000". $caracter_separador.                                             //PCORIGTE-TIPO-ERR-1       (3)
            $fillerCab. $caracter_separador.                                        //PCORIGTE-INFO-ADIC-1      (153)                        
            "0000001".                                                              //PCORIGTE-SECUENCIA-1      (7)
            "\r\n";
            //-------------------------------------------------------------------------------
            $resultadotxt = $cabceceratxt .  $resultadotxt;
            //-------------------------------------------------------------------------------
            $pietxt =
            "8" . $caracter_separador.                                               // PCORIGTE-IDENTI-REG3     (1)
            $ente_empresa . $caracter_separador.                                     //PCORIGTE-ENTE-3           (5)            
            str_pad( $cantidad_registros, 6,"0", STR_PAD_LEFT) . $caracter_separador.//PCORIGTE-CANT-REG        (6)
            str_pad( $total_facturado, 10,"0", STR_PAD_LEFT) . $caracter_separador.  //PCORIGTE-IMP-TOT         (10)
            str_pad( $total_digitos, 17,"0", STR_PAD_LEFT) . $caracter_separador.    //PCORIGTE-IMP-DIG         (17)
            $fillerPie . $caracter_separador.                                        //PCORIGTE-INFO-ADIC-3     (132)
            "0000001"                                                                //PCORIGTE-SECUENCIA3       (7)
            ;            
            $resultadotxt .= $pietxt;
            //-------------------------------------------------------------------------------
        }                
        return $resultadotxt;
    }
}

?>
