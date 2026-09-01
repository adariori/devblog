<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord réservé à l'administrateur.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
