<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $idUsuario = $_POST["id_usuario"];
        $usuario = $_POST["nombre_usuario"];
        $email = $_POST["email"];
        $esAdmin = isset($_POST["admin"]) ? 1 : 0;
          
        require_once "../includes/db_connect.inc.php";
        
        $texto_consulta = "SELECT * FROM usuarios";
        $consulta = $pdo -> prepare($texto_consulta);
        $consulta -> execute();

        $usuarios = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        $existe = false;
        
        foreach ($usuarios as $usuarioExistente) 
        {
            if ($usuarioExistente["email"] == $email && $usuarioExistente["id"] != $idUsuario) 
            {
                $existe = true;
            }
        }

        if (!$existe)
        {
            $texto_consulta2 = "UPDATE usuarios SET nombre_usuario = ?, email = ?, is_admin = ? WHERE id = ?";
            $consulta2 = $pdo -> prepare($texto_consulta2);
            $consulta2 -> execute([$usuario,$email,$esAdmin,$idUsuario]);

            $pdo = null;
            $consulta = null;

            die("<script type='text/javascript'>
                window.location.href = '../index.php';
            </script>");
        }
        else
        {
            die("<script type='text/javascript'>
            alert('Email en uso');
            window.location.href = '../index.php';
            </script>");
        }
    }
    else
    {
        header("Location: ./index.php");
    }
?>