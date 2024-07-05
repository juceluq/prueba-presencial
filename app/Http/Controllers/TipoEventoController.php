<?php

namespace App\Http\Controllers;

use App\Models\TipoEvento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TipoEventoController extends Controller
{
    public function index(Request $request)
    {
        $eventoQuery = TipoEvento::query();

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $eventos = $eventoQuery->orderBy($sort, $direction)->paginate(10);
        return view('tipo_eventos', compact('eventos', 'sort', 'direction'));
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $eventos = TipoEvento::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate(10);

        return view('tipo_eventos', compact('eventos', 'sort', 'direction', 'search'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'fondo' => 'required|string|max:255',
                'borde' => 'required|string|max:255',
                'texto' => 'required|string|max:255',
            ]);

            $evento = new TipoEvento();
            $evento->nombre = $validatedData['nombre'];
            $evento->fondo = $validatedData['fondo'];
            $evento->borde = $validatedData['borde'];
            $evento->texto = $validatedData['texto'];

            if ($evento->save()) {
                return back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Evento creado correctamente.'
                ]);
            } else {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Error al crear el evento. Por favor, inténtalo de nuevo.'
                ]);
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            return back()->with('alert', [
                'type' => 'danger',
                'message' => 'Hubo errores en la validación. Por favor, revisa los campos e inténtalo de nuevo.'
            ])->withErrors($errors)->withInput();
        }
    }

    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'fondo' => 'required|string|max:255',
                'borde' => 'required|string|max:255',
                'texto' => 'required|string|max:255',
            ]);

            $evento = TipoEvento::find($request->edit_id);

            if (!$evento) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Evento no encontrado.'
                ]);
            }

            $eventoData = [
                'nombre' => $validatedData['nombre'],
                'fondo' => $validatedData['fondo'],
                'borde' => $validatedData['borde'],
                'texto' => $validatedData['texto'],
            ];

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

    public function destroy($id)
    {
        $evento = TipoEvento::findOrFail($id);
        $evento->delete();

        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Evento eliminado correctamente.'
        ]);
    }
}
