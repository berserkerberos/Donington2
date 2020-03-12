<?php

/* *
 * Esta clase esta preparada para crear las conexiones a la base de datos.
 * A cada metodo se le pasa la ruta del archivo de configuracion para extraer
 * los datos de la conexion.
 *
 * @author u61851
 */
require_once(ROOT_PATH . '/backend/libraries/adodb518a/adodb-exceptions.inc.php');
require_once(ROOT_PATH . '/backend/libraries/adodb518a/adodb.inc.php');

require_once(ROOT_PATH . '/backend/exceptions/ADODbException.php');
require_once(ROOT_PATH . '/backend/exceptions/ADODbMySQLConnectException.php');
require_once(ROOT_PATH . '/backend/exceptions/ADODbMySQLExecuteException.php');
require_once(ROOT_PATH . '/backend/exceptions/ADODbNewConnectionException.php');
require_once(ROOT_PATH . '/backend/exceptions/ADODbOracleConnectException.php');
require_once(ROOT_PATH . '/backend/exceptions/ADODbOracleExecuteException.php');

class ADODb {

    /**
     * @staticvar
     * @var Log Instancia de la clase Log de PEAR
     */
    public static $logObject;

    /**
     * @access Private
     * @static
     */
    private function __construct() {
        
    }

    /**
     * Crea una instancia de conexion a la Base de Datos
     * @param String $iniFile
     * @param String $dbName
     * @return ADODB
     */
    public static function getConnection($iniFile, $dbName = '') {
        $dbName = strtoupper($dbName);
        $ADODbInstance = null;
        // se fija que el archivo de configuracion exista
        if (!file_exists($iniFile)) {
            // si no existe lo va a buscar a una ubicacion por defecto
            $iniFile = ROOT_PATH . '/backend/config/configDB.ini';
        }

        // recupero los datos del archivo de configuracion
        $data = parse_ini_file($iniFile, true);

        if ($dbName == '') {
            $dbName = strtoupper($data['DBConfig']['db_default']);
        }

        $data = $data[$dbName];

        if ($data['db_driver'] == 'oci8') {
            if (!is_null(self::$logObject))
                self::$logObject->log("Busco la conexion a la BD Oracle", PEAR_LOG_INFO);

            $ADODbInstance = self::getOracleConnection($data);
        }
        else if ($data['db_driver'] == 'mysql') {
            $ADODbInstance = self::getMySQLConnection($data);
        }
        return $ADODbInstance;
    }

    /**
     *  Crea una instancia de conexion a un esquema de una Base de Datos
     *  Oracle.
     *
     * @param string $iniFile El archivo ini de configuracion de la conexion
     * @return ADODb
     */
    private static function getOracleConnection($data) {
        $db = null;
        $logInfo = array();

        $logInfo['data'] = $data;
        try {
            // creo la conexion con el driver oci8.
            $db = ADONewConnection($data['db_driver']);
            if (!is_null(self::$logObject))
                self::$logObject->log("Creo la conexion a Oracle con ADONewConetion", PEAR_LOG_INFO);
            // si no es un objeto, tiro la excepcion de que no pudo crearla.
            if (!$db) { // is_object($db)
                $logInfo['line'] = __LINE__;
                $msg = "Error en nueva Conexion Oracle (oci8): ";

                if (!is_null(self::$logObject))
                    self::$logObject->log("Error al crear la conexion a BD Oracle: " . print_r($data, true), PEAR_LOG_EMERG);

                throw new ADODbNewConnectionException($msg, 0, $logInfo);
            }
        } catch (ADODB_Exception $adodb_exception) {
            $logInfo['line'] = __LINE__;
            $msg = "Error en nueva Conexion Oracle (oci8) : ";

            if (!is_null(self::$logObject))
                self::$logObject->log("Error al crear la conexion a BD Oracle: " . $adodb_exception->getMessage(), PEAR_LOG_EMERG);

            throw new ADODbNewConnectionException($msg, $adodb_exception->getCode(), $logInfo);
        }

        try {
            // me conecto de forma no persistente
            $db->charSet = (!empty($data['db_charset'])) ? $data['db_charset'] : false;
            $db->Connect($data['db_string'], $data['db_usr'], $data['db_pass']);
        } catch (ADODB_Exception $adodb_exception) {
            if (!is_null(self::$logObject))
                self::$logObject->log($adodb_exception->getMessage(), PEAR_LOG_EMERG);
            // lanzo una excepcion de tipo ADODbOracleConnectException con el mensaje que surge de la ADODb_Exception
            throw new ADODbOracleConnectException($adodb_exception->getMessage(), $adodb_exception->getCode(), $logInfo);
        } catch (Exception $e) {
            if (!is_null(self::$logObject))
                self::$logObject->log($E->getMessage(), PEAR_LOG_EMERG);
            // capturo lo que queda, y lo convierto en una excepcion ADODbException
            throw new ADODbException($e->getMessage(), $e->getCode());
        }

        return $db;
    }

    /**
     *  Crea una instancia de conexion a un esquema de una Base de Datos
     *  MySQL.
     *
     * @param string $iniFile El archivo ini de configuracion de la conexion
     * @return ADODb
     */
    private static function getMySQLConnection($data) {
        $db = null;
        $logInfo = array();

        $logInfo['data'] = $data;
        try {
            // creo la conexion con el driver mysql
            $db = ADONewConnection($data['db_driver']);
            // si no es un objeto, tiro la excepcion de que no pudo crearla.
            if (!$db) {
                $logInfo['line'] = __LINE__;
                $msg = "Error en nueva Conexion MYSQL: ";
                throw new ADODbNewConnectionException($msg, 0, $logInfo);
            }
        } catch (ADODB_Exception $adodb_exception) {
            $logInfo['line'] = __LINE__;
            $msg = "Error en nueva Conexion MYSQL: ";
            throw new ADODbNewConnectionException($msg, $adodb_exception->getCode(), $logInfo);
        }

        try {
            // me conecto de forma persistente
            $db->PConnect($data['db_string'], $data['db_usr'], $data['db_pass'], $data['db_name']);
        } catch (ADODB_Exception $adodb_exception) {
            // lanzo una excepcion de tipo ADODbMySQLConnectException con el mensaje que surge de la ADODb_Exception
            throw new ADODbMySQLConnectException($adodb_exception->getMessage(), $adodb_exception->getCode(), $logInfo);
        } catch (Exception $e) {
            // capturo lo que queda, y lo convierto en una excepcion ADODbException
            throw new ADODbException($e->getMessage(), $e->getCode());
        }

        return $db;
    }

}

?>
