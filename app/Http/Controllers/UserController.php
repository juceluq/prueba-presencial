<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $usuariosQuery = User::query();


        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        // Aplicar ordenamiento
        $usuarios = $usuariosQuery->orderBy($sort, $direction)->paginate(10);

        return view('usuarios', compact('usuarios', 'sort', 'direction'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $usuarios = User::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate(10);

        return view('usuarios', compact('usuarios', 'sort', 'direction', 'search'));
    }
}
