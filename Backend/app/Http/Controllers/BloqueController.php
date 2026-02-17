<?php

namespace App\Http\Controllers;

use App\Models\Bloque;
use Illuminate\Http\Request;

class BloqueController extends Controller
{
    public function index()
    {
        return response()->json(Bloque::all());
    }
}
