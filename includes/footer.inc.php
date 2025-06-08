    <footer>
        <h1> <?php echo "Carlos Rodrigo Beltrá © " . date("Y") ?> </h1>
    </footer>
    <script src="scripts/funciones.js"></script>
    <script src="scripts/combate.js"></script>
    <script>
        var pokemonsUsuario = <?php echo json_encode($pokemons); ?>;
        var pokemonsRival = <?php echo json_encode($pokemons2); ?>;

        function iniciarCombate() 
        {
            mostrarCombate(pokemonsUsuario, pokemonsRival);
        }
    </script>
</body>
</html>