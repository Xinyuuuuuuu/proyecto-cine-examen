@props([
    'titulo'=>'Cine examen'
    ])

<nav>
    <h2>{{ $titulo }}</h2>
    <a href="{{ url('/') }}">Inicio</a>
    <a href="{{ url('/movies') }}">Películas</a>
    <a href="{{ url('/directors') }}">Directores</a>
    <a href="{{ url('/actors') }}">Actores</a>
    
</nav>

<hr>