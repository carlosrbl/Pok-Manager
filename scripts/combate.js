function mostrarCombate(pokemonsUsuario, pokemonsRival) 
{
    const tipos = {
        'Normal':    {'Rock': 0.5, 'Ghost': 0, 'Steel': 0.5},
        'Fire':      {'Fire': 0.5, 'Water': 0.5, 'Grass': 2, 'Ice': 2, 'Bug': 2, 'Rock': 0.5, 'Dragon': 0.5, 'Steel': 2},
        'Water':     {'Fire': 2, 'Water': 0.5, 'Grass': 0.5, 'Ground': 2, 'Rock': 2, 'Dragon': 0.5},
        'Electric':  {'Water': 2, 'Electric': 0.5, 'Grass': 0.5, 'Ground': 0, 'Flying': 2, 'Dragon': 0.5},
        'Grass':     {'Fire': 0.5, 'Water': 2, 'Grass': 0.5, 'Poison': 0.5, 'Ground': 2, 'Flying': 0.5, 'Bug': 0.5, 'Rock': 2, 'Dragon': 0.5, 'Steel': 0.5},
        'Ice':       {'Fire': 0.5, 'Water': 0.5, 'Grass': 2, 'Ground': 2, 'Flying': 2, 'Dragon': 2, 'Steel': 0.5},
        'Fighting':  {'Normal': 2, 'Ice': 2, 'Poison': 0.5, 'Flying': 0.5, 'Psychic': 0.5, 'Bug': 0.5, 'Rock': 2, 'Ghost': 0, 'Dark': 2, 'Steel': 2, 'Fairy': 0.5},
        'Poison':    {'Grass': 2, 'Poison': 0.5, 'Ground': 0.5, 'Rock': 0.5, 'Ghost': 0.5, 'Steel': 0, 'Fairy': 2},
        'Ground':    {'Fire': 2, 'Electric': 2, 'Grass': 0.5, 'Poison': 2, 'Flying': 0, 'Bug': 0.5, 'Rock': 2, 'Steel': 2},
        'Flying':    {'Electric': 0.5, 'Grass': 2, 'Fighting': 2, 'Bug': 2, 'Rock': 0.5, 'Steel': 0.5},
        'Psychic':   {'Fighting': 2, 'Poison': 2, 'Psychic': 0.5, 'Dark': 0, 'Steel': 0.5},
        'Bug':       {'Fire': 0.5, 'Grass': 2, 'Fighting': 0.5, 'Poison': 0.5, 'Flying': 0.5, 'Psychic': 2, 'Ghost': 0.5, 'Dark': 2, 'Steel': 0.5, 'Fairy': 0.5},
        'Rock':      {'Fire': 2, 'Ice': 2, 'Fighting': 0.5, 'Ground': 0.5, 'Flying': 2, 'Bug': 2, 'Steel': 0.5},
        'Ghost':     {'Normal': 0, 'Psychic': 2, 'Ghost': 2, 'Dark': 0.5},
        'Dragon':    {'Dragon': 2, 'Steel': 0.5, 'Fairy': 0},
        'Dark':      {'Fighting': 0.5, 'Psychic': 2, 'Ghost': 2, 'Dark': 0.5, 'Fairy': 0.5},
        'Steel':     {'Fire': 0.5, 'Water': 0.5, 'Electric': 0.5, 'Ice': 2, 'Rock': 2, 'Steel': 0.5, 'Fairy': 2},
        'Fairy':     {'Fire': 0.5, 'Fighting': 2, 'Poison': 0.5, 'Dragon': 2, 'Dark': 2, 'Steel': 0.5}
    };

    function calcularMultiplicadorTipo(tipoAtaque, tipoDefensor1, tipoDefensor2) 
    {
        let multiplicador = 1;
        if (tipos[tipoAtaque]) 
        {
            if (tipos[tipoAtaque][tipoDefensor1]) 
            {
                multiplicador *= tipos[tipoAtaque][tipoDefensor1];
            }
            if (tipoDefensor2 && tipos[tipoAtaque][tipoDefensor2]) 
            {
                multiplicador *= tipos[tipoAtaque][tipoDefensor2];
            }
        }
        return multiplicador;
    }

    function calcularDanio(atacante, defensor, esAtaqueEspecial) 
    {
        const tipoAtaque = esAtaqueEspecial ? atacante.tipo1 : 'Normal';
        const multiplicadorTipo = calcularMultiplicadorTipo(tipoAtaque, defensor.tipo1, defensor.tipo2);
        const ataque = esAtaqueEspecial ? atacante.ataque_especial : atacante.ataque;
        const defensa = esAtaqueEspecial ? defensor.defensa_especial : defensor.defensa;
        const danio = ((ataque / (1 + (defensa / 100))) * 0.5 * multiplicadorTipo);
        return danio.toFixed(2);
    }

    function simularCombate(pokemonsUsuario, pokemonsRival) 
    {
        let logCombate = [];
        let usuarioActual = 0;
        let rivalActual = 0;

        while (usuarioActual < pokemonsUsuario.length && rivalActual < pokemonsRival.length) 
        {
            const pokemonUsuario = pokemonsUsuario[usuarioActual];
            const pokemonRival = pokemonsRival[rivalActual];

            let primeroAtacaUsuario = true;
            if (pokemonUsuario.velocidad < pokemonRival.velocidad) 
            {
                primeroAtacaUsuario = false;
            } 
            else if (pokemonUsuario.velocidad === pokemonRival.velocidad) 
            {
                primeroAtacaUsuario = Math.random() < 0.5;
            }

            function realizarAtaque(atacante, defensor, esUsuario) 
            {
                const esAtaqueEspecial = Math.random() < 0.5;
                const danio = calcularDanio(atacante, defensor, esAtaqueEspecial);
                defensor.vida -= parseFloat(danio);
                defensor.vida = Math.max(defensor.vida, 0);
                const atacanteNombre = esUsuario ? 'Tu' : 'El';
                const defensorNombre = esUsuario ? 'del rival' : 'tu';
                logCombate.push(`${atacanteNombre} ${atacante.nombre} usa ataque ${esAtaqueEspecial ? 'especial' : 'físico'} contra ${defensorNombre} ${defensor.nombre}. Causa ${danio} de daño. ${defensor.nombre} HP: ${defensor.vida.toFixed(2)}`);
            }

            let turnoFinalizado = false;

            if (primeroAtacaUsuario) 
            {
                realizarAtaque(pokemonUsuario, pokemonRival, true);
                if (pokemonRival.vida <= 0) 
                {
                    logCombate.push(`El ${pokemonRival.nombre} del rival ha sido derrotado.`);
                    rivalActual++;
                    turnoFinalizado = true;
                }

                if (!turnoFinalizado) 
                {
                    realizarAtaque(pokemonRival, pokemonUsuario, false);
                    if (pokemonUsuario.vida <= 0) 
                    {
                        logCombate.push(`Tu ${pokemonUsuario.nombre} ha sido derrotado.`);
                        usuarioActual++;
                    }
                }
            } 
            else 
            {
                realizarAtaque(pokemonRival, pokemonUsuario, false);
                if (pokemonUsuario.vida <= 0) 
                {
                    logCombate.push(`Tu ${pokemonUsuario.nombre} ha sido derrotado.`);
                    usuarioActual++;
                    turnoFinalizado = true;
                }

                if (!turnoFinalizado) 
                {
                    realizarAtaque(pokemonUsuario, pokemonRival, true);
                    if (pokemonRival.vida <= 0) 
                    {
                        logCombate.push(`El ${pokemonRival.nombre} del rival ha sido derrotado.`);
                        rivalActual++;
                    }
                }
            }
        }

        if (usuarioActual === pokemonsUsuario.length) 
        {
            logCombate.push("Has perdido el combate. ¡Mejor suerte la próxima vez!");
        } 
        else 
        {
            logCombate.push("¡Felicidades! Has ganado el combate.");
        }

        mostrarLogSecuencial(logCombate);
    }

    function mostrarLogSecuencial(logCombate) 
    {
        const partidaDiv = document.querySelector('.partida');
        if (!partidaDiv) 
        {
            console.error("No se encontró el elemento con la clase 'partida'.");
            return;
        }

        partidaDiv.style.display = 'block';
        partidaDiv.innerHTML = "<ol></ol>";
        const lista = partidaDiv.querySelector("ol");

        let i = 0;
        const intervalo = setInterval(() => 
        {
            if (i < logCombate.length) 
            {
                const li = document.createElement("li");
                li.textContent = logCombate[i];
                lista.appendChild(li);
                i++;
            } 
            else 
            {
                clearInterval(intervalo);
            }
        }, 1000);
    }

    simularCombate(pokemonsUsuario, pokemonsRival);
}
