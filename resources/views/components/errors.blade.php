@props(['title' => 'Errores de validación'])

{{-- Errores de validación de create --}}
@if ($errors->any())

    <strong>{{ $title }}</strong>

    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
{{-- Errores con with() --}}
@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if (session('error'))
    <p>{{ session('error') }}</p>
@endif