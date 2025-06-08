<div class="cuadro">
    <p>¡Abre sobres para conseguir nuevas cartas para tu colección!</p>
    <p>Recibes un sobre diario al iniciar sesión. Si no te conectas durante varios días, recibirás un sobre por cada día que no te hayas conectado.</p>
</div>
<div class="sobre">
    <div>    
        <?php
            try 
            {
                $id_usuario = $_SESSION["usuario_id"];

                $texto_consulta = "SELECT cantidad_sobres FROM usuarios WHERE id = ?";
                $consulta = $pdo -> prepare($texto_consulta);
                $consulta -> execute([$id_usuario]);

                $usuario = $consulta -> fetch(PDO::FETCH_ASSOC);

                if ($usuario)
                {
                    $sobres = $usuario["cantidad_sobres"];
                }

                $consulta = null;
            }
            catch (PDOException $e)
            {
                die("<script type='text/javascript'>
                    alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
                    window.location.href = '../index.php';
                    </script>");
            }
        ?>
        <h3>Tus sobres disponibles: <?php echo $sobres; ?></h3>
    </div>
    <a onclick="mostrarPremio()"><img src="img/sobre.png" alt="Sobre"></a>
</div>
<div class="premio" style="display: none;"></div>