@extends('adminlte::page')

@section('right-sidebar')

@section('title', 'Prueba')

@section('content_header')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

@stop

@section('content')

    <!-- Formulario de búsqueda -->
    <form id="search-form" name="search-form" action="{{ route('usuarios.search') }}" method="GET" class="mb-3">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control"
                    placeholder="Buscar por nombre, usuario, email..." value="{{ request()->input('search') }}">
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a id="limpiar" type="button" class="btn btn-secondary ml-2" href="{{ route('usuarios') }}">Limpiar</a>
            </div>
        </div>
    </form>


    <table id="tabla-usuarios" class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center sortable">
                    <a
                        href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sort == 'id' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Código
                        @if ($sort == 'id')
                            <span class="sort-icon">
                                @if ($direction == 'asc')
                                    <i class='bx bx-chevron-up'></i>
                                @else
                                    <i class='bx bx-chevron-down'></i>
                                @endif
                            </span>
                        @endif
                    </a>
                </th>
                <th class="text-center sortable">
                    <a
                        href="{{ request()->fullUrlWithQuery(['sort' => 'username', 'direction' => $sort == 'username' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Login
                        @if ($sort == 'username')
                            <span class="sort-icon">
                                @if ($direction == 'asc')
                                    <i class='bx bx-chevron-up'></i>
                                @else
                                    <i class='bx bx-chevron-down'></i>
                                @endif
                            </span>
                        @endif
                    </a>
                </th>
                <th class="text-center sortable">
                    <a
                        href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => $sort == 'name' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Nombre
                        @if ($sort == 'name')
                            <span class="sort-icon">
                                @if ($direction == 'asc')
                                    <i class='bx bx-chevron-up'></i>
                                @else
                                    <i class='bx bx-chevron-down'></i>
                                @endif
                            </span>
                        @endif
                    </a>
                </th>
                <th class="text-center sortable">
                    <a
                        href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => $sort == 'email' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Email
                        @if ($sort == 'email')
                            <span class="sort-icon">
                                @if ($direction == 'asc')
                                    <i class='bx bx-chevron-up'></i>
                                @else
                                    <i class='bx bx-chevron-down'></i>
                                @endif
                            </span>
                        @endif
                    </a>
                </th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $user)
                <tr>
                    <td class="text-center codigo">{{ $user->id }}</td>
                    <td class="text-center login">{{ $user->username }}</td>
                    <td class="text-center nombre">{{ $user->name }}</td>
                    <td class="text-center email">{{ $user->email }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <button class="edit-btn btn btn-primary d-flex align-items-center justify-content-center"
                                style="width: 36px; height: 36px; margin-right: 0.5rem;" data-id="{{ $user->id }}"
                                data-toggle="modal" data-target="#modalEditUser">
                                <i class='bx bx-edit'></i>
                            </button>

                            <button type="button" value="{{ $user->id }}" data-toggle="modal"
                                data-target="#modalDeleteUser"
                                class="delete-btn btn btn-danger d-flex align-items-center justify-content-center user-delete-btn"
                                style="width: 36px; height: 36px; padding: 0 6px; margin-left: 5px;">
                                <i class='bx bx-minus'></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay usuarios para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $usuarios->withQueryString()->links('pagination::bootstrap-5') }}


@stop
