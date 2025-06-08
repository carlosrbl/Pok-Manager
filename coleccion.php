<?php
    $id_usuario = $_SESSION["usuario_id"];

    try
    {
        $stmt = $pdo->prepare("SELECT * FROM coleccion WHERE usuario_id = ?");
        $stmt->execute([$id_usuario]);
        $coleccion = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $contadorPokemons = count($coleccion);
        $_SESSION["usuario_pokemnos"] = count($coleccion);

        function calcularPorcentajeCompletado($total, $tengo) 
        {
            if ($total == 0) {
                return 0;
            }
            return ($tengo / $total) * 100;
        }
    }
    catch (PDOException $e) 
    {
        die("<script type='text/javascript'>
            alert('Ha fallado la conexión: " . addslashes($e->getMessage()) . "');
            window.location.href = './index.php';
        </script>");
    }
?>

<div class="coleccion">
    <img src="img/coleccion.png" alt="Foto de la colección">
    <div class="info_coleccion">
        <div class="cuadrado">
            <?php
                echo "" . round(calcularPorcentajeCompletado(721,$contadorPokemons),2) . " %";
                echo '<p>Completado</p>';
            ?>
        </div>
        <div class="cuadrado">
            <?php
                echo "" . $contadorPokemons;
                echo '<p>Pokémons</p>';
            ?>
        </div>
    </div>
    <div class="pokemons">
        <?php
            try
            {
                if ($coleccion)
                {
                    $ids = [];
                    foreach ($coleccion as $conseguidos)
                    {
                        $ids[] = $conseguidos["pokemon_id"];   
                    }
                    $placeholders = implode(',', array_fill(0, count($ids), '?'));
                    $consulta = $pdo->prepare("SELECT * FROM pokemon WHERE id IN ($placeholders) ORDER BY nombre");
                    $consulta->execute($ids);

                    $pokemons = $consulta -> fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($pokemons as $pokemon) 
                    {
                        $texto_consulta = "SELECT legendario FROM pokemon WHERE id = ?";
                        $consulta = $pdo -> prepare($texto_consulta);
                        $consulta -> execute([$pokemon['id']]);

                        $legendario = $consulta -> fetch(PDO::FETCH_ASSOC);

                        $is_legendario = $legendario ? $legendario["legendario"] : 0;

                        $pokemon_class = $is_legendario == 1 ? 'legendario' : 'pokemon';

                        echo '<div class="' . $pokemon_class . '">';
                        echo '<img src="' . htmlspecialchars($pokemon['icono_ruta']) . '" alt="' . htmlspecialchars($pokemon['nombre']) . '">';
                        echo '<p>' . htmlspecialchars($pokemon['nombre']) . '</p>';
                        echo '</div>';
                    }
                }
            }
            catch (PDOException $e) 
            {
                die("<script type='text/javascript'>
                    alert('Ha fallado la conexión: " . addslashes($e->getMessage()) . "');
                    window.location.href = './index.php';
                </script>");
            }
        ?>
    </div>
</div>