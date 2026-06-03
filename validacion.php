<?php
// NOTA: Para el desarrollo de este código se han seguido diversos tutoriales; sin embargo, debido a la complejidad de las librerías de LDAP en PHP, 
// Se ha utilizado la asistencia de Gemini para realizar la conexión segura (LDAPS), las opciones del protocolo y el mapeo de atributos de AD.
// Toda la configuración del servidor de Directorio Activo, certificados y la arquitectura de red ha sido realizada por nosotros al completo.
putenv('LDAPTLS_REQCERT=never');

$ldap_server = "ldaps://192.168.0.6:636";
$ldap_domain = "smrindustries.com";

$connect = ldap_connect($ldap_server);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario  = trim($_POST["usuario"]);
    $password = $_POST["password"];
    $ldap_user = "SMRINDUSTRIES\\" . $usuario;
    $ldap_conn = @ldap_connect($ldap_server, null);
    
    if ($ldap_conn) {
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);
        @ldap_set_option($ldap_conn, LDAP_OPT_X_SASL_NOCANON, true);

        $ldap_bind = @ldap_bind($ldap_conn, $ldap_user, $password);

        if ($ldap_bind) {
            $nombre_real     = $usuario; 
            $correo_ad       = '';
            $puesto_ad       = 'Empleado';
            $departamento_ad = 'General';
            
            $base_dn = "DC=smrindustries,DC=com"; 
            $filter = "(samaccountname=$usuario)";
            $attributes = array("displayname", "mail", "title", "department");
            $search = @ldap_search($ldap_conn, $base_dn, $filter, $attributes);
            
            if ($search) {
                $entries = @ldap_get_entries($ldap_conn, $search);
                if ($entries["count"] > 0) {
                    if (isset($entries[0]["displayname"][0])) {
                        $nombre_real = $entries[0]["displayname"][0];
                    }
                    if (isset($entries[0]["mail"][0])) {
                        $correo_ad = $entries[0]["mail"][0];
                    }
                    if (isset($entries[0]["title"][0])) {
                        $puesto_ad = $entries[0]["title"][0];
                    }
                    if (isset($entries[0]["department"][0])) {
                        $departamento_ad = $entries[0]["department"][0];
                    }
                }
            }

            @ldap_close($ldap_conn);
            try {
                $base = new PDO("mysql:host=localhost;dbname=smrindustries", "root", "");
                $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM empleados WHERE usuario = :usuario";
                $resultado = $base->prepare($sql); 
                $resultado->bindValue(":usuario", $usuario);
                $resultado->execute(); 

                $registro = $resultado->fetch(PDO::FETCH_ASSOC);

                if ($registro) {
                    $sql_update = "UPDATE empleados 
                                   SET nombre = :nombre, puesto = :puesto, departamento = :departamento, correo = :correo 
                                   WHERE usuario = :usuario";
                    
                    $stmt_update = $base->prepare($sql_update);
                    $stmt_update->execute([
                        ':nombre'       => $nombre_real,
                        ':puesto'       => $puesto_ad,
                        ':departamento' => $departamento_ad,
                        ':correo'       => $correo_ad,
                        ':usuario'      => $usuario
                    ]);

                    $id_usuario_final = $registro["id_usuario"];
                    $nombre_final     = $nombre_real; 
                    
                } else {
                    $sql_insert = "INSERT INTO empleados (usuario, password, nombre, puesto, departamento, correo) 
                                   VALUES (:usuario, 'LDAP_AUTH', :nombre, :puesto, :departamento, :correo)";
                    
                    $stmt_insert = $base->prepare($sql_insert);
                    $stmt_insert->execute([
                        ':usuario'      => $usuario,
                        ':nombre'       => $nombre_real,
                        ':puesto'       => $puesto_ad,
                        ':departamento' => $departamento_ad,
                        ':correo'       => $correo_ad
                    ]);

                    $id_usuario_final = $base->lastInsertId();
                    $nombre_final     = $nombre_real; 
                }

                session_start();
                $_SESSION["usuario"]    = $usuario;
                $_SESSION["id_usuario"] = $id_usuario_final; 
                $_SESSION["nombre"]     = $nombre_final;
                
                header("Location: index");
                exit();

            } catch (Exception $excepcion) {
                die("Error en la Base de Datos local: " . $excepcion->getMessage());
            }

        } else {
            $error_num = ldap_errno($ldap_conn);
            $error_msg = ldap_error($ldap_conn);
            @ldap_close($ldap_conn);
            die("Error de autenticación LDAP: [$error_num] $error_msg.");
        }
    } else {
        die("Error crítico: No se puede alcanzar el servidor LDAP.");
    }
} else {
    header("Location: login");
    exit();
}
?>