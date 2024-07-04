@extends('adminlte::page')

@section('right-sidebar')

@section('title', 'Prueba')

@section('content_header')

@stop

@section('content')

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <div id='calendar'></div>
@stop


@vite('resources/js/calendar.js')
