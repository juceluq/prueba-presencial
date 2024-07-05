@extends('adminlte::page')

@section('right-sidebar')

@section('title', 'Prueba')

@section('content_header')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stop


@section('content')

    @if (session('alert'))
        <div class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show position-fixed top-50 start-50 translate-middle"
            role="alert" style="opacity: 0.9; z-index: 1050; max-width: 400px;">
            {{ session('alert')['message'] }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);
        </script>
    @endif

    <div class="row mb-3">
        <div class="col-sm-6 d-flex align-items-center">
            <h2 class="d-flex align-items-center">
                <span style="margin-left: 10px;">Listado de Tipo de Eventos</span>
            </h2>
        </div>


    </div>

    <!-- Formulario de búsqueda -->
    <div class="row mb-3">
        <div class="col-md-10">
            <form id="search-form" name="search-form" action="{{ route('eventos.search') }}" method="GET" class="d-flex">
                @csrf
                <input type="text" name="search" class="form-control" placeholder="Buscar..."
                    value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary ml-2">Buscar</button>
                <a id="limpiar" type="button" class="btn btn-secondary ml-2" href="{{ route('eventos') }}">Limpiar</a>
            </form>
        </div>
        <a href="#modalAddEvent" class="btn btn-outline-success d-flex align-items-center justify-content-center"
            style="width: 36px; height: 36px; padding: 0; margin-right: 1rem;" data-toggle="modal">
            <i class='bx bx-plus-medical' style="font-size: 1.5rem;"></i>
        </a>

    </div>



    <table id="tabla-eventos" class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center sortable">
                    <a
                        href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sort == 'id' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        ID
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
                        href="{{ request()->fullUrlWithQuery(['sort' => 'nombre', 'direction' => $sort == 'nombre' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Nombre
                        @if ($sort == 'nombre')
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
                        href="{{ request()->fullUrlWithQuery(['sort' => 'fondo', 'direction' => $sort == 'fondo' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Fondo
                        @if ($sort == 'fondo')
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
                        href="{{ request()->fullUrlWithQuery(['sort' => 'borde', 'direction' => $sort == 'borde' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Borde
                        @if ($sort == 'borde')
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
                        href="{{ request()->fullUrlWithQuery(['sort' => 'texto', 'direction' => $sort == 'texto' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Texto
                        @if ($sort == 'texto')
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
            @forelse ($eventos as $evento)
                <tr>
                    <td class="text-center codigo">{{ $evento->id }}</td>
                    <td class="text-center nombre">{{ $evento->nombre }}</td>
                    <td class=" text-center fondo">
                        <span class="color-box mr-2" style="background-color: {{ $evento->fondo }}"></span>
                        {{ $evento->fondo }}

                    </td>
                    <td class=" text-center borde">

                        <span class="color-box mr-2" style="background-color: {{ $evento->borde }}"></span>
                        {{ $evento->borde }}

                    </td>
                    <td class=" text-center texto">

                        <span class="color-box mr-2" style="background-color: {{ $evento->texto }}"></span>
                        {{ $evento->texto }}

                    </td>


                    <td>
                        <div class="d-flex justify-content-center">
                            <button class="edit-btn btn btn-primary d-flex align-items-center justify-content-center"
                                style="width: 36px; height: 36px; margin-right: 0.5rem;" data-id="{{ $evento->id }}"
                                data-toggle="modal" data-target="#modalEditEvento">
                                <i class='bx bx-edit'></i>
                            </button>

                            <button type="button" onclick="confirmDelete(this)"
                                data-form-id="delete-user-form-{{ $evento->id }}"
                                class="delete-btn btn btn-danger d-flex align-items-center justify-content-center user-delete-btn"
                                style="width: 36px; height: 36px; padding: 0 6px; margin-left: 5px;">
                                <i class='bx bx-minus'></i>
                            </button>
                        </div>
                        <form id="delete-user-form-{{ $evento->id }}" method="POST"
                            action="{{ route('eventos.destroy', $evento->id) }}" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay eventos para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $eventos->withQueryString()->links('pagination::bootstrap-5') }}



    <!-- Modal para añadir evento -->
    <div id="modalAddEvent" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('eventos.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Añadir Evento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="nombre" type="text" class="form-control" value="{{ old('nombre') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Fondo</label>
                            <input name="fondo" type="color" class="form-control form-control-color" value="{{ old('fondo') }}" id="add_fondo"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Borde</label>
                            <input name="borde" type="color" class="form-control form-control-color" value="{{ old('borde') }}" id="add_borde"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Texto</label>
                            <input name="texto" type="color" class="form-control form-control-color" id="add_texto" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Añadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar eventos -->
    <div id="modalEditEvento" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('eventos.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Evento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="nombre" id="edit_nombre" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Fondo</label>
                            <input name="fondo" id="edit_fondo" type="color" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Borde</label>
                            <input name="borde" id="edit_borde" type="color" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Texto</label>
                            <input name="texto" id="edit_texto" type="color" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @section('js')
        <script>
            function confirmDelete(button) {
                const formId = button.getAttribute('data-form-id');
                const form = document.getElementById(formId);
                const swalOptions = {
                    title: 'Estás seguro?',
                    text: "No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, eliminarlo!',
                    cancelButtonText: 'Cancelar',
                };

                Swal.fire(swalOptions).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    @stop

    @section('css')
        <style>
            .color-box {
                display: inline-block;
                width: 15px;
                height: 15px;
                margin-right: 10px;
                border: 1px solid #ccc;
                vertical-align: middle;
            }
        </style>
    @stop



    @section('footer')
        <p>Tiempo restante de sesión: </p>
        <span class="text-center">©2022 Soluciones Informáticas MJ S.C.A</span>
    @stop
@stop
@vite('resources/js/eventos.js')
