<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex API</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        body { background-color: #2c3e50; }
        .pixel-font { font-family: 'Press+Start+2P', cursive; }
        .pokedex-border { border: 10px solid #8b0000; }
        .screen-gradient { background: linear-gradient(145deg, #98cb98, #7ba37b); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="bg-red-600 p-6 rounded-3xl shadow-[20px_20px_0px_0px_rgba(0,0,0,0.3)] w-full max-w-sm pokedex-border relative">
        
        <div class="flex gap-2 mb-6">
            <div class="w-12 h-12 bg-blue-400 border-4 border-white rounded-full shadow-inner"></div>
            <div class="w-3 h-3 bg-red-800 rounded-full"></div>
            <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
        </div>

        <div class="bg-gray-200 p-4 rounded-lg border-b-4 border-r-4 border-gray-400 shadow-inner">
            
            <form method="GET" action="/pokedex" class="mb-4">
                <input 
                    type="text" 
                    name="pokemon" 
                    placeholder="Nome ou ID"
                    value="{{ $busca ?? '' }}"
                    class="w-full px-3 py-2 bg-gray-800 text-green-400 border-2 border-gray-600 rounded font-mono text-sm focus:outline-none focus:border-blue-400"
                >
                <button type="submit" class="hidden"></button>
            </form>

            <div class="screen-gradient p-4 rounded-md border-4 border-gray-800 shadow-inner mb-4">
                <h1 class="pixel-font text-[10px] text-gray-800 mb-3 text-center uppercase tracking-tighter">
                    {{ $pokemon['name'] }}
                </h1>

                <div class="flex justify-center items-center h-40 bg-white/20 rounded-lg">
                    <img 
                        id="pokemonImage"
                        src="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] }}" 
                        data-default="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] }}"
                        data-shiny="{{ $pokemon['sprites']['other']['official-artwork']['front_shiny'] ?? $pokemon['sprites']['front_shiny'] ?? '' }}"
                        alt="{{ $pokemon['name'] }}" 
                        class="max-h-full drop-shadow-xl transition-transform hover:scale-110 duration-300"
                    >
                </div>
            </div>

            <div class="flex justify-center gap-2 mb-3">
                @foreach($pokemon['types'] as $tipo)
                    <span class="px-3 py-1 bg-gray-800 text-white text-[8px] pixel-font rounded uppercase">
                        {{ $tipo['type']['name'] }}
                    </span>
                @endforeach
            </div>

            <div class="bg-gray-800 p-2 rounded text-[10px] text-green-400 font-mono flex justify-around">
                <span>HT: {{ $pokemon['height'] / 10 }}m</span>
                <span>WT: {{ $pokemon['weight'] / 10 }}kg</span>
            </div>

            <div class="flex justify-around mt-4">
                @foreach($evolutions as $evo)
                    <div class="flex flex-col items-center">
                        <img src="{{ $evo['sprite'] }}" class="w-20 h-20">
                        <span class="text-[6px] pixel-font">{{ $evo['name'] }}</span>
                    </div>
                @endforeach
            </div>

            @foreach($pokemon['stats'] as $stat)
            <div class="flex justify-between items-center text-[8px] pixel-font uppercase text-gray-700">
                <span>{{ $stat['stat']['name'] }}</span>
                <span>{{ $stat['base_stat'] }}</span>
            </div>
            <div class="w-full bg-gray-300 h-1 mb-2">
                <div class="bg-blue-500 h-full" style="width: {{ ($stat['base_stat'] / 255) * 100 }}%"></div>
            </div>
            @endforeach


        </div>

        <div class="mt-6 flex flex-col items-center gap-4">
            
            <label class="flex items-center gap-3 text-white font-bold cursor-pointer group">
                <input type="checkbox" id="shinyToggle" class="w-5 h-5 accent-yellow-400">
                <span class="group-hover:text-yellow-300 transition-colors">✨ VERSÃO SHINY</span>
            </label>

            <div class="flex w-full justify-between items-center px-2">
                <div class="w-12 h-12 bg-gray-800 rounded-full border-4 border-gray-900 shadow-lg"></div> <button 
                    onclick="window.location.href='/pokedex'" 
                    class="bg-blue-500 hover:bg-blue-400 border-b-4 border-blue-700 active:border-b-0 text-white text-[10px] pixel-font py-3 px-4 rounded-lg transition-all"
                >
                    RANDOM
                </button>

                <div class="flex gap-1">
                    <div class="w-8 h-2 bg-red-900 rounded-full"></div>
                    <div class="w-8 h-2 bg-blue-900 rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

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