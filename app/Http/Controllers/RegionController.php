<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Models\User;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        //Protege la creación (create, store), edición (edit, update) y eliminación (destroy)
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('verified')->only('zonaVip');
    }

    public function zonaVip()
    {
        $mensajeVip = 'Has demostrado ser un alma digna de la confianza del Reino. En la Forja, tus habilidades se pulirán.';
        $usuarios = User::all();
        return view('region.areaVip', [
            'mensajeVip' => $mensajeVip,
            'usuarios' => $usuarios
        ]);
    }
    public function index()
    {
        $regiones = Region::all();
        return view('region.index', ["regiones" => $regiones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('region.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'nombre' => 'required|string|max:255|unique:region,nombre',
        'poblacion' => 'nullable|int|min:0|',
        'dificultad' => 'required|in:facil,media,dificil',
        'image' => 'nullable|image|max:2048'
        ]);

        $region = new Region($validatedData);
        $result = false;
        $txtmessage = 'Error desconocido al forjar la región.';
        
        try {
            $result = $region->save(); 
            if($request->hasFile( 'image')) {
                $ruta = $this->upload($request, $region);
                $region->image = $ruta;
                $region->save();
                $txtmessage = '¡Región forjada con éxito! El camino ha sido iluminado.';
            }

        } catch (UniqueConstraintViolationException $e) {
            $txtmessage = 'Error: Ya existe una región con este nombre (Clave única duplicada).';
        } catch (QueryException $e) {
            $txtmessage = 'Error de Base de Datos: Verifique los campos obligatorios.';
        } catch (\Exception $e) {
            $txtmessage = 'Error inesperado: ';
        }
        
        $messageArray = [
            'mensajeTexto' => $txtmessage
        ];

        if ($result) {
            return redirect()->route('regiones.index')->with('success', $messageArray);
        } else {
            // Si falla el guardado en DB, redirigimos y mantenemos el input
           return back()->withInput()->withErrors($messageArray);
        }
    }

    private function upload(Request $request, Region $region): string {
        $image = $request->file('image');
        $name = $region->id . '.' . $image->getClientOriginalExtension();
        $ruta = $image->storeAs('region', $name, 'public');
        return $ruta;
    }

    public function landingPage(){
        $welcomeMessage = '¡Bienvenidos al Santuario del Enlace! El camino es largo y lleno de peligros.';
        return view('region.landingPage', compact('welcomeMessage'));
    }

    public function show(region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, region $region)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(region $region)
    {
        //
    }

    function zona (Region $region){
      $zonas = $region->zonas;
      return view('zona.index', ['region' => $region,"zonas"=>$zonas]);
    }
}
