<?php
    $id_usuario = $_SESSION["usuario_id"];
    $cantidad_pokemons = $_SESSION["usuario_pokemnos"];
    try
    {
        $consulta = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $consulta -> execute([$id_usuario]);
        $perfil_datos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

        $foto_perfil = substr($_SESSION["usuario_foto"],3);

        if ($perfil_datos)
        {
            ?>
            <div class="perfil_usuario">
                <div class="perfil_datos">
                    <img src="<?php echo $foto_perfil; ?>" alt="Foto del usuario">
                    <div class="perfil_textos">
                        <h1>Usuario: <?php echo ucfirst($_SESSION["usuario_nombre"]); ?></h1>
                        <h2>Email: <?php echo $_SESSION["usuario_email"]; ?></h2>
                        <?php
                        foreach ($perfil_datos as $datos)
                        {
                            $ahora = new DateTime();
                            $sinSegundos = $ahora -> format('Y-m-d H:i');

                            $registro = new DateTime($datos["fecha_registro"]);
                            $sinSegundos2 = $registro -> format('Y-m-d H:i');
                        
                            $diferencia = $ahora -> diff($registro);

                            $diferenciaDias = $diferencia->days;
                            ?>
                            <h3>Edad: <?php echo $datos["edad"]; ?> años</h3>
                            <h3>Registro: <?php echo substr($datos["fecha_registro"],0,10) . " (hace " . $diferenciaDias . " dias)"; ?></h3>
                            <h3>Último acceso: <?php echo substr($datos["ultimo_acceso"],0,16); ?></h3>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="perfil_extra">
                    <div class="perfil_complementario">
                        <h1><?php echo $cantidad_pokemons; ?></h1>
                        <p>Pokémon en colección</p>
                    </div>
                    <div class="perfil_complementario">
                        <?php
                        foreach ($perfil_datos as $datos)
                        {
                            ?>
                            <h1><?php echo $datos["cantidad_sobres"]; ?></h1>
                            <p>Sobres disponibles</p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <button type="button" onclick="eliminarUsuario()">Eliminar mi Cuenta</button>
            </div>
            <?php
        }
    }
    catch (PDOException $e)
    {
        die("<script type='text/javascript'>
            alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
            window.location.href = '../index.php';
            </script>");
    }
?>

<dialog id="dialog-eliminar-cuenta">
    <h1>¿SEGURO?</h1>
    <div class="centrar">   
        <button type="button" id="boton-borrar" onclick="borrar()">Sí</button>
        <button type="button" id="boton-cancelar" onclick="cancelar2()">No</button>
    </div>
</dialog>