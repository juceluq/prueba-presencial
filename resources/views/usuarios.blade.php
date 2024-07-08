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
                <span style="margin-left: 10px;">Listado de Usuarios</span>
            </h2>
        </div>


    </div>

    <!-- Formulario de búsqueda -->
    <div class="row mb-3">
        <div class="col-md-10">
            <form id="search-form" name="search-form" action="{{ route('usuarios.search') }}" method="GET" class="d-flex">
                @csrf
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, usuario, email..."
                    value="{{ request()->input('search') }}">
                <button type="submit" class="btn btn-primary ml-2">Buscar</button>
                <a id="limpiar" type="button" class="btn btn-secondary ml-2" href="{{ route('usuarios') }}">Limpiar</a>
            </form>
        </div>
        <a href="#modalAddUser" class="btn btn-outline-success d-flex align-items-center justify-content-center"
            style="width: 36px; height: 36px; padding: 0; margin-right: 1rem;" data-toggle="modal">
            <i class='bx bx-plus-medical' style="font-size: 1.5rem;"></i>
        </a>

    </div>



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
                <th class="text-center sortable">
                    <a
                        href="{{ request()->fullUrlWithQuery(['sort' => 'activado', 'direction' => $sort == 'activado' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                        Activado
                        @if ($sort == 'activado')
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
                    <td style="display:none" class="role">{{$user->role}}</td>
                    <td class="text-center activado">
                        @if ($user->activado == true)
                            <i class='bx bx-check' style="font-size: 1.75rem;"></i>
                        @else
                            <i class='bx bx-x' style="font-size: 1.75rem;"></i>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <button class="edit-btn btn btn-primary d-flex align-items-center justify-content-center"
                                style="width: 36px; height: 36px; margin-right: 0.5rem;" data-id="{{ $user->id }}"
                                data-toggle="modal" data-target="#modalEditUser">
                                <i class='bx bx-edit'></i>
                            </button>

                            <button type="button" onclick="confirmDelete(this)"
                                data-form-id="delete-user-form-{{ $user->id }}"
                                class="delete-btn btn btn-danger d-flex align-items-center justify-content-center user-delete-btn"
                                style="width: 36px; height: 36px; padding: 0 6px; margin-left: 5px;">
                                <i class='bx bx-minus'></i>
                            </button>
                        </div>
                        <form id="delete-user-form-{{ $user->id }}" method="POST"
                            action="{{ route('usuarios.destroy', $user->id) }}" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
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



    <!-- Modal para añadir usuario -->
    <div id="modalAddUser" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Añadir Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" type="text" class="form-control" value="{{ old('username') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Nombre completo</label>
                            <input name="name" type="text" class="form-control" value="{{ old('name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>
                        <div class="form-check">
                            <input name="activado" type="checkbox" class="form-check-input" id="flexCheckActivado"
                                {{ old('activado') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheckActivado">Activado</label>
                        </div>
                        <div class="form-check">
                            <input name="admin" type="checkbox" class="form-check-input" id="flexCheck"
                                {{ old('admin') ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexCheck">Administrador</label>
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

    <!-- Modal para editar usuario -->
    <div id="modalEditUser" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('usuarios.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" id="edit_username" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="name" id="edit_nombre" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" id="edit_email" type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input name="password" id="edit_password" type="password" class="form-control">
                            <small>Si no desea cambiarlo, dejalo en blanco.</small>
                        </div>
                        <div class="form-check">
                            <input name="activado" type="checkbox" class="form-check-input" id="edit_activado">
                            <label class="form-check-label" for="edit_activado">Activado</label>
                        </div>
                        <div class="form-check">
                            <input name="admin" type="checkbox" class="form-check-input" id="edit_admin">
                            <label class="form-check-label" for="edit_admin">Administrador</label>
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

    @section('footer')
        <p>Tiempo restante de sesión: </p>
        <span class="text-center">©2022 Soluciones Informáticas MJ S.C.A</span>
    @stop
@stop
@vite('resources/js/usuarios.js')
