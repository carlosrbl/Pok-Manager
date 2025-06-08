<?php
    session_start();
    $id_usuario = $_SESSION["usuario_id"];

    require_once "includes/db_connect.inc.php";

    $randomNumbers = [];
    while (count($randomNumbers) < 5) {
        $num = rand(1, 721);
        if (!in_array($num, $randomNumbers)) {
            $randomNumbers[] = $num;
        }
    }

    try {
        $placeholders = implode(',', array_fill(0, count($randomNumbers), '?'));
        $stmt = $pdo->prepare("SELECT * FROM pokemon WHERE id IN ($placeholders) ORDER BY nombre");
        $stmt->execute($randomNumbers);
        $pokemons = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        echo '<h3>¡Has conseguido las siguientes cartas!</h3>';
        echo '<div class="pokemons">';

        foreach ($pokemons as $pokemon) {
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
        echo '</div>';
        echo '<div class="premio-container">';
        echo '<button type="button" onclick="cerrarSobre()">Cerrar Sobre</button>';
        echo '</div>';

        for($i = 0; $i < count($randomNumbers); $i++)
        {
            $texto_consulta = "INSERT IGNORE INTO coleccion (usuario_id,pokemon_id) VALUES (?,?)";
            $consulta = $pdo -> prepare($texto_consulta);
            $consulta -> execute([$id_usuario,$randomNumbers[$i]]);
        }
        
        $stmt4 = $pdo->prepare("SELECT * FROM coleccion WHERE usuario_id = ?");
        $stmt4->execute([$id_usuario]);
        $coleccion = $stmt4 -> fetchAll(PDO::FETCH_ASSOC);

        $cantidad_pokemons = count($coleccion);

        $texto_consulta4 = "UPDATE usuarios SET cantidad_pokemons = ? WHERE id = ?";
        $consulta4 = $pdo -> prepare($texto_consulta4);
        $consulta4 -> execute([$cantidad_pokemons,$id_usuario]);
        
        $pdo = null;
        $consulta = null;
    } 
    catch (PDOException $e) {
        echo '<p>Error al obtener Pokémon: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
?>
