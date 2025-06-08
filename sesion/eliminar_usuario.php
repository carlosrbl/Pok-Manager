<?php
    session_start();

    $id_usuario = $_SESSION["usuario_id"];

    try
    {   
        require_once "../includes/db_connect.inc.php";

        $texto_consulta = "DELETE FROM usuarios WHERE id = ?";
        $consulta = $pdo -> prepare($texto_consulta);
        $consulta -> execute([$id_usuario]);

        $pdo = null;
        $consulta = null;
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        die();
    }
    catch (PDOException $e)
    {
        die("<script type='text/javascript'>
            alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
            window.location.href = 'index.php';
        </script>");
    }
?>
