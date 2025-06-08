<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = $_POST["email"];
        $contrasena = $_POST["password"];

        try
        {
            require_once "../includes/db_connect.inc.php";

            $texto_consulta = "SELECT id, nombre_usuario, email, contrasena, foto_perfil FROM usuarios WHERE email = ?";
            $consulta = $pdo -> prepare($texto_consulta);
            $consulta -> execute([$email]);

            if ($consulta -> rowCount() > 0)
            {
                $fila = $consulta -> fetch(PDO::FETCH_ASSOC);
                $contrasenaHash = $fila["contrasena"];

                if (password_verify($contrasena,$contrasenaHash))
                {
                    $_SESSION["iniciada"] = true;
                    $_SESSION["usuario_id"] = $fila["id"];
                    $_SESSION["usuario_nombre"] = $fila["nombre_usuario"];
                    $_SESSION["usuario_email"] = $fila["email"];
                    $_SESSION["usuario_foto"] = $fila["foto_perfil"];

                    $texto_consulta5 = "SELECT ultimo_acceso FROM usuarios WHERE email = ?";
                    $consulta5 = $pdo -> prepare($texto_consulta5);
                    $consulta5 -> execute([$email]);

                    $datos = $consulta5 -> fetch(PDO::FETCH_ASSOC);

                    if ($datos)
                    {
                        $ultimo_acceso = new DateTime($datos["ultimo_acceso"]);
                    }

                    $texto_consulta2 = "UPDATE usuarios SET ultimo_acceso = ? WHERE email = ?";
                    $consulta2 = $pdo -> prepare($texto_consulta2);
                    
                    $logeo = new DateTime();
                    $sinSegundos = $logeo -> format('Y-m-d H:i');
                    $consulta2 -> execute([$sinSegundos, $email]);

                    $texto_consulta3 = "SELECT ultimo_acceso, cantidad_sobres FROM usuarios WHERE email = ?";
                    $consulta3 = $pdo -> prepare($texto_consulta3);
                    $consulta3 -> execute([$email]);

                    $usuario = $consulta3 -> fetch(PDO::FETCH_ASSOC);

                    if ($usuario)
                    {   
                        $ahora = new DateTime();
                        $sinSegundos = $ahora -> format('Y-m-d H:i');
                        
                        $diferencia = $ahora -> diff($ultimo_acceso);

                        if ($diferencia -> days >= 1)
                        {
                            $nuevos_sobres = $usuario["cantidad_sobres"] + $diferencia -> days;
                            $texto_consulta4 = "UPDATE usuarios SET cantidad_sobres = ? WHERE email = ?";
                            $consulta4 = $pdo -> prepare($texto_consulta4);
                            $consulta4 -> execute([$nuevos_sobres, $email]);
                        }
                    }

                    die("<script type='text/javascript'>
                        window.location.href = '../index.php';
                        </script>");
                }
                else
                {
                    $_SESSION["error"] = 5;
                    header("Location: ../error.php");
                }
            }
            else
            {
                $_SESSION["error"] = 5;
                header("Location: ../error.php");
            }

            $pdo = null;
            $consulta4 = null;
        }
        catch (PDOException $e)
        {
            die("<script type='text/javascript'>
                alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
                window.location.href = '../index.php';
                </script>");
        }
    }
    else
    {
        header("Location: ../index.php");
    }
?>