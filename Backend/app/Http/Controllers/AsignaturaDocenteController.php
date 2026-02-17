<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Models\AsignaturaDocente;
use Illuminate\Http\Request;

class AsignaturaDocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Asignatura::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AsignaturaDocente  $asignaturaDocente
     * @return \Illuminate\Http\Response
     */
    public function show(AsignaturaDocente $asignaturaDocente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AsignaturaDocente  $asignaturaDocente
     * @return \Illuminate\Http\Response
     */
    public function edit(AsignaturaDocente $asignaturaDocente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AsignaturaDocente  $asignaturaDocente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AsignaturaDocente $asignaturaDocente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AsignaturaDocente  $asignaturaDocente
     * @return \Illuminate\Http\Response
     */
    public function destroy(AsignaturaDocente $asignaturaDocente)
    {
        //
    }
}
