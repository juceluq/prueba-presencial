@extends('adminlte::page')

@section('right-sidebar')

@section('title', 'Prueba')

@section('content_header')

@stop

@section('content')
    <div id='calendar'></div>

    <!-- Modal para editar evento -->
    <div id="modalEditEvent" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('eventos.update') }}" method="POST">
                    @csrf
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
                                    <label for="startDate">Start</label>
                                    <input id="startDate" class="form-control" type="date" />
                                    <span id="startDateSelected"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="endDate">End</label>
                                    <input id="endDate" class="form-control" type="date" />
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    


@stop

@section('footer')
    <p>Tiempo restante de sesión: </p>
    <span class="text-center">©2022 Soluciones Informáticas MJ S.C.A</span>
@stop




@vite('resources/js/calendar.js', 'resources/js/app.js')
