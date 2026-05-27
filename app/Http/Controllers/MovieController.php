<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Director;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('actors', 'director')->get();

        return view('movies.index', compact('movies'));
    }

    public function create()
    {
        $directors = Director::all();
        $actors = Actor::all();
        return view('movies.create', compact('directors', 'actors'));
    }

    //store con PIVOT ARRAY
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:150',
            'year' => 'required|integer|min:1900|max:2100',
            'director_id' => 'required|exists:directors,id',
            'actors' => 'nullable|array', //guarda el id (Blade con: value="{{ $actor->id }}")
            'actors.*' => 'exists:actors,id', //cada elemento del array existe
            'roles' => 'nullable|array',
            
        ]);

        $movie = Movie::create([
            'title' => $request->input('title'),
            'year' => $request->input('year'),
            'director_id' => $request->input('director_id'),
        ]);

        if ($request->has('actors')) {
            foreach ($request->input('actors') as $actorId) {
                $role = $request->input('roles.' . $actorId); //(roles.1) role del actor o concretar en el array del array
                //<input type="text" name="roles[{{ $actor->id }}]"> 
                //El usuario introduce "Barbie" en el input name="roles[1]"
                //$role = 'Barbie'

                if ($role != null && $role != '') {  //attach() añade relaciones sin borrar
                    $movie->actors()->attach($actorId, ['role' => $role]);
                } else {
                    $movie->actors()->attach($actorId, ['role' => 'Sin especificar']);
                }
            }
        }
        return redirect('/movies')->with('success', 'Película creada correctamente.');
    }

    public function edit($id)
    {
        $movie = Movie::with(['director', 'actors'])->find($id);

        if (!$movie) {
            return redirect('/movies')->with('error', 'Película no encontrada.');
        }

        $directors = Director::all(); //select
        $actors = Actor::all(); //checkboxes

        return view('movies.edit', compact('movie', 'directors', 'actors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:150',
            'year' => 'required|integer|min:1900|max:2100',
            'director_id' => 'required|exists:directors,id',
            'actors' => 'nullable|array',
            'actors.*' => 'exists:actors,id',
            'roles' => 'nullable|array',
        ]);

        //-------Update de tabla Movie------//
        $movie = Movie::find($id);

        if (!$movie) {
            return redirect('/movies')->with('error', 'Película no encontrada');
        }

        $movie->update([
            'title' => $request->input('title'),
            'year' => $request->input('year'),
            'director_id' => $request->input('director_id'),
        ]);

        //-----------Update de tabla PIVOT actor_movie-----//

        $datosActores = []; //guardará el id de los actores y sus roles para esta película
        // actor_id => ['role' => valor]

        if ($request->has('actors')) {
            foreach ($request->actors as $actorId) { //$request->input('actors', []) //devuelve array vacio si no se marca ninguna ctor
                //nullable pivot attribute
                $role = $request->input('roles.' . $actorId);

                if ($role == null || $role == '') {
                    $role = 'Sin especificar';
                }

                $datosActores[$actorId] = ['role' => $role]; //[$actorId] es la clave para sync()
                // actor_id => ['campo_pivot' => valor],
            }
        }

        //sincroniza el metodo actors() del modelo Movie
        $movie->actors()->sync($datosActores); // actor_id => ['campo_pivot' => valor],
        //sync() borra las anteriores y las deja como el array que le paso


        //Si solo quiero añadir una realción nueva sin tocar las demás
        //$movie->actors()->attach($actorId, ['role' => 'Cooper']);


        return redirect('/movies')->with('success', 'Película actualizada correctamente.');
    }

    public function search(Request $request)
    {
        // Recogemos filtros del formulario
        $texto = $request->input('texto', '');
        $directorId = $request->input('director_id', '');
        $actorIds = $request->input('actors', []);
        $role = $request->input('role', '');
        $years = $request->input('years', []);

        // Datos para rellenar selects y checkboxes
        $directors = Director::all();
        $actors = Actor::all();

        // Query base con relaciones cargadas de Movie
        $query = Movie::with(['director', 'actors']);

        // Filtro por texto en título
        if ($texto != '') {
            $query->where('title', 'like', '%' . $texto . '%');
        }

        // Filtro 1:N por director
        if ($directorId != '') {
            $query->where('director_id', '=', $directorId);
        }

        // Filtro por array de años
        if (!empty($years)) {
            $query->whereIn('year', $years);
        }

        // Filtro N:M por actores seleccionados
        if (!empty($actorIds)) {
            $query->whereHas('actors', function ($q) use ($actorIds) {
                $q->whereIn('actors.id', $actorIds);
            });
        }

        // Filtro por atributo pivot role
        if ($role != '') {
            $query->whereHas('actors', function ($q) use ($role) {
                $q->where('actor_movie.role', 'like', '%' . $role . '%');
            });
        }

        // Ejecutar consulta
        $movies = $query->get();

        // Total
        $totalMovies = $movies->count();

        // Array de años disponibles generado desde la BD
        $availableYears = Movie::select('year')
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->toArray();

        return view('movies.search', compact(
            'movies',
            'totalMovies',
            'directors',
            'actors',
            'availableYears',
            'texto',
            'directorId',
            'actorIds',
            'role',
            'years'
        ));
    }

    //delete

    public function delete ($id){
        $movie=Movie::find($id);

        if (!$movie) {
            return redirect('/movies')->with('error', 'No existe esta Película');;
        }
        
        $movie->delete();

        return redirect ('/movies')->with('success','"'.$movie->title. '" ha sido borrada ');
    }
}
