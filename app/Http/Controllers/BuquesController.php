<?php

namespace App\Http\Controllers;

use App\Models\Buque;
use App\Models\SistemasEquipos;
use App\Models\Colaborador;
use App\Models\Mision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class BuquesController extends Controller
{
    public function index(Request $request) {
        $query = Buque::where('user_id', Auth::id());

        if ($request->has('search')) {
            $query->where('nombre_proyecto', 'LIKE', '%' . $request->input('search') . '%');
        }

        $buques = $query->paginate(8);
        $currentDate = Carbon::now()->format('d/m/y');

        return view('buques.index', compact('buques', 'currentDate'));
    }

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

    public function store(Request $request)
    {
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'tipo_buque' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|max:500',
            'autonomia_horas' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('buques', 'public');
        }

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

        if ($request->has('colaboradores')) {
            foreach ($request->colaboradores as $colaborador) {
                $buque->colaboradores()->create($colaborador);
            }
        }

        if ($request->has('misiones')) {
            foreach ($request->misiones as $key => $value) {
                if ($value) {
                    Mision::create([
                        'buque_id' => $buque->id,
                        'mision' => $key,
                    ]);
                }
            }
        }

        return redirect()->route('buques.edit', $buque->id)->with('success', 'Buque creado exitosamente.');
    }

    public function edit(Buque $buque)
    {
        $buque->load('colaboradores', 'misiones');

        $sistemas_equipos_100 = SistemasEquipos::where('mfun', 'like', '1%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_200 = SistemasEquipos::where('mfun', 'like', '2%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_300 = SistemasEquipos::where('mfun', 'like', '3%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_400 = SistemasEquipos::where('mfun', 'like', '4%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_500 = SistemasEquipos::where('mfun', 'like', '5%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_600 = SistemasEquipos::where('mfun', 'like', '6%')->whereRaw('LENGTH(mfun) = 5')->get();
        $sistemas_equipos_700 = SistemasEquipos::where('mfun', 'like', '7%')->whereRaw('LENGTH(mfun) = 5')->get();

        $equipos_seleccionados = $buque->sistemasEquipos->pluck('id')->toArray();
        $misiones_activas = $buque->misiones->pluck('mision')->toArray();

        return view('buques.edit', compact('buque', 'sistemas_equipos_100', 'sistemas_equipos_200', 'sistemas_equipos_300', 'sistemas_equipos_400', 'sistemas_equipos_500', 'sistemas_equipos_600', 'sistemas_equipos_700', 'equipos_seleccionados', 'misiones_activas'));
    }

    public function update(Request $request, Buque $buque)
    {
        $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'tipo_buque' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|max:500',
            'autonomia_horas' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'sistemas_equipos' => 'array',
            'colaboradores' => 'array',
            'colaboradores.*.col_cargo' => 'required|string|max:255',
            'colaboradores.*.col_nombre' => 'required|string|max:255',
            'colaboradores.*.col_entidad' => 'required|string|max:255',
        ]);

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

        if ($request->has('sistemas_equipos')) {
            $buque->sistemasEquipos()->sync($request->input('sistemas_equipos'));
        }

        if ($request->has('colaboradores')) {
            $buque->colaboradores()->delete();
            foreach ($request->colaboradores as $colaborador) {
                $buque->colaboradores()->create($colaborador);
            }
        }

        // Actualizar misiones
        $misiones = $request->input('misiones', []);
        $buque->misiones()->delete();

        foreach ($misiones as $key => $value) {
            if ($value) {
                Mision::updateOrCreate([
                    'buque_id' => $buque->id,
                    'mision' => $key,
                ], [
                    'mision' => $key,
                ]);
            } else {
                Mision::where('buque_id', $buque->id)
                    ->where('mision', $key)
                    ->delete();
            }
        }

        return redirect()->route('buques.edit', $buque->id)->with('success', 'Buque actualizado exitosamente.');
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

    public function getSistemasEquipos(Buque $buque)  {
        $sistemasEquipos = $buque->sistemasEquipos;
        return response()->json($sistemasEquipos);
    }

    public function show(Buque $buque) {
        return view('buques.show', compact('buque'));
    }

    public function showGres(Buque $buque) {
        $sistemasEquipos = $buque->sistemasEquipos()->withPivot('mec', 'image', 'titulo', 'diagrama_id')->get();
        return view('buques.gres', compact('buque', 'sistemasEquipos'));
    }

    public function showFua(Buque $buque) {
        $sistemasEquipos = $buque->sistemasEquipos;
        return view('buques.fua', compact('buque', 'sistemasEquipos'));
    }

    public function updateMec(Request $request, Buque $buque, $equipoId) {
        $mec = $request->input('mec');
        $image = $request->input('image');
        $diagramaId = $request->input('diagrama_id'); // Asumiendo que se envía el ID del diagrama

        // Actualizar solo el equipo específico
        $buque->sistemasEquipos()->updateExistingPivot($equipoId, [
            'mec' => $mec,
            'image' => $image,
            'diagrama_id' => $diagramaId
        ]);

        return response()->json(['message' => 'MEC actualizado correctamente']);
    }

    public function updateEquipoTitulo(Request $request, Buque $buque, $equipoId) {
        $request->validate(['titulo' => 'required|string|max:255']);

        $buque->sistemasEquipos()->updateExistingPivot($equipoId, ['titulo' => $request->input('titulo')]);

        return response()->json(['message' => 'Título actualizado correctamente']);
    }

    public function storeSistemaEquipo(Request $request, $buqueId) {
        $request->validate([
            'mfun' => 'required|unique:sistemas_equipos,mfun|regex:/^[0-9]{4}[0-9A-Za-z]$/',
            'titulo' => 'required|string|max:255',
        ]);

        $buque = Buque::findOrFail($buqueId);

        $equipo = SistemasEquipos::firstOrCreate(
            ['mfun' => $request->mfun],
            ['titulo' => $request->titulo]
        );

        if (!$buque->sistemasEquipos->contains($equipo->id)) {
            $buque->sistemasEquipos()->attach($equipo->id, ['mec' => null]);
        }

        return response()->json(['message' => 'Equipo agregado correctamente', 'equipo' => $equipo]);
    }

    public function saveObservations(Request $request, Buque $buque, $equipoId) {
        $observaciones = $request->input('observaciones');
        $buque->sistemasEquipos()->updateExistingPivot($equipoId, ['observaciones' => json_encode($observaciones)]);

        return response()->json(['success' => true]);
    }

    public function exportPdf($buqueId) {
        $buque = Buque::findOrFail($buqueId);
        $sistemasEquipos = $buque->sistemasEquipos;

        $pdf = Pdf::loadView('buques.pdf', compact('buque', 'sistemasEquipos'))
                  ->setPaper('letter', 'portrait');

        return $pdf->stream('GRES_' . $buque->nombre_proyecto . '.pdf');
    }

    public function showPdf($buqueId) {
        $buque = Buque::findOrFail($buqueId);
        return view('buques.view-pdf', compact('buque'));
    }

    public function showGres2($buque)
    {
        return view('buques.gres2', compact('buque'));
    }

    public function deleteCollaborator($id) {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->delete();

        return response()->json(['message' => 'Colaborador eliminado correctamente']);
    }
}
