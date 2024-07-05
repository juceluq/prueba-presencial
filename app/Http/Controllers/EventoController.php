<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;
use Carbon\Carbon;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventoRequest $request, Evento $evento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        //
    }

    public function apiGetEventos()
    {

        $eventos = Evento::select('id', 'titulo', 'fecha_inicio', 'fecha_fin', 'tipo_evento_id')->get();
        $eventos->transform(function ($evento) {
            $evento->title = $evento->titulo;
            $evento->start = Carbon::parse($evento->fecha_inicio)->subHours(2)->toIso8601String();
            $evento->end = Carbon::parse($evento->fecha_fin)->subHours(2)->toIso8601String();
            unset($evento->fecha_inicio, $evento->fecha_fin, $evento->titulo);
            return $evento;
        });

        return response()->json($eventos);
    }
}
