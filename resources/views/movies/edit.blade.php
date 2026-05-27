@extends('layouts.app')
@section('title', 'Editar película')
@section('content')
    <h1>Editar {{ $movie->title }}</h1>

    <x-errors/>

    <form action="{{ url('/movies/'.$movie->id.'/update') }}" method="POST">
        @csrf
    
        <div>
            <label for="title">Título: </label>
            <input type="text" name="title" id="title" value="{{ old('title', $movie->title) }}">
        </div>

        <div>
            <label for="year">Año:</label>
            <input type="number" name="year" id="year" value="{{ old('year', $movie->year) }}">
        </div>

        <div>
            <label for="director_id">Director:</label>

            <select name="director_id" id="director_id">
                <option value="">Selecciona un director</option> {{-- Devuelve un error por 'director_id' => 'required' --}}

                @foreach ($directors as $director)
                    {{-- @if lo usamos para dejar seleccionado cocretamente 
                        la opcion que lea @foreach que coincida la old con al opcion --}}
                    <option value="{{ $director->id }}" 
                        @if (old('director_id', $movie->director_id) == $director->id) selected @endif>
                        {{ $director->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <hr>

        <h2>Actores y roles </h2>

        @if ($actors->isEmpty())
            <p>No hay actores disponibles</p>
        @else
            @foreach ($actors as $actor)

                {{-- Busca si el actor del bucle actual ya está asociado a la película --}}
                @php  
                    $actorActual = $movie->actors->firstWhere('id',$actor->id);  
                @endphp

                <div>
                    <label>
                        <input type="checkbox"
                            name="actors[]" {{-- Envia un array de actores  --}}
                            value="{{ $actor->id }}"{{-- Enviale el id al array --}}
                            {{-- Comprueba si 'actors' es array y si el id del actor actual está dentro de los actores seleccionados antes  --}}
                            @if ((is_array(old('actors')) && in_array($actor->id, old('actors'))) || (!old('actors')&& $actorActual)) checked @endif>
                            {{-- @if($movie->actors->contains($actor->id)) checked @endif> --}}

                        {{ $actor->name }}
                    </label>

                    <input type="text"
                        name="roles[{{ $actor->id }}]"{{-- roles[1] --}}
                        placeholder="Rol en la película"
                        value="{{ old('roles.' . $actor->id, $actorActual ? $actorActual->pivot->role : '') }}">{{-- recupera roles[1] --}}
                </div>        
            @endforeach
        @endif
        
        <button type="submit">Actualizar</button>
    </form>
    <br>

    <a href="{{ url('/movies') }}">Volver al listado</a>
@endsection