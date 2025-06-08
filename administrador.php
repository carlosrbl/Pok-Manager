<?php
    try 
    {
        $id_usuario = $_SESSION["usuario_id"];

        $consulta = $pdo -> prepare("SELECT * FROM usuarios ORDER BY nombre_usuario");
        $consulta -> execute();
        $usuarios = $consulta -> fetchAll(PDO::FETCH_ASSOC);

        ?>
        <div class="tabla">
            <h1>Usuarios Registrados</h1>
            <img src="img/admin.jpeg" alt="Imagen del admin">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Registro</th>
                        <th>Último Acceso</th>
                        <th>Pokémon</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($usuarios)
                        {
                            foreach ($usuarios as $usuario)
                            {
                                echo "<tr>";
                                    echo "<td>" . $usuario["id"] . "</td>";
                                    echo "<td>" . $usuario["nombre_usuario"] . "</td>";
                                    echo "<td>" . $usuario["email"] . "</td>";
                                    $is_admin = $usuario["is_admin"];
                                    if ($is_admin == 1)
                                    {
                                        echo "<td id='admin'>Sí</td>";
                                    }
                                    else
                                    {
                                        echo "<td>No</td>";
                                    }
                                    echo "<td>" . substr($usuario["fecha_registro"],0,10) . "</td>";
                                    if ($usuario["ultimo_acceso"] == null)
                                    {
                                        echo "<td>Desconocido</td>";
                                    }
                                    else
                                    {
                                        echo "<td>" . substr($usuario["ultimo_acceso"],0,16) . "</td>";
                                    }
                                    echo "<td>" . $usuario["cantidad_pokemons"] . "</td>";
                                    
                                    if ($usuario["id"] == $id_usuario)
                                    {
                                        echo "<td>Usuario actual</td>";
                                    }
                                    else
                                    {
                                        ?>
                                        <td>
                                            <button type="button" onclick="editarUsuario(this)"
                                                data-id="<?php echo $usuario['id']; ?>"
                                                data-nombre="<?php echo $usuario['nombre_usuario']; ?>"
                                                data-email="<?php echo $usuario['email']; ?>"
                                                data-esadmin="<?php echo $usuario['is_admin'] ? 'true' : 'false'; ?>">
                                                Editar
                                            </button>
                                        </td>
                                        <?php
                                    }
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    catch (PDOException $e)
    {
        die("<script type='text/javascript'>
            alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
            window.location.href = '../index.php';
            </script>");
    }
?>

<dialog id="formulario-usuario">
    <h1>Editar Usuario</h1>
    <form action="sesion/actualizar_datos.php" method="post" autocomplete="off">
        <input type="hidden" name="id_usuario" id="id_usuario" value="">
        <label for="nombre_usuario">Nombre de usuario</label>
        <input type="text" name="nombre_usuario" required placeholder="Nombre...">
        <label for="email">Email</label>
        <input type="email" name="email" required placeholder="Email...">
        <div class="checkbox-container">
            <input type="checkbox" name="admin">
            <label for="admin">Administrador</label>
        </div>
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="cancelar3()">Cancelar</button>
    </form>
</dialog>