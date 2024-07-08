<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $currentUserId = auth()->id();
        $usuariosQuery = User::query()->where('id', '<>', $currentUserId);

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

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

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string',
            ]);
            $user = new User();
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->role = $request->admin ? 'Admin' : 'User';
            $user->activado = $request->activado ? 1 : 0;

            if ($user->save()) {
                return back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Usuario creado correctamente.'
                ]);
            } else {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Error al crear el usuario. Por favor, inténtalo de nuevo.'
                ]);
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            if ($errors->has('username') && $errors->has('email')) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'El nombre de usuario y el email ya está en uso. Por favor, elija otro.'
                ])->withErrors($errors)->withInput();
            }
            if ($errors->has('username')) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'El nombre de usuario ya está en uso. Por favor, elija otro.'
                ])->withErrors($errors)->withInput();
            }
            if ($errors->has('email')) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'El correo electrónico ya está en uso. Por favor, elija otro.'
                ])->withErrors($errors)->withInput();
            }

            return back()->withErrors($errors)->withInput();
        }
    }

    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'nullable|string|min:8',
                'admin' => 'nullable|string|max:255',
                'activado' => 'nullable|string|max:255',
            ]);

            $user = User::find($request->edit_id);

            if (!$user) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Usuario no encontrado.'
                ]);
            }

            $userData = [
                'username' => $validatedData['username'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                
            ];

            if (!empty($validatedData['password'])) {
                $userData['password'] = Hash::make($validatedData['password']);
            }

            if ($userData == $user->only(['username', 'name', 'email', 'role'])) {
                return back()->with('alert', [
                    'type' => 'warning',
                    'message' => 'No se realizaron cambios.'
                ]);
            }

            
            isset($validatedData['admin']) && $validatedData['admin'] ? $user->role='Admin' : $user->role='User';
            isset($validatedData['activado']) && $validatedData['activado'] ? $user->activado=1 : $user->activado=0;

            $update = $user->update($userData);

            if ($update) {
                return back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Usuario modificado correctamente.'
                ]);
            } else {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Error al modificar el usuario. Por favor, inténtalo de nuevo.'
                ]);
            }
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return back()->with('alert', [
                'type' => 'danger',
                'message' => 'Error al modificar el usuario. Por favor, inténtalo de nuevo.'
            ]);
        }
    }




    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Usuario eliminado correctamente.'
        ]);
    }

}
