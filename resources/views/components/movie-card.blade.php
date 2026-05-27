@props([
    'movie'
])

<article>
    <h2>{{ $movie->title }}</h2>

    <p>Año: {{ $movie->year }}</p>
    <p>Director: {{ $movie->director->name }}</p>

    <h3>Actores</h3>

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

    <a href="{{ url('/movies/' . $movie->id . '/edit') }}">Editar</a>
</article>

