<dialog id="formulario-registro">
    <div class="registro">
        <div class="registro_imagen">
            <img src="img/registro.jpeg" alt="Foto del registro">
        </div>
        <form action="sesion/signup.php" method="post" autocomplete="off" enctype="multipart/form-data">
            <label for="nombre_usuario">Nombre de usuario</label>
            <input type="text" name="nombre_usuario" required placeholder="Nombre...">
            <label for="email">Email</label>
            <input type="email" name="email" required placeholder="Email...">
            <label for="email2">Repetir email</label>
            <input type="email" name="email2" required placeholder="Email...">
            <label for="password">Contraseña</label>
            <input type="password" name="password" required placeholder="Password...">
            <label for="password2">Repetir contraseña</label>
            <input type="password" name="password2" required placeholder="Password...">
            <label for="edad">Edad</label>
            <input type="number" name="edad" required placeholder="Edad...">
            <label for="foto_perfil">Foto de perfil</label>
            <input type="file" name="foto_perfil">
            <button type="submit">Registrarse</button>
            <button type="button" onclick="cancelar1()">Cancelar</button>
        </form>
    </div>
</dialog>