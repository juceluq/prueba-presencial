@extends('adminlte::page')

@section('right-sidebar')

@section('title', 'Prueba')

@section('content_header')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stop

@section('content')


    <div id='calendar'></div>

    <!-- Modal para añadir evento -->
    <div id="modalAddEvent" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('eventos.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h4 class="modal-title">Añadir Evento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add_startDate">Fecha / Hora de inicio</label>
                                    <input id="add_startDate" name="add_startDate" class="form-control"
                                        type="datetime-local" />
                                    <span id="startDateSelected"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="add_endDate">Fecha / Hora de fin</label>
                                    <input id="add_endDate" name="add_endDate" class="form-control" type="datetime-local" />
                                    <span id="endDateSelected"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="add_titulo">Título</label>
                            <input name="add_titulo" id="add_titulo" type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="choose_tipo_evento">Tipo de evento</label>
                            <select name="choose_tipo_evento" id="choose_tipo_evento" class="form-select" required>
                                @foreach ($tipoEventos as $tipoEvento)
                                    <option value="{{ $tipoEvento->id }}">
                                        {{ $tipoEvento->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Añadir</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>


    <!-- Modal para editar evento -->
    <div id="modalEditEvent" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('eventos.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_id" id="edit_id">
                    <input type="hidden" name="edit_tipo_id" id="edit_tipo_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Evento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_startDate">Fecha / Hora de inicio</label>
                                    <input id="edit_startDate" name="edit_startDate" class="form-control"
                                        type="datetime-local" />
                                    <span id="startDateSelected"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_endDate">Fecha / Hora de fin</label>
                                    <input id="edit_endDate" name="edit_endDate" class="form-control"
                                        type="datetime-local" />
                                    <span id="endDateSelected"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_titulo">Título</label>
                            <input name="edit_titulo" id="edit_titulo" type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="choose_tipo_evento">Tipo de evento</label>
                            <select name="choose_tipo_evento" id="choose_tipo_evento" class="form-select" required>
                                @foreach ($tipoEventos as $tipoEvento)
                                    <option value="{{ $tipoEvento->id }}">
                                        {{ $tipoEvento->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </form>

                @if (Auth::user()->role === 'Admin')
                    <form id="delete-form" method="POST" action="{{ route('eventos.destroy', 'reemplazar') }}">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="delete_id" id="delete_id">
                        <button type="submit" class="delete-btn btn btn-danger event-delete-btn">
                            Borrar
                        </button>
                    </form>
                @endif
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
    </div>
    </div>



@stop


@section('footer')
    <p>Tiempo restante de sesión: </p>
    <span class="text-center">©2022 Soluciones Informáticas MJ S.C.A</span>
@stop




@vite('resources/js/calendar.js', 'resources/js/app.js')
