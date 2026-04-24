<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index(request $request)
    {
        $busca = $request->input('pokemon') ?? rand(1, 1025);
        // $id = rand(1, 1025);
        $nomeouid = strtolower($busca);
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$nomeouid}");

        if ($response->successful()) {
            $pokemon = $response->json();

            return view('pokemon', compact('pokemon'));
        }
        return back()->with("Erro ao buscar dados");
    }
}
