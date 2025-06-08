    <main>
        <div class="contenedor">
            <h1>Ooops... ¡algo ha fallado!</h1>
            <p>
                <?php
                    if ($codigoError == 1)
                    {
                        echo "<h3>Este email ya se está usando</h3>";
                    }
                    elseif ($codigoError == 2)
                    {
                        echo "<h3>Los correos electrónicos no coinciden</h3>";
                    }
                    elseif ($codigoError == 3)
                    {
                        echo "<h3>Las contraseñas no coinciden</h3>";
                    }
                    elseif ($codigoError == 4)
                    {
                        echo "<h3>Debe tener al menos 14 años para registrarte</h3>";
                    }
                    elseif ($codigoError == 5)
                    {
                        echo "<h3>Usuario o contraseña incorrectos</h3>";
                    }
                ?>
            </p>
        </div>        
    </main>