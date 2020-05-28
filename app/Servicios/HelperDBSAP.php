<?php
namespace App\Servicios;

class HelperDBSAP
{
    public static function consultarSAP($sql)
    {
        $MANDANTE = "300";
        $data = [];
        try {
            
            if (!extension_loaded('odbc')) {
                die('ODBC extension not enabled / loaded');
            }
            
            $driver = 'HDBODBC';
            $host = "10.1.54.30:30215";
            $db_name = "HDB";
            $username = 'USER_QUERY_OLMOS';
            $password = "O4p_olmos04";            
            
            /*
            $driver = 'HDBODBC';
            $host = "10.1.54.27:30415";
            $db_name = "HDB";
            $username =  "USER_QUERY_OLMOS";
            $password =  "O4q_olmos02";
            **/

            $conn = odbc_connect("Driver=$driver;ServerNode=$host;Database=$db_name;", $username, $password, SQL_CUR_USE_ODBC);
    
            if (!$conn) {
                // Try to get a meaningful error if the connection fails
                echo "Connection failed.\n";
                echo "ODBC error code: " . odbc_error() . ". Message: " . odbc_errormsg();
            } else {                
                $result = odbc_exec($conn, $sql);
                if (!$result) {
                    echo "Error while sending SQL statement to the database server.\n";
                } else {
                    while ($row = odbc_fetch_object($result)) {
                        array_push($data, $row);
                    }
                }
                odbc_close($conn);
            }

        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">';
            echo "Erro general sin controlar: " . $e->getMessage();
            echo '</div>';
        }
        return $data;
    }
    

}
