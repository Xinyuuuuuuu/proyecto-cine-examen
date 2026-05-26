@extends('layouts.app')
@section('title', 'Crear películas')
@section('content')
    <h1>Crear película</h1>

    <x-errors title="Errores al crear película" />

    <form action="{{ url('/movies') }}" method="POST">
        @csrf

        <div>
            <label for="title">Título: </label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
        </div>

        <div>
            <label for="year">Año:</label>
            <input type="number" name="year" id="year" value="{{ old('year') }}">
        </div>

        <div>
            <label for="director_id">Director:</label>

            <select name="director_id" id="director_id">
                <option value="">Selecciona un director</option> {{-- Devuelve un error por 'director_id' => 'required' --}}

                @foreach ($directors as $director)
                    {{-- @if lo usamos para dejar seleccionado cocreatmente la opcion que coincida la old con al opcion --}}
                    <option value="{{ $director->id }}" 
                        @if (old('director_id') == $director->id) selected @endif>
                        {{ $director->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <hr>
{{--  --}}
        <h2>Actores y roles </h2>

        @if ($actors->isEmpty())
            <p>No hay actores disponibles</p>
        @else
        @foreach ($actors as $actor)
        <div>
            <label>
                <input type="checkbox"
                       name="actors[]" {{-- Envia un array de actores  --}}
                       value="{{ $actor->id }}"{{-- Enviale el id al array --}}
                       {{-- Comprueba si 'actors' es array y si el id del actor actual está dentro de los actores seleccionados antes  --}}
                       @if (is_array(old('actors')) && in_array($actor->id, old('actors'))) checked @endif>

                {{ $actor->name }}
            </label>

            <input type="text"
                   name="roles[{{ $actor->id }}]"{{-- roles[1] --}}
                   placeholder="Rol en la película"
                   value="{{ old('roles.' . $actor->id) }}">{{-- recupera roles[1] --}}
        </div>
    @endforeach
@endif

<button type="submit">Guardar película</button>
    </form>
@endsection