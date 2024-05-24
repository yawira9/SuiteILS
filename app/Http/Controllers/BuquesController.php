<?php

namespace App\Http\Controllers;

use App\Models\Buque;
use App\Models\SistemasEquipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class BuquesController extends Controller {
    public function create() {
        $sistemas_equipos_100 = SistemasEquipos::where('mfun', 'like', '1%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_200 = SistemasEquipos::where('mfun', 'like', '2%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_300 = SistemasEquipos::where('mfun', 'like', '3%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_400 = SistemasEquipos::where('mfun', 'like', '4%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_500 = SistemasEquipos::where('mfun', 'like', '5%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_600 = SistemasEquipos::where('mfun', 'like', '6%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_700 = SistemasEquipos::where('mfun', 'like', '7%')->whereRaw('LENGTH(mfun) = 5')->get();

        return view('buques.create', compact('sistemas_equipos_100', 'sistemas_equipos_200', 'sistemas_equipos_300', 'sistemas_equipos_400', 'sistemas_equipos_500', 'sistemas_equipos_600', 'sistemas_equipos_700'));
    }

    public function index(Request $request) {
        $query = Buque::where('user_id', Auth::id());

        if ($request->has('search')) {
            $query->where('nombre_proyecto', 'LIKE', '%' . $request->input('search') . '%');
        }

        // Paginación: obteniendo 8 resultados por página
        $buques = $query->paginate(8);

        // Obtener la fecha actual en formato DD/MM/YY
        $currentDate = Carbon::now()->format('d/m/y');

        return view('buques.index', compact('buques', 'currentDate'));
    }

    public function store(Request $request) {
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'tipo_buque' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|max:500',
            'autonomia_horas' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'sistemas_equipos' => 'array'
        ]);
    
        // Almacenar la imagen subida y obtener su ruta
        $imagePath = $request->file('image') ? $request->file('image')->store('buques', 'public') : null;
    
        $buque = Buque::create([
            'user_id' => Auth::id(),
            'nombre_proyecto' => $request->nombre_proyecto,
            'tipo_buque' => $request->tipo_buque,
            'descripcion_proyecto' => $request->descripcion_proyecto,
            'autonomia_horas' => $request->autonomia_horas,
            'image_path' => $imagePath,
        ]);
    
        if ($request->has('sistemas_equipos')) {
            $buque->sistemasEquipos()->attach($request->sistemas_equipos);
        }
    
        return redirect()->route('dashboard')->with('success', 'Buque creado exitosamente.');
    }
    
    public function edit(Buque $buque) {
        $sistemas_equipos_100 = SistemasEquipos::where('mfun', 'like', '1%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_200 = SistemasEquipos::where('mfun', 'like', '2%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_300 = SistemasEquipos::where('mfun', 'like', '3%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_400 = SistemasEquipos::where('mfun', 'like', '4%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_500 = SistemasEquipos::where('mfun', 'like', '5%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_600 = SistemasEquipos::where('mfun', 'like', '6%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_700 = SistemasEquipos::where('mfun', 'like', '7%')->whereRaw('LENGTH(mfun) = 5')->get();

        return view('buques.edit', compact('buque', 'sistemas_equipos_100', 'sistemas_equipos_200', 'sistemas_equipos_300', 'sistemas_equipos_400', 'sistemas_equipos_500', 'sistemas_equipos_600', 'sistemas_equipos_700'));
    }

    public function update(Request $request, Buque $buque) {
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'tipo_buque' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|max:500',
            'autonomia_horas' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'sistemas_equipos' => 'array' // Validar que sea un array
        ]);

        // Almacenar la imagen subida y obtener su ruta
        if ($request->file('image')) {
            if ($buque->image_path) {
                Storage::disk('public')->delete($buque->image_path);
            }
            $buque->image_path = $request->file('image')->store('buques', 'public');
        }

        $buque->update([
            'nombre_proyecto' => $request->nombre_proyecto,
            'tipo_buque' => $request->tipo_buque,
            'descripcion_proyecto' => $request->descripcion_proyecto,
            'autonomia_horas' => $request->autonomia_horas,
            'image_path' => $buque->image_path,
        ]);

        // Asociar los sistemas y equipos seleccionados
        if ($request->has('sistemas_equipos')) {
            $buque->sistemasEquipos()->sync($request->input('sistemas_equipos'));
        }

        return redirect()->route('dashboard')->with('success', 'Buque actualizado exitosamente.');
    }

    public function destroy(Buque $buque) {
        if ($buque->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para eliminar este buque.');
        }

        if ($buque->image_path) {
            Storage::disk('public')->delete($buque->image_path);
        }

        $buque->delete();

        return redirect()->route('dashboard')->with('success', 'Buque eliminado exitosamente.');
    }
    
    public function getSistemasEquipos(Buque $buque)
    {
        $sistemasEquipos = $buque->sistemasEquipos;
        return response()->json($sistemasEquipos);
    }

    // Método para mostrar los detalles del buque
    public function show(Buque $buque)
    {
        return view('buques.show', compact('buque'));
    }

    public function showGres(Buque $buque) {
        $sistemasEquipos = $buque->sistemasEquipos;
        return view('buques.gres', compact('buque', 'sistemasEquipos'));
    }

    public function showFua(Buque $buque){
        return view('buques.fua', compact('buque'));
    }

    public function updateMEC(Request $request, Buque $buque, $equipoId)
    {
        $buque->sistemasEquipos()->updateExistingPivot($equipoId, ['mec' => $request->input('mec')]);

        return response()->json(['message' => 'MEC actualizado correctamente']);
    }
}
