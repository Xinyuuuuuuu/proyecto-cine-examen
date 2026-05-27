@extends('layouts.app')

@section('title', 'Buscador avanzado de películas')

@section('content')
    <h1>Buscador avanzado de películas</h1>

    <form action="{{ url('/movies/search') }}" method="GET">
        <div>
            <label for="texto">Título:</label>
            <input type="text" name="texto" id="texto" value="{{ $texto }}" placeholder="Buscar por título">
        </div>

        <div>
            <label for="director_id">Director:</label>

            <select name="director_id" id="director_id">
                <option value="">Todos los directores</option>

                @foreach ($directors as $director)
                    <option value="{{ $director->id }}" @if ($directorId == $director->id) selected @endif>
                        {{ $director->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <p>Actores:</p>

            @if ($actors->isEmpty())
                <p>No hay actores disponibles.</p>
            @else
                @foreach ($actors as $actor)
                    <label>
                        <input type="checkbox" name="actors[]" value="{{ $actor->id }}" @if (in_array($actor->id, $actorIds))
                        checked @endif>

                        {{ $actor->name }}
                    </label>
                    <br>
                @endforeach
            @endif
        </div>

        <div>
            <label for="role">Rol en la película:</label>
            <input type="text" name="role" id="role" value="{{ $role }}" placeholder="Ej: Cooper, Ken...">
        </div>

        <div>
            <p>Años:</p>

            @if (empty($availableYears))
                <p>No hay años disponibles.</p>
            @else
                @foreach ($availableYears as $year)
                    <label>
                        <input type="checkbox" name="years[]" value="{{ $year }}" @if (in_array($year, $years)) checked @endif>

                        {{ $year }}
                    </label>
                    <br>
                @endforeach
            @endif
        </div>

        <button type="submit">Buscar</button>
    </form>

    <hr>

    @php
        $hayFiltros = $texto != '' || $directorId != '' || !empty($actorIds) || $role != '' || !empty($years);
    @endphp

    @if ($hayFiltros)
        <p>Mostrando resultados filtrados.</p>
    @else
        <p>Mostrando todas las películas.</p>
    @endif

    <p>Total de resultados: {{ $totalMovies }}</p>

    @if ($movies->isEmpty())
        <p>No se han encontrado películas con esos criterios.</p>
    @else
        @foreach ($movies as $movie)
            <article>
                <h2>{{ $movie->title }}</h2>

                <p>Año: {{ $movie->year }}</p>
                <p>Director: {{ $movie->director->name }}</p>

                <h3>Reparto</h3>

                @if ($movie->actors->isEmpty())
                    <p>Esta película no tiene actores asociados.</p>
                @else
                    <ul>
                        @foreach ($movie->actors as $actor)
                            <li>
                                {{ $actor->name }}
                                interpreta a
                                <strong>{{ $actor->pivot->role }}</strong>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <a href="{{ url('/movies/' . $movie->id . '/edit') }}">Editar película</a>
            </article>

            <hr>

            {{-- <x-movie-card :movie="$movie" />
            <hr> --}}
        @endforeach
    @endif

    <a href="{{ url('/movies') }}">Volver al listado</a>
@endsection