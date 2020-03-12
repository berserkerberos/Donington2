<?php

// include_once(DAO_INTERFACE . 'SAPProveedorIDAO.php');
class pagofacilDAO extends DAOGeneric
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
        
        $fac_concepto = $export->getConcepto();
        $fecha_vencimiento = str_replace("-", "", $export->getFechaVencimiento());
        $fechaVenceObj = date_create($export->getFechaVencimiento());
        
        // FECHA DE VENCIMIENTO EN FORMATO JULIANA ORDINAL PARA EL DETALLE
        $fechaVenceFormaJ = date_format($fechaVenceObj, "y") . str_pad(date_format($fechaVenceObj, "z"), 3, "0", STR_PAD_LEFT);
        
        $fecha_archivo = str_replace("-", "", $export->getFechaArchivo());
        $facturasDesde = str_replace("-", "", $export->getFechaDesde());
        $facturasHasta = str_replace("-", "", $export->getFechaHasta());
        
        $sql = "";
        $sql = "
                    SELECT  '02' AS TIPO_REG,
                            LEFT(CONCAT(cast(SAPABAP1.VBRK.KUNAG as int), '                     '),21) AS NRO_REF ,
                            CAST( SAPABAP1.VBRK.KUNAG  AS INT) AS NRO_SOL ,
                            LEFT(CONCAT(SAPABAP1.VBRK.XBLNR, '                              '),30) AS IDEM_FACT,
                            /*SAPABAP1.VBRK.NETWR AS IMPORTE,**/
                            SAPABAP1.BSEG.WRBTR AS IMPORTE,
                            /*RIGHT(CONCAT(100000000000, SAPABAP1.VBRK.NETWR),11) AS IMPORTE_FOR,*/
                            RIGHT(CONCAT(100000000, REPLACE( SAPABAP1.BSEG.WRBTR ,'.','')),8) AS IMPORTE_FOR,
                            SAPABAP1.VBRK.XBLNR AS FAC_BARRA,
                            SAPABAP1.KNA1.NAME1 AS NOM_CLIENTE
                    FROM SAPABAP1.VBRK
                    INNER JOIN SAPABAP1.BSEG ON SAPABAP1.BSEG.AWKEY = SAPABAP1.VBRK.VBELN
                    INNER JOIN SAPABAP1.KNA1  ON  SAPABAP1.KNA1.KUNNR =  SAPABAP1.VBRK.KUNAG
                    WHERE SAPABAP1.VBRK.MANDT = " . $this->getMANDANTE() .  "
                    AND SAPABAP1.BSEG.MANDT = " . $this->getMANDANTE() .  "
                    AND SAPABAP1.KNA1.MANDT = " . $this->getMANDANTE() .  "
                    AND SAPABAP1.BSEG.KOART = 'D'                  /*CLASE DE CUENTA*/
                    AND SAPABAP1.BSEG.H_BSTAT NOT IN ('D','M')     /*ESTATUS DE DOCUMENTO*/
                    AND (SAPABAP1.VBRK.FKDAT >= '$facturasDesde' AND SAPABAP1.VBRK.FKDAT <= '$facturasHasta')
                    AND SAPABAP1.VBRK.VKORG = 'SA20'
                    AND SAPABAP1.BSEG.AUGBL =  ''
                        ";
        
        $result = odbc_exec($this->db, $sql);

        if (! $result) {
            echo "Error while sending SQL statement to the database server.\n";
        } else {
            $resultadotxt = "";
            
            $fillerCab = "";
            for ($i = 1; $i <= 172; $i ++) {
                // el día 11/02/2019 se pidió completar el fillerCab con 0
                $fillerCab .= "0";
            }
            
            $ticketDet = "";
            for ($i = 1; $i <= 40; $i ++) {
                $ticketDet .= " ";
            }
            
            $codbarDet = "";
            for ($i = 1; $i <= 55; $i ++) {
                $codbarDet .= " ";
            }
            
            $fillerDet = "";
            for ($i = 1; $i <= 9; $i ++) {
                // el día 11/02/2019 se pidió completar el fillerDet con 0
                $fillerDet .= "0";
            }
            
            $cantidad_registros = 0;
            // $total_facturado = 0;
            while ($row = odbc_fetch_object($result)) {
                $resultadotxt .= $row->TIPO_REG . $caracter_separador . // tipo de registro -- 2
                $row->NRO_REF . $caracter_separador . // iden primario -- 21 ' numero de cliente
                $row->IDEM_FACT . $caracter_separador . // iden secundario -- 30 ' numero de factura
                "000000" . $caracter_separador . // numero de secuencia-- 6
                substr($fac_concepto . $ticketDet, 0, 20) . $caracter_separador . // mensaje --20
                substr($row->NOM_CLIENTE . $ticketDet, 0, 40) . $caracter_separador . // nombre de cliente pendiente --40
                substr("2620" . $row->IMPORTE_FOR . $fechaVenceFormaJ . str_pad($row->NRO_SOL, 14, "0", STR_PAD_LEFT) . "0" . str_pad($row->FAC_BARRA, 14, "0", STR_PAD_LEFT) . $codbarDet, 0, 55) . $caracter_separador . 
                // codigo de barrios --55 /// 4 EMPRESA DE SERVICIO / 8 IMPORTE (6 ENT 2 DEC) / 5 VENCE (AADDD) / 14 CLIENTE / 0 MONEDA / 14 numero de factura
                $fecha_archivo . $caracter_separador . // fecha vigencia --8
                $fecha_vencimiento . $caracter_separador . // fecha vencimiento --8
                "T" . $caracter_separador . // tipo de pago --1
                $fillerDet . $caracter_separador . // filter --9
                "\n";
                $cantidad_registros ++;
                // $total_facturado = $total_facturado + $row->IMPORTE_FOR;
            }
            
            // $total_facturado = str_replace( ".", "", $total_facturado) ;
            
            $cabceceratxt = "01" . $caracter_separador . substr("000000000" . $cantidad_registros, - 9) . $caracter_separador . "T" . $caracter_separador . // VER QUE SE NECESITA PARA COMPLETAR ESTE CAMPO
            $cod_cobro . $caracter_separador . // FORMATEAR EL NUMERO DE UTILITY
            $fecha_archivo . $caracter_separador . $fillerCab . "\n";
            
            $resultadotxt = $cabceceratxt . $resultadotxt;
        }
        
        return $resultadotxt;
    }
}

?>
