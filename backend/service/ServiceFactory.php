<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// se cargan las excepciones Service para manejar los errores de los servicios
require_once(ROOT_PATH . '/backend/exceptions/ServiceException.php');
require_once(ROOT_PATH . '/backend/exceptions/ServiceConfigFileException.php');
require_once(ROOT_PATH . '/backend/exceptions/ServiceDatabaseException.php');
require_once(ROOT_PATH . '/backend/exceptions/ServiceRequestedClassException.php');

/**
 * Se encarga de buscar el servicio solicitado a traves de su unico metodo.
 *
 * @static
 */
class ServiceFactory {

    /**
     * @static
     */
    private function __construct() {
        
    }

    /**
     * Devuelve la instancia al servicio solicitado.
     *
     * @static
     * @param String $type El nombre del servicio especificado en el archivo configService.ini
     * @return ServiceObject
     */
    public static function getService($type) {
        if (!isset($_SESSION)) {
            session_start();
        }

        $type = strtolower($type);
        
        // me fijo si ya existe la configuracion en la session
        if (!isset($_SESSION['config']['service']) || empty($_SESSION['config']['service'])) {
            $iniFile = ROOT_PATH . "/backend/config/configService.ini";
            $data = parse_ini_file($iniFile, true);
            $_SESSION['config']['service'] = $data;
        }
        $type = strtolower($type);


        // Verifico que el DAO solicitado exista en la configuracion
        if (!key_exists($type, $_SESSION['config']['service']['clases'])) {
            throw new ServiceConfigFileException($type, 'El Servicio solicitado no se encuentra configurado.', 0);
        }

        /*    
        echo "No hace el require_once" . ROOT_PATH ;    
        print_r($_SESSION);        
        echo "Este es el valor de type:". $type;
        exit;
        **/
        // si da error en esta linea 65 y la 70, ver el valor de la session para ver si el archivo, de confir de los servicio esta cargado en memoria correctamente 
        //Helper::utilesPrint($_SESSION['config'], "session condig", false);  
        if (!file_exists(ROOT_PATH . $_SESSION['config']['service']['includes'][$type])) {
            $message = "El servicio no se encuentra configurado correctamente en el archivo configService.ini";
            throw new ServiceConfigFileException($_SESSION['config']['service']['clases'][$type], $message, 0);
        }
        
        require_once(ROOT_PATH . $_SESSION['config']['service']['includes'][$type]);

        
        if (!file_exists(ROOT_PATH . $_SESSION['config']['service']['config']['DAOFactory'])) {
            $message = "La clase DAOFactory no se encuentra configurada correctamente en el archivo configService.ini";
            throw new ServiceRequestedClassException('DAOFactory', $message);
        }

        require_once(ROOT_PATH . $_SESSION['config']['service']['config']['DAOFactory']);

        $serviceObject = $_SESSION['config']['service']['clases'][$type];
        if (!class_exists($serviceObject)) {
            $message = "El servicio no se encuentra configurado correctamente en el archivo configService.ini";
            throw new ServiceRequestedClassException($serviceObject, $message); /* FALTA UN TERCER ARGUMENTO */
        }

        return new $serviceObject();
    }

}

?>
