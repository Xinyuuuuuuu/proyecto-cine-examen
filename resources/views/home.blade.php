@extends('layouts.app')
@section('title','Inicio')
@section('content')
    <h1>Inicio - Cine examen</h1>

    @php //sirve para meter pequeñas operaciones PHP en la vista
        $mensaje = 'Proyecto de práctica Laravel 12'
    @endphp

    <p>{{ $mensaje }}</p>
@endsection