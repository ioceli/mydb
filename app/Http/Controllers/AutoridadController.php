<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\BitacoraHelper;
use App\Models\Plan;
use App\Models\Programa;
use App\Models\Proyecto;

class AutoridadController extends Controller
{
    public function index()
        {
        $planes = Plan::with('objetivosEstrategicos', 'metasEstrategicas')->get();
        $programas = Programa::with('objetivosEstrategicos', 'metasEstrategicas')->get();
        $proyectos = Proyecto::with('objetivosEstrategicos', 'metasEstrategicas')->get();

        return view('autoridad.index', compact('planes', 'programas', 'proyectos'));
    }

    public function cambiarEstado(Request $request, $tipo, $id)
    {
        BitacoraHelper::registrar('Autoridad', 'Ha cambiado el estado de ' . $tipo . ' con ID ' . $id);
         $modelos = [
            'planes' => \App\Models\Plan::class,
            'programas' => \App\Models\Programa::class,
            'proyectos' => \App\Models\Proyecto::class,
        ];

        if (!array_key_exists($tipo, $modelos)) {
            abort(404, 'Tipo inválido');
        }

        $modelo = $modelos[$tipo];
        $instancia = $modelo::findOrFail($id);
        $instancia->estado_autoridad = $request->estado_autoridad;
        $instancia->save();

        return redirect()->route('autoridad.index')->with('success', ucfirst($tipo) . ' actualizado correctamente.');
    }
    }
