<?php
session_start();

try {
    require_once "includes/db_connect.inc.php";
    
    $id_usuario = $_SESSION["usuario_id"];

    $texto_consulta2 = "SELECT cantidad_sobres FROM usuarios WHERE id = ?";
    $consulta2 = $pdo->prepare($texto_consulta2);
    $consulta2->execute([$id_usuario]);

    $usuario = $consulta2->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $sobres = $usuario["cantidad_sobres"];
        
        if ($sobres > 0) {
            $texto_consulta3 = "UPDATE usuarios SET cantidad_sobres = ? WHERE id = ?";
            $consulta3 = $pdo->prepare($texto_consulta3);
            $consulta3->execute([$sobres - 1, $id_usuario]);
            echo json_encode(["success" => true, "mensaje" => "Sobre abierto"]);
        } else {
            echo json_encode(["success" => false, "mensaje" => "No tienes sobres"]);
        }
    }

    $pdo = null;
} catch (PDOException $e) {
    echo json_encode(["success" => false, "mensaje" => $e->getMessage()]);
}
?>
