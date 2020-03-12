<?php

// include_once(DAO_INTERFACE . 'SAPProveedorIDAO.php');
class pagomiscuentasDAO extends DAOGeneric
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
        $cod_cobro = $export->getCodigoDePago() ;
                     
        $fac_concepto = $export->getConcepto();
        $fecha_vencimiento = str_replace( "-", "", $export->getFechaVencimiento());
        $fecha_archivo = str_replace( "-", "", $export->getFechaArchivo());
        $facturasDesde = str_replace( "-", "", $export->getFechaDesde());
        $facturasHasta = str_replace( "-", "", $export->getFechaHasta());
        
        $sql = "";
        $sql = "
        
                    SELECT  '5' AS TIPO_REG,
                            LEFT(CONCAT(cast(SAPABAP1.VBRK.KUNAG as int), '                   '),19) AS NRO_REF ,
                            LEFT(CONCAT(SAPABAP1.VBRK.XBLNR, '                    '),20) AS IDEM_FACT,
                            /*SAPABAP1.VBRK.NETWR AS IMPORTE,**/
                            SAPABAP1.BSEG.WRBTR AS IMPORTE,
                            /*RIGHT(CONCAT(100000000000, SAPABAP1.VBRK.NETWR),11) AS IMPORTE_FOR,*/
                            RIGHT(CONCAT(100000000000, SAPABAP1.BSEG.WRBTR),11) AS IMPORTE_FOR
                    FROM SAPABAP1.VBRK
                    INNER JOIN SAPABAP1.BSEG ON SAPABAP1.BSEG.AWKEY = SAPABAP1.VBRK.VBELN
                    WHERE SAPABAP1.VBRK.MANDT = " . $this->getMANDANTE() .  "
                    AND SAPABAP1.BSEG.MANDT = " . $this->getMANDANTE() .  "                    
                    AND SAPABAP1.BSEG.KOART = 'D'                  /*CLASE DE CUENTA*/
                    AND SAPABAP1.BSEG.H_BSTAT NOT IN ('D','M')     /*ESTATUS DE DOCUMENTO*/
                    AND (SAPABAP1.VBRK.FKDAT >= '$facturasDesde' AND SAPABAP1.VBRK.FKDAT <= '$facturasHasta')                    
                    AND SAPABAP1.VBRK.VKORG = 'SA20'
                    AND SAPABAP1.BSEG.AUGBL =  ''
                        " ;
        
        $result = odbc_exec($this->db, $sql);
        
        if (!$result){
            echo "Error while sending SQL statement to the database server.\n";
        }else{
            $resultadotxt = "";
            
            $fillerCab = "";
            for ($i = 1; $i <= 264; $i++) {
                $fillerCab .=   "0";
            }
            
            $ticketDet = "";
            for ($i = 1; $i <= 40; $i++) {
                $ticketDet .=  " ";
            }
            
            $codbarDet = "";
            for ($i = 1; $i <= 60; $i++) {
                $codbarDet .=  " ";
            }
            
            $fillerDet = "";
            for ($i = 1; $i <= 29; $i++) {
                $fillerDet .=  "0";
            }
            
            $fillerFoot = "";
            for ($i = 1; $i <= 234; $i++) {
                $fillerFoot .= "0";
            }
            
            $resultadotxt .=
            "0" . $caracter_separador.
            "400" .$caracter_separador.
            $cod_cobro .$caracter_separador.
            $fecha_archivo .$caracter_separador.
            $fillerCab.
            "\n";
            
            $cantidad_registros = 0;
            $total_facturado = 0;
            while ($row = odbc_fetch_object($result)){
                // Should output one row containing the string 'X'
                $resultadotxt .=
                $row->TIPO_REG . $caracter_separador.
                $row->NRO_REF. $caracter_separador .
                $row->IDEM_FACT . $caracter_separador.
                "0" . $caracter_separador.
                $fecha_vencimiento . $caracter_separador.
                "0" . str_replace( ".", "", $row->IMPORTE_FOR)  . $caracter_separador.
                $fecha_vencimiento . $caracter_separador.
                "0" . str_replace( ".", "", $row->IMPORTE_FOR)  . $caracter_separador.
                $fecha_vencimiento . $caracter_separador.
                "0" . str_replace( ".", "", $row->IMPORTE_FOR)  . $caracter_separador.
                "0000000000000000000" . $caracter_separador.
                $row->NRO_REF. $caracter_separador .
                //substr($ticketDet . $fac_concepto ,-40)   .  $caracter_separador.
                substr( $fac_concepto . $ticketDet ,0, 40)   .  $caracter_separador.
                "CTA BASA SALUD " . $caracter_separador.
                $codbarDet . $caracter_separador.
                $fillerDet . $caracter_separador.
                "\n";
                
                
                $cantidad_registros++;
                $total_facturado = $total_facturado +  $row->IMPORTE_FOR;
            }
            
            $total_facturado =  str_replace( ".", "", $total_facturado) ;
            
            $resultadotxt .=  "9" . $caracter_separador.
            "400" .$caracter_separador.
            $cod_cobro .$caracter_separador.
            $fecha_archivo .$caracter_separador.
            substr((10000000 + $cantidad_registros),-7) .$caracter_separador.
            "0000000" .  $caracter_separador.
            substr((10000000000000000 + $total_facturado),-16) .$caracter_separador.
            $fillerFoot .  $caracter_separador;
        }
       
                             
        return $resultadotxt;
    }
}

?>
