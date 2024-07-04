@extends('adminlte::page')

@section('right-sidebar')

@section('title', 'Prueba')

@section('content_header')


@stop

@section('content')
    <div id='calendar'></div>
@stop

@section('footer')
        <p>Tiempo restante de sesión: </p>
        <span class="text-center">©2022 Soluciones Informáticas MJ S.C.A</span>
    @stop

@vite('resources/js/calendar.js', 'resources/js/app.js')
