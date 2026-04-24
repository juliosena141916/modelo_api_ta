<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Pokemon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-2xl text-center w-80">

        <!-- BUSCA -->
        <form method="GET" action="/pokedex" class="mb-6 text-center space-y-2">
            <input 
                type="text" 
                name="pokemon" 
                placeholder="Digite o nome ou ID"
                value="{{ $busca ?? '' }}"
                class="border rounded-lg px-4 py-2 w-full"
            >


        <!-- TOGGLE SHINY -->
        <label class="flex items-center justify-center gap-2 text-sm mb-4 cursor-pointer">
            <input type="checkbox" id="shinyToggle">
            Versão Shiny ✨
        </label>

        <!-- NOME -->
        <h1 class="text-2xl font-bold text-gray-800 mb-4 uppercase">
            {{ $pokemon['name'] }}
        </h1>

        <!-- IMAGEM -->
        <div class="bg-blue-50 rounded-full p-4 mb-4">
            <img 
                id="pokemonImage"
                src="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] }}" 
                data-default="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] }}"
                data-shiny="{{ $pokemon['sprites']['other']['official-artwork']['front_shiny'] ?? $pokemon['sprites']['sprites']['front_shiny'] ?? '' }}"
                alt="{{ $pokemon['name'] }}" 
                class="w-full h-auto"
            >
        </div>

        <!-- TIPOS -->
        <div class="flex justify-center gap-2 mb-4">
            @foreach($pokemon['types'] as $tipo)
                <span class="px-3 py-1 bg-yellow-400 text-xs font-bold rounded-full uppercase">
                    {{ $tipo['type']['name'] }}
                </span>
            @endforeach
        </div>

        <!-- INFO -->
        <p class="text-gray-500 text-sm">
            Altura: {{ $pokemon['height'] / 10 }} m | 
            Peso: {{ $pokemon['weight'] / 10 }} kg
        </p>
        
        <!-- RANDOM -->
        <button 
            onclick="window.location.href='/pokedex'" 
            class="mt-6 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition"
        >
            Buscar aleatório
        </button>
    </div>

    <!-- SCRIPT -->
    <script>
        const toggle = document.getElementById('shinyToggle');
        const img = document.getElementById('pokemonImage');

        toggle.addEventListener('change', () => {
            if (toggle.checked && img.dataset.shiny) {
                img.src = img.dataset.shiny;
            } else {
                img.src = img.dataset.default;
            }
        });
    </script>

</body>
</html>