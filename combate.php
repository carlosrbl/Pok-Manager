<div class="cuadro">
    <p>¡Enfréntate a otros entrenadores en combates Pokémon! Pon a prueba la fuerza de tu colección y gana sobres.</p>
    <p>Se seleccionarán 6 Pokémon aleatorios de tu colección para luchar contra el equipo de otro entrenador. Si ganas, ¡recibirás 2 sobres!</p>
</div>
<?php
    $id_usuario = $_SESSION["usuario_id"];

    $texto_consulta = "SELECT MAX(id) as max_id FROM usuarios";
    $consulta = $pdo->prepare($texto_consulta);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    $ultimoID = $resultado ? $resultado["max_id"] : 0;

    $usuarioRandom = $id_usuario;
    $nombreRival = null;

    while ($usuarioRandom == $id_usuario || $nombreRival === null) 
    {
        $usuarioRandom = rand(1, $ultimoID);

        $texto_consulta2 = "SELECT nombre_usuario FROM usuarios WHERE id = ? AND id != ?";
        $consulta2 = $pdo->prepare($texto_consulta2);
        $consulta2->execute([$usuarioRandom, $id_usuario]);

        $rival = $consulta2->fetch(PDO::FETCH_ASSOC);

        if ($rival) 
        {
            $nombreRival = $rival["nombre_usuario"];
        }
    }

    $stmt = $pdo->prepare("SELECT * FROM coleccion WHERE usuario_id = ?");
    $stmt->execute([$id_usuario]);
    $coleccion1 = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $pdo->prepare("SELECT * FROM coleccion WHERE usuario_id = ?");
    $stmt2->execute([$usuarioRandom]);
    $coleccion2 = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Combate contra <?php echo ucfirst($nombreRival); ?></h2>
<a href="#" onclick="iniciarCombate(); return false;"><img id="start" src="img/start.png" alt="Botón de start"></a>
<div class="combate">
    <h3 class="tituloEquipo">Tu Equipo</h3>
    <div class="equipos">
        <?php
            if ($coleccion1)
            {
                $ids = [];
                foreach ($coleccion1 as $conseguidos)
                {
                    $ids[] = $conseguidos["pokemon_id"];   
                }

                shuffle($ids);
                $ids = array_slice($ids, 0, 5);
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $consulta4 = $pdo->prepare("SELECT * FROM pokemon WHERE id IN ($placeholders) ORDER BY nombre");
                $consulta4->execute($ids);

                $pokemons = $consulta4 -> fetchAll(PDO::FETCH_ASSOC);

                foreach ($pokemons as $pokemon) 
                {
                    $texto_consulta5 = "SELECT legendario FROM pokemon WHERE id = ?";
                    $consulta5 = $pdo -> prepare($texto_consulta5);
                    $consulta5 -> execute([$pokemon['id']]);

                    $legendario = $consulta5 -> fetch(PDO::FETCH_ASSOC);

                    $is_legendario = $legendario ? $legendario["legendario"] : 0;

                    $pokemon_class = $is_legendario == 1 ? 'legendario2' : 'combateEquipo';

                    echo '<div class="' . $pokemon_class . '">';
                    echo '<img src="' . htmlspecialchars($pokemon['icono_ruta']) . '" alt="' . htmlspecialchars($pokemon['nombre']) . '">';
                    echo '<p>' . htmlspecialchars($pokemon['nombre']) . '</p>';
                    echo '</div>';
                }
            }
            else
            {
                ?>
                <div class="cuadro">
                    <p>El usuario actual no dispone de Pokémons suficientes</p>
                </div>
                <?php
            }
        ?>
    </div>
    <h3 class="tituloEquipo">Equipo de <?php echo ucfirst($nombreRival); ?></h3>
    <div class="equipos">
        <?php
            if ($coleccion2)
            {
                $ids2 = [];
                foreach ($coleccion2 as $conseguidos2)
                {
                    $ids2[] = $conseguidos2["pokemon_id"];   
                }

                shuffle($ids2);
                $ids2 = array_slice($ids2, 0, 5);
                $placeholders = implode(',', array_fill(0, count($ids2), '?'));
                $consulta4 = $pdo->prepare("SELECT * FROM pokemon WHERE id IN ($placeholders) ORDER BY nombre");
                $consulta4->execute($ids2);

                $pokemons2 = $consulta4 -> fetchAll(PDO::FETCH_ASSOC);

                foreach ($pokemons2 as $pokemon2) 
                {
                    $texto_consulta5 = "SELECT legendario FROM pokemon WHERE id = ?";
                    $consulta5 = $pdo -> prepare($texto_consulta5);
                    $consulta5 -> execute([$pokemon2['id']]);

                    $legendario = $consulta5 -> fetch(PDO::FETCH_ASSOC);

                    $is_legendario = $legendario ? $legendario["legendario"] : 0;

                    $pokemon_class = $is_legendario == 1 ? 'legendario2' : 'combateEquipo';

                    echo '<div class="' . $pokemon_class . '">';
                    echo '<img src="' . htmlspecialchars($pokemon2['icono_ruta']) . '" alt="' . htmlspecialchars($pokemon2['nombre']) . '">';
                    echo '<p>' . htmlspecialchars($pokemon2['nombre']) . '</p>';
                    echo '</div>';
                }
            }
            else
            {
                ?>
                <div class="cuadro">
                    <p>EL rival no dispone de Pokémons suficientes</p>
                </div>
                <?php
            }
        ?>
    </div>
</div>
<h2>Registro de Combate</h2>
<div class="partida" style="display: none;"></div>
<button type="button" id="generarCombate" onclick="location.reload()">Generar otro combate</button>