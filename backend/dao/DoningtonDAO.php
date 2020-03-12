<?php

// include_once(DAO_INTERFACE . 'SAPProveedorIDAO.php');
class DoningtonDAO extends DAOGeneric
{

    private $result;


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
    
    
      //
     public function procesar($transferencia)
    {
        $this->baseInternaMysql();              
        $tmpResul = false;               
        $sql = "            
INSERT INTO TRANSFER (
TITULARES ,      
REFERENCIA ,     
MOTIVO      ,   
IMPORTE      ,   
Fecha ,
entrega ,
EMAIL ,
CONCEPTO ,
CBU_DEBITO ,
CBU_CREDITO ,
ALIAS_CBU_DEBITO ,
ALIAS_CBU_CREDITO 
)

VALUES (
:TITULARES      ,
:REFERENCIA     ,
:MOTIVO         ,
:IMPORTE         ,
:FECHA ,
:ENTREGA ,
:EMAIL ,
:CONCEPTO , 
:CBU_DEBITO , 
:CBU_CREDITO , 
:ALIAS_CBU_DEBITO , 
:ALIAS_CBU_CREDITO        
    ) ";


    $result = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       
    try {
        $result->execute(array(                
            ':TITULARES'           => $transferencia->getTitulares(),
            ':REFERENCIA'     => $transferencia->getReferencia(),
            ':MOTIVO'       => $transferencia->getMotivo(),                
            ':IMPORTE'    => $transferencia->getImporte(),
            ':FECHA'   => $transferencia->getFecha(),
            ':ENTREGA'    => $transferencia->getEntrega(),
            ':EMAIL'   => $transferencia->getEmail(),
            ':CONCEPTO'  => $transferencia->getConcepto(),
            ':CBU_DEBITO' => $transferencia->getCbu_deb(),
            ':CBU_CREDITO' => $transferencia->getCbu_cred(),
            ':ALIAS_CBU_DEBITO' => $transferencia->getAlias_deb(),
            ':ALIAS_CBU_CREDITO' => $transferencia->getAlias_cred(),
            
        )); 
        //':PER_SERVICIO'     => $encuesta->getServicio(),
        //':PER_SERVOTROS'    => $encuesta->getServOtros(),  
        //echo ("Guardo en base") ;
        //Exit;

        $tmpResul =  true;
        
    } catch (Exception $e) {
        //$this->db->rollBack();
        Helper::logEnArchivos("Error con la factura: ".  var_export($encuesta,true) . "\n".  json_encode($e)  , "Error_guardarFactura");
        $tmpResul =  false;
        //throw $e;            
    }
    return  $tmpResul;                        
                        
    }




    public function consultarTransferencia($entrega)
    {
        $this->baseInternaMysql();                     
        $caracter_separador = "";
                                
        $sql = "  SELECT * FROM TRANSFER where entrega =  " . $entrega ;
                
        $result = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $result->execute(array( )); 
        
        $arr_resul = $result ->fetchAll (PDO::FETCH_ASSOC);
        
        //Helper::dd($arr_resul, "titulo");
        //var_dump ($arr_resul);
        //exit;                                
        return $arr_resul;
    }


    public function  traerEntregas()
    {
        $this->baseInternaMysql();                     
        $caracter_separador = "";
                                
        $sql = "  SELECT distinct entrega FROM TRANSFER order by entrega" ;
                
        $result = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $result->execute(array( )); 
        
        $arr_resul = $result ->fetchAll (PDO::FETCH_ASSOC);
        
        //Helper::dd($arr_resul, "titulo");
        //var_dump ($arr_resul);
        //exit;                                
        return $arr_resul;
    }

}
?>
