<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Carlos Rodrigo Beltrá 1º DAW">
    <meta name="description" content="¡Hola PokéManíaco! Tengo una idea revolucionaria que no se le ha ocurrido absolutamente a nadie y que nos va a hacer de oro: ¡un juego de cartas online de Pokémon!">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéManager</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/principal.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="cabecera">
            <img src="img/logo.png" alt="Logo de PokéManager" class="imagen">
            <?php
                $nombre_usuario = $_SESSION["usuario_nombre"];
                $foto_perfil = substr($_SESSION["usuario_foto"],3);
                ?>
                <div class="perfil">
                    <h2>Hola, <?php echo ucfirst($nombre_usuario); ?> </h2>
                    <img src="<?php echo $foto_perfil; ?>" alt="Foto del usuario">
                    <button type="button" onclick="cerrarSesion()" class="button" disabled>Cerrar sesión</button>
                </div>
        </div>
    </header>
    <main>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'Sobres')" id="defaultOpen">Sobres</button>
            <button class="tablinks" onclick="openTab(event, 'Coleccion')">Colección</button>
            <button class="tablinks" onclick="openTab(event, 'Combate')">Combate</button>
            <button class="tablinks" onclick="openTab(event, 'Perfil')">Perfil</button>
            <?php
                try
                {
                    require_once "includes/db_connect.inc.php";

                    $id_usuario = $_SESSION["usuario_id"];
                
                    $texto_consulta = "SELECT is_admin FROM usuarios WHERE id = ?";
                    $consulta = $pdo -> prepare($texto_consulta);
                    $consulta -> execute([$id_usuario]);

                    $usuario = $consulta -> fetch(PDO::FETCH_ASSOC);

                    if ($usuario)
                    {
                        $is_admin = $usuario["is_admin"];
                        if ($is_admin == 1)
                        {
                            ?>
                            <button class="tablinks" onclick="openTab(event, 'Administrador')">Administrador</button>
                            <?php
                        }
                    }
                }
                catch (PDOException $e)
                {
                    die("<script type='text/javascript'>
                        alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
                        window.location.href = './index.php';
                        </script>");
                }
            ?>
        </div>

        <div id="Sobres" class="tabcontent">
            <?php require_once 'sobre.php'; ?>
        </div>

        <div id="Coleccion" class="tabcontent">
            <?php require_once 'coleccion.php'; ?>
        </div>

        <div id="Combate" class="tabcontent">
            <?php require_once 'combate.php'; ?>
        </div>

        <div id="Perfil" class="tabcontent">
            <?php require_once 'perfil.php'; ?>
        </div>

        <div id="Administrador" class="tabcontent">
            <?php require_once 'administrador.php'; ?>
        </div>
    </main>
    <?php
    require_once "includes/footer.inc.php";
    ?>