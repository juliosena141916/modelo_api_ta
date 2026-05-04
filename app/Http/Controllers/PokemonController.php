<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        // 1. Define the ID or Name
        $busca = $request->input('pokemon') ?? rand(1, 1025);
        $nomeouid = strtolower($busca);

        // 2. Fetch Base Pokemon Data
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$nomeouid}");

        if ($response->successful()) {
            $pokemon = $response->json();

            // 3. Fetch Species Data (Required to get the evolution chain URL)
            $speciesResponse = Http::get($pokemon['species']['url']);
            
            $evolutions = [];
            if ($speciesResponse->successful()) {
                $speciesData = $speciesResponse->json();
                
                // 4. Fetch the Evolution Chain
                $evolutionChainResponse = Http::get($speciesData['evolution_chain']['url']);
                
                if ($evolutionChainResponse->successful()) {
                    $chainData = $evolutionChainResponse->json()['chain'];
                    
                    // Helper to loop through the chain and build a clean array
                    $current = $chainData;
                    do {
                        $evoId = basename($current['species']['url']);
                        $evolutions[] = [
                            'name' => $current['species']['name'],
                            'id'   => $evoId,
                            'sprite' => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$evoId}.png"
                        ];
                        // Get the first evolution in the branch (simplification)
                        $current = $current['evolves_to'][0] ?? null;
                    } while ($current);
                }
            }

            // Return the view with all necessary data
            return view('pokemon', compact('pokemon', 'evolutions', 'busca'));
        }

        return back()->with("error", "Pokémon não encontrado!");
    }
}