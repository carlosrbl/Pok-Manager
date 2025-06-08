<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $usuario = $_POST["nombre_usuario"];
        $email = $_POST["email"];
        $email2 = $_POST["email2"];
        $edad = $_POST["edad"];

        if (is_uploaded_file ($_FILES["foto_perfil"]["tmp_name"])) 
        {
            $nombreDirectorio = "../img/profiles/";
            $idUnico = time();   
            $rutaFotoPerfil = $idUnico . "-" . $_FILES["foto_perfil"]["name"]; 
            move_uploaded_file ($_FILES["foto_perfil"]["tmp_name"], $nombreDirectorio . 
            $rutaFotoPerfil);
            $rutaFotoPerfil = $nombreDirectorio . $rutaFotoPerfil;
        }
        else
        {
            $rutaFotoPerfil = "../img/profile_placeholder.png";
        }

        try 
        {
            require_once "../includes/db_connect.inc.php";
            
            $texto_consulta = "SELECT * FROM usuarios";
            $consulta = $pdo -> prepare($texto_consulta);
            $consulta -> execute();

            $usuarios = $consulta -> fetchAll(PDO::FETCH_ASSOC);
            $existe = false;

            foreach ($usuarios as $usuarioExistente)
            {
                if ($usuarioExistente["email"] == $email && $email == $email2)
                {
                    $existe = true;
                }
            }

            if ($existe)
            {
                $_SESSION["error"] = 1;
                header("Location: ../error.php");
            }
            else
            {
                if ($email == $email2)
                {
                    if ($_POST["password"] == $_POST["password2"])
                    {
                        if ($edad >= 14)
                        {
                            $password = password_hash($_POST["password"],PASSWORD_BCRYPT);

                            $texto_consulta2 = "INSERT INTO usuarios (nombre_usuario,email,contrasena,edad,foto_perfil,is_admin,cantidad_sobres,cantidad_pokemons,ultimo_acceso) VALUES (?,?,?,?,?,?,?,?,?)";
                            $consulta2 = $pdo -> prepare($texto_consulta2);
                            $consulta2 -> execute([$usuario,$email,$password,$edad,$rutaFotoPerfil,0,5,0,null]);

                            $pdo = null;
                            $consulta2 = null;

                            die ("<script type='text/javascript'>
                                window.location.href = '../index.php';
                                </script>");
                        }
                        else
                        {
                            $_SESSION["error"] = 4;
                            header("Location: ../error.php");
                        }
                    }
                    else
                    {
                        $_SESSION["error"] = 3;
                        header("Location: ../error.php");
                    }
                }
                else
                {
                    $_SESSION["error"] = 2;
                    header("Location: ../error.php");
                }
            }
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