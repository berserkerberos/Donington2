<?php

/**
 * Description of DAOFactory
 *
 * @author u61851
 */
// se cargan las excepciones DAO que son necesarias para correr DAOFactory
require_once(ROOT_PATH . '/backend/exceptions/DAOException.php');
require_once(ROOT_PATH . '/backend/exceptions/DAOConfigFileException.php');
require_once(ROOT_PATH . '/backend/exceptions/DAODatabaseException.php');
require_once(ROOT_PATH . '/backend/exceptions/DAODatabaseExecuteException.php');
require_once(ROOT_PATH . '/backend/exceptions/DAODatabaseTransactionException.php');
require_once(ROOT_PATH . '/backend/exceptions/DAOModelException.php');
require_once(ROOT_PATH . '/backend/exceptions/DAORequestedClassException.php');

/**
 * DAOFactory devuelve una instancia de un Objeto DAO solicitado.
 *
 */
class DAOFactory {

	/**
	 * @static
	 */
	private function __construct() {
		
	}

	/**
	 * Devuelve una Instancia de una clase DAO, la cual esta definida en configDAO.ini
	 * 
	 * @static
	 * @param String $type El nombre de la clase a instanciar
	 * @return ObjectDAO La instancia de la clase solicitada
	 */
	public static function getDAO($type) {

		if (!isset($_SESSION)) {
			session_start();
		}

	    $log = null;
		$iniFile = ROOT_PATH . "/backend/config/configDAO.ini";
		// me fijo si ya existe la configuracion en la session
		if (!isset($_SESSION['config']['dao']) || empty($_SESSION['config']['dao'])) {
			// hago el parse del archivo de configuracion
			$iniFile = ROOT_PATH . "/backend/config/configDAO.ini";
			$data = parse_ini_file($iniFile, true);
			// guardo el parse en sesion
			$_SESSION['config']['dao'] = $data;
		}
		$typeDAO = strtolower($type);
		// me fijo si la entrada para que funcione el log
		// seteo de nivel de log
			
		// Verifico que el DAO solicitado exista en la configuracion
		
		if (!key_exists($typeDAO, $_SESSION['config']['dao']['DAOClases'])) {		   
			Helper::dd($_SESSION,"sesion");
			Helper::dd($typeDAO,"Dao que no existe");
			exit;
		    throw new DAOConfigFileException($typeDAO, 'El DAO solicitado no se encuentra configurado.', 0);
		}
		
		// si el archivo de la clase que quiero incluir no existe, tiro una DAOException
		if (!file_exists(ROOT_PATH . $_SESSION['config']['dao']['includes'][$typeDAO])) {
			if (!is_null($log))			
				$log->log("La ruta del archivo de la clase DAO no se encuentra:" . ROOT_PATH . $_SESSION['config']['dao']['includes'][$typeDAO]
						, PEAR_LOG_ERR);
			
			Helper::dd($_SESSION['config']['dao']['includes'][$typeDAO],"sesion");
			Helper::dd($typeDAO,"El include que no existe");
			$message = "Error en la ruta de INCLUDES ' $type ' en el archivo de configuracion";
			throw new DAOConfigFileException($type, $message, 0);
		}
		
		// incluyo la clase que es el Pool de Conexiones
		include_once(ROOT_PATH . $_SESSION['config']['dao']['includes']['poolDb']);
		
		// incluyo la clase GenericDAO, que tiene el manejo basico de transacciones
		if (file_exists((ROOT_PATH . '/backend/dao/GenericDAO.php'))){
        	include_once(ROOT_PATH . '/backend/dao/GenericDAO.php');
       }
		
       // incluyo el archivo de la clase que estoy buscando ( $type )
		include_once(ROOT_PATH . $_SESSION['config']['dao']['includes'][$typeDAO]);

		/* 
		**************************
		aca esta el pool de conexion - reimplementar - 
		***************************
		try {
		    
		    //$daoDB = $_SESSION['config']['dao']['DAOConnection'][$typeDAO];
			//$iniDBFile = ROOT_PATH . $_SESSION['config']['dao']['includes']['configDb'];

			// creo la conexion a la base de datos, con la configuracion del ini que esta en sesion
			
			$conn = ConnectionPool::getConnection($iniDBFile, $daoDB);
			

			// logueo como informacion, la creacion de la conexion a la base de datos.
			
			
		} catch (ADODbMySQLConnectException $e_mysql_connect) {
			throw new DAODatabaseException($e_mysql_connect->getMessage(), $e_mysql_connect->getCode());
		} catch (ADODbOracleConnectException $e_oracle_connect) {
			throw new DAODatabaseException($e_oracle_connect->getMessage(), $e_oracle_connect->getCode());
		} catch (ADODbNewConnectionException $e_new_connection) {
			throw new DAODatabaseException($e_new_connection->getMessage(), $e_new_connection->getCode());
		} catch (ADODbException $e) {
			$msg = 'Unknown Exception: ' . $e->getMessage();
			throw new DAODatabaseException($msg, $e->getCode());
		}
		
		*/
		// creo la instancia de lo que busco y le paso la conexion a la base
		$daoClass = $_SESSION['config']['dao']['DAOClases'][$typeDAO];
		if (!class_exists($daoClass)) {
			if (!is_null($log))
				$log->log("No se encuentra la clase $daoClass. Error en el archivo configDAO.ini", PEAR_LOG_ERR);
			// si la clase no existe, tiro una DAORequestedClassException
			throw new DAORequestedClassException($daoClass, "La clase que se esta solicitando ($daoClass) no esta configurada en configDAO ", 0);
		}
		return new $daoClass();
		//return new $daoClass($conn, $log);
	}

}

?>
