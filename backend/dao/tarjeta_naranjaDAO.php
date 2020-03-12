<?php

// include_once(DAO_INTERFACE . 'SAPProveedorIDAO.php');
class tarjeta_naranjaDAO extends DAOGeneric
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
        
        $fac_concepto =  date_create($export->getConcepto());
        $fechaVenceObj = date_create($export->getFechaVencimiento());
        
        $fecha_archivo = str_replace( "-", "", $export->getFechaArchivo());
        $facturasDesde = str_replace( "-", "", $export->getFechaDesde());
        $facturasHasta = str_replace( "-", "", $export->getFechaHasta());
        
        $sql = "";
        $sql = "
            
                    SELECT  'D' AS TIPO_REG,
                            (

                            select  MAX(B.REMARK)
                            from SAPABAP1.KNA1 as a 
                            inner join SAPABAP1.adrct as b on  a.ADRNR = b.ADDRNUMBER 
                            WHERE A.KUNNR = SAPABAP1.KNA1.KUNNR  
                            GROUP BY A.KUNNR 

                            ) AS NRO_TARJETA_REF ,
                            LEFT(CONCAT(cast(SAPABAP1.VBRK.KUNAG as int), '                              '),30) AS NRO_REF ,
                            LEFT(CONCAT(SAPABAP1.VBRK.XBLNR, '                              '),30) AS IDEM_FACT,
                            RIGHT(SAPABAP1.VBRK.XBLNR,8) AS FACTURA,
                            /*SAPABAP1.VBRK.NETWR AS IMPORTE,**/
                            SAPABAP1.BSEG.WRBTR AS IMPORTE,
                            RIGHT(CONCAT(1000000000000, REPLACE( SAPABAP1.BSEG.WRBTR ,'.','')),12) AS IMPORTE_FOR,
                            SAPABAP1.BSEG.WRBTR  AS IMPORTE,
                            SAPABAP1.KNA1.NAME1 AS NOM_CLIENTE,
                            SAPABAP1.KNA1.ERDAT AS CLI_ALTA
            
                    FROM SAPABAP1.VBRK
                    INNER JOIN SAPABAP1.BSEG ON SAPABAP1.BSEG.AWKEY = SAPABAP1.VBRK.VBELN
                    INNER JOIN SAPABAP1.KNA1  ON  SAPABAP1.KNA1.KUNNR =  SAPABAP1.VBRK.KUNAG
                    WHERE SAPABAP1.VBRK.MANDT = ".$this->MANDANTE."
                    AND SAPABAP1.BSEG.MANDT = ".$this->MANDANTE."
                    AND SAPABAP1.KNA1.MANDT = ".$this->MANDANTE."
                    AND SAPABAP1.BSEG.ZTERM = 'C022'
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
            for ($i = 1; $i <= 97; $i++) {
                $fillerCab .=   " ";
            }
            
            $fillerDet = "";
            for ($i = 1; $i <= 26; $i++) {
                $fillerDet .=  " ";
            }
            
            $fillerPie = "";
            for ($i = 1; $i <= 88; $i++) {
                $fillerPie .=   " ";
            }
            
            
            $cantidad_registros = 0;
            $total_facturado = 0;
            
            while ($row = odbc_fetch_object($result)){
                $resultadotxt .=
                $row->TIPO_REG . $caracter_separador.               // tipo de registro  -- 1
                $row->NRO_TARJETA_REF. $caracter_separador .        // nro de tarjeta    -- 16
                $row->IMPORTE_FOR. $caracter_separador .            // importe    -- 12
                $row->CLI_ALTA . $caracter_separador .              // FECHA DE ALTA CLIENTE    -- 8
                $row->NRO_REF . $caracter_separador .               // NRO DE DEBITO    -- 30
                date_format($fechaVenceObj,"Ymd").                    // AÑO DE LA CUOTA    --4
                str_pad(date_format($fac_concepto,"m"),2,"0",STR_PAD_LEFT). // NRO DE CUOTA --2
                $row->FACTURA . $caracter_separador .               // NRO DE FACTURA    -- 8
                date_format($fac_concepto,"Y").                    // AÑO DE LA CUOTA    --4
                $fillerDet . $caracter_separador.           // filter               --9
                "\r\n";
                
                $cantidad_registros++;
                $total_facturado = $total_facturado +  $row->IMPORTE;
            }
            
            $total_facturado =  str_replace( ".", "", $total_facturado) ;
            
            $cabceceratxt =
            "C" . $caracter_separador.                                              //TIPO DE REGISTRO
            substr("000000000" . $cod_cobro ,-9) . $caracter_separador.             //NRO DE COMERCIO
            $fillerCab.
            $fecha_archivo .$caracter_separador.
            "\r\n";
            
            $resultadotxt = $cabceceratxt .  $resultadotxt;
            
            $pietxt =
            "P" . $caracter_separador.                           //TIPO DE REGISTRO --- 1
            str_pad( $cantidad_registros, 6,"0", STR_PAD_LEFT) . $caracter_separador.    //CANT DET -- 6
            $fillerPie . $caracter_separador.           // filter               --9
            str_pad( $total_facturado, 12,"0", STR_PAD_LEFT) . $caracter_separador.    //TOTAL $ A INFORMAR -- 12
            "        " . $caracter_separador ;           // SIN USO ---8
            
            $resultadotxt .= $pietxt;
        }
        
        
        return $resultadotxt;
    }
}

?>
