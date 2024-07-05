<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;
use App\Models\TipoEvento;
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
        $eventos = Evento::with('tipoEvento:id,nombre,fondo,borde,texto')->get();
        $eventos->transform(function ($evento) {
            $evento->title = $evento->titulo;
            $evento->start = Carbon::parse($evento->fecha_inicio)->subHours(2)->toIso8601String();
            $evento->end = Carbon::parse($evento->fecha_fin)->subHours(2)->toIso8601String();

            if ($evento->tipoEvento) {
                $evento->color = $evento->tipoEvento->fondo;
                $evento->textColor = $evento->tipoEvento->texto;
                $evento->borderColor = $evento->tipoEvento->borde;
            }

            unset($evento->fecha_inicio, $evento->fecha_fin, $evento->titulo, $evento->tipoEvento);

            return $evento;
        });

        return response()->json($eventos);
    }
}
