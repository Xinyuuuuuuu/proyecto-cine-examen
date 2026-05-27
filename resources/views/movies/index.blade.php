@extends('layouts.app')
@section('title', 'Indice de películas')
@section('content')
    <h1>Indice de películas</h1>

    <x-errors />

    <a href="{{ url('/movies/create') }}">Crear película</a>

    @if ($movies->isEmpty())
        <p>No hay películas disponibles</p>
    @else
        @foreach ($movies as $movie)

            @php
                $totalActors = $movie->actors->count();
            @endphp


            <article>
                <h2>{{ $movie->title }}</h2>

                <p>Numero de actores: {{ $totalActors }}</p>

                <p>Año: {{ $movie->year }}</p>
                <p>Director: {{ $movie->director->name }}</p>

                <h3>Atores</h3>
                @if ($movie->actors->isEmpty())
                    <p>Esta película no tiene actores asociados.</p>
                @else
                    <ul>
                        @foreach ($movie->actors as $actor)
                            <li>{{ $actor->name }} interpreta a {{ $actor->pivot->role }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <a href="{{ url('/movies/'.$movie->id.'/edit') }}" >Editar película</a>
                <br>
                <form action="{{ url('/movies/' . $movie->id . '/delete') }}" method="post">
                    @csrf
                    <button type="submit" onclick="return confirm('¿Seguro que quieres borrar esta película?')">
                        Borrar película
                    </button>
                </form><br>
            </article>
        @endforeach
    @endif

    <br>

    <a href="{{ url('/movies') }}">Volver al listado</a>
@endsection