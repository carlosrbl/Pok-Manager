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
                if(isset($_SESSION["iniciada"]))
                {
                    header("Location: ./menu.php");
                }
                else
                {
                    ?>
                    <div class="formulario">
                        <form action="sesion/login.php" method="post" autocomplete="off">
                            <input type="email" name="email" id="email" placeholder="Email" required>
                            <input type="password" name="password" id="password" placeholder="Password" required>
                            <button type="submit">Iniciar Sesión</button>
                        </form>
                        <a onclick="registro()">¿No tienes cuenta? Regístrate</a>
                    </div>
                    <?php
                }
            ?>
        </div>
    </header>