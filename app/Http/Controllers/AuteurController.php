<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuteurController extends Controller
{
    //
    private array $auteurs = [
        1 => ['auteur' => 'A', 'bio' => 'B'],
        2 => ['auteur' => 'C', 'bio' => 'D'],
        3 => ['auteur' => 'E', 'bio' => 'F'],
    ];

    public function index()
    {
        $auteurs = $this->auteurs;

        return view('auteurs.index', compact('auteurs'));
    }

    public function show($id)
    {
        if (!isset($this->auteurs[$id])) {
            abort(404);
        }

        $auteur = $this->auteurs[$id];

        return view('auteurs.show', compact('auteur'));
    }
}
