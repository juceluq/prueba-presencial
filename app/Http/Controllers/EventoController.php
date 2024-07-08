<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;
use App\Models\TipoEvento;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EventoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventoRequest $request)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'edit_startDate' => 'required|date_format:Y-m-d\TH:i',
                'edit_endDate' => 'required|date_format:Y-m-d\TH:i',
                'edit_titulo' => 'required|string|max:255',
                'choose_tipo_evento' => 'required|integer',
            ]);

            $evento = Evento::find($request->edit_id);

            if (!$evento) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Evento no encontrado.'
                ]);
            }
            $eventoData = [
                'fecha_inicio' => $validatedData['edit_startDate'],
                'fecha_fin' => $validatedData['edit_endDate'],
                'titulo' => $validatedData['edit_titulo'],
                'tipo_evento_id' => $validatedData['choose_tipo_evento'],
            ];

            if ($request->edit_startDate > $request->edit_endDate || $request->edit_endDate < $request->edit_startDate) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'La fecha de finalización no puede ser anterior a la de inicio.'
                ]);
            }

            $update = $evento->update($eventoData);

            if ($update) {
                return back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Evento modificado correctamente.'
                ]);
            } else {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Error al modificar el evento. Por favor, inténtalo de nuevo.'
                ]);
            }
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return back()->with('alert', [
                'type' => 'danger',
                'message' => 'Error al modificar el evento. Por favor, inténtalo de nuevo.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();

        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Evento eliminado correctamente.'
        ]);
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
