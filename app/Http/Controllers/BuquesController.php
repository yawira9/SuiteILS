<?php

namespace App\Http\Controllers;

use App\Models\Buque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BuquesController extends Controller {
    public function index(Request $request) {
        $query = Buque::where('user_id', Auth::id());

        if ($request->has('search')) {
            $query->where('nombre_proyecto', 'LIKE', '%' . $request->input('search') . '%');
        }

        // Paginación: obteniendo 10 resultados por página
        $buques = $query->paginate(8);

        return view('buques.index', compact('buques'));
    }

    public function create() {
        return view('buques.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'tipo_buque' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|max:500',
            'autonomia_horas' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        // Store the uploaded image and get its path
        $imagePath = $request->file('image') ? $request->file('image')->store('buques', 'public') : null;

        Buque::create([
            'user_id' => Auth::id(),
            'nombre_proyecto' => $request->nombre_proyecto,
            'tipo_buque' => $request->tipo_buque,
            'descripcion_proyecto' => $request->descripcion_proyecto,
            'autonomia_horas' => $request->autonomia_horas,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Buque creado exitosamente.');
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
}
